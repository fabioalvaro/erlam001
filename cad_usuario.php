<?php
require_once('config.php');

if (sizeof($_POST) > 0) {
  if ($_POST['idusuario'] == '') {
   $conn = mysqli_connect(db_host, db_user, db_pass, db_base);
    $sql = "insert into usuarios (nome,senha,tipo,codParceiro) values ('" . $_POST['nome'] . "','" . $_POST['senha'] . "','" . $_POST['tipo'] . "','" . $_POST['codParceiro'] . "')";
    mysqli_query($conn, $sql);
    mysqli_close($conn);
    //echo 'novo';  
  }
  else {
    //echo 'update';  
    $conn = mysqli_connect(db_host, db_user, db_pass, db_base);
    $sql = "update usuarios SET nome = '" . $_POST['nome'] . "',
                              senha = '" . $_POST['senha'] . "',
                              tipo = '" . $_POST['tipo'] . "',
                              codParceiro = '" . $_POST['codParceiro'] . "'
                              where idusuario=" . $_POST['idusuario'];
    mysqli_query($conn, $sql);
    mysqli_close($conn);
  }
  header('Location: cad_usuario_lista.php');
}
if (isset($_GET['cmd'])) {
  if ($_GET['cmd'] == 'exclui') {
    if (isset($_GET['cod'])) {
      // echo 'opa '.$_GET['cod'];die;
      $conn = mysqli_connect(db_host, db_user, db_pass, db_base);
      $sql = "delete from usuarios where idusuario=" . $_GET['cod'];
      mysqli_query($conn, $sql);
      mysqli_close($conn);
      die;
    }
  }
}

/*Edição*/
if (isset($_GET['cod'])){
  $conn = mysqli_connect(db_host, db_user, db_pass, db_base);
  $sql = "select * from usuarios where idusuario=" . $_GET['cod'];
  $res = mysqli_query($conn, $sql);
  $linha = mysqli_fetch_assoc($res);

  $registro['idusuario'] = $linha['idusuario'];
  $registro['nome'] = $linha['nome'];
  $registro['tipo'] = $linha['tipo'];
  $registro['senha'] = $linha['senha'];
  $registro['codParceiro'] = $linha['codParceiro'];
}
else {
  //Novo Registro
  $registro['idusuario'] = '';
  $registro['nome'] = '';
  $registro['tipo'] = '';
  $registro['senha'] = '';
  $registro['codParceiro'] = '';
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Erlan001 - Home</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script src="js/jquery-1.10.2.min.js"></script>  
    <script src="js/usuario/cad_usuario.js"></script>
  </head>
  <body>
    <div>
      <h1>Sistema - Cadastro Usuario</h1>
      <form name="form-usuario" id="form-usuario" action="" method="POST">
        <input type="hidden" name="idusuario" value="<?php echo $registro['idusuario']; ?>" /><br>
        <label>Nome</label><input type="text" name="nome" id="nome" value="<?php echo $registro['nome']; ?>" /><br>
        <label>Senha</label><input type="text" name="senha" id="senha" value="<?php echo $registro['senha']; ?>" /><br>
        <label>Tipo</label><select name="tipo" id="tipo">
          <option value="U" <?php if ($registro['tipo'] == 'U') echo 'selected="selected"'; ?>>Usuário Administrador</option>
          <option value="C" <?php if ($registro['tipo'] == 'C') echo 'selected="selected"'; ?>>Cliente</option>  
        </select><br>
        <label>Cód. Parceiro</label>

        <input type="text" name="codParceiro" value="<?php echo $registro['codParceiro']; ?>" />
        <br>
        <input type="submit" value="salvar" name="btnsalvar" />

      </form>
      <span></span>
      <hr>
      <a href="home.php">Voltar</a><br>      
    </div>
  </body>
</html>