<?php
require_once('config.php');
session_start();
if (!isset($_SESSION['usuario']['idusuario'])) {
  header('Location:acesso_negado.html');
}


if (sizeof($_POST) > 0) {
  if ($_POST['idaluno'] == '') {
    $conn = mysqli_connect(db_host, db_user, db_pass, db_base);
    $sql = "insert into alunos (nome,sobrenome,data_cadastro,data_nascimento,
      data_treinamento,cpf,cargo,codParceiro) 
      values ('" . $_POST['nome'] . "','"
            . $_POST['sobrenome'] . "','"
            . datePTbrToEn($_POST['data_cadastro']) . "','"
            . datePTbrToEn($_POST['data_nascimento']) . "','"
            . datePTbrToEn($_POST['data_treinamento']) . "','"
            . $_POST['cpf'] . "','"
            . $_POST['cargo'] . "','"
            . $_POST['codParceiro'] . "')";
    mysqli_query($conn, $sql);
    mysqli_close($conn);
    //echo 'novo';  
  }
  else {
    //echo 'update';  
    $conn = mysqli_connect(db_host, db_user, db_pass, db_base);
    $sql = "update alunos SET nome = '" . $_POST['nome'] . "',"
            . " sobrenome = '" . $_POST['sobrenome'] . "',"
            . " data_cadastro = '" . datePTbrToEn($_POST['data_cadastro']) . "',"
            . " data_nascimento = '" . datePTbrToEn($_POST['data_nascimento']) . "',"
            . " data_treinamento = '" . datePTbrToEn($_POST['data_treinamento']) . "',"
            . " cpf = '" . $_POST['cpf'] . "',"
            . " cargo = '" . $_POST['cargo'] . "',"
            . " codParceiro = '" . $_POST['codParceiro'] . "' where idaluno=" . $_POST['idaluno'];

    mysqli_query($conn, $sql);
    //echo $sql;die;
    mysqli_close($conn);
  }
   header('Location: cad_aluno_lista.php');
}
if (isset($_GET['cmd'])) {
  if ($_GET['cmd'] == 'exclui') {
    if (isset($_GET['cod'])) {
      // echo 'opa '.$_GET['cod'];die;
      $conn = mysqli_connect(db_host, db_user, db_pass, db_base);
      $sql = "delete from alunos where idaluno=" . $_GET['cod'];
      mysqli_query($conn, $sql);
      mysqli_close($conn);
      die;
    }
  }
  // upload
  if ($_GET['cmd'] == 'busca_arquivos') {
    $idAluno = $_GET['idaluno'];
    $conn = mysqli_connect(db_host, db_user, db_pass, db_base);
    $sql = "select * from arquivos where idaluno=" . $idAluno;

    $res = mysqli_query($conn, $sql);
    $conta = 0;
    if ($res)
      while ($linha = mysqli_fetch_assoc($res)) {
        echo "<tr><td><a href='" . dir_arquivos . $linha['caminho'] . "'>" . $linha['caminho'] . "</a></td>";
        echo "<td><a href='#' onclick='excluiArquivo(" . $linha['idarquivo'] . ")'>Excluir</a></td></tr>";
        $conta++;
      };

    if ($conta == 0) {
      echo "<tr><td>Não existem Arquivos</td><td>--</tr>";
    }
    die;
  }

  if ($_GET['cmd'] == 'exclui_arquivo') {
    $idarquivo = $_GET['idarquivo'];
    $conn = mysqli_connect(db_host, db_user, db_pass, db_base);
    //apago o arquivo
    $sql = "select caminho from arquivos where idarquivo=" . $idarquivo;
    $res = mysqli_query($conn, $sql);
    $linha = mysqli_fetch_assoc($res);
    $arquivo_nome = $linha['caminho'];
    if (file_exists(dir_arquivos . $arquivo_nome)) {
      unlink(dir_arquivos . $arquivo_nome);
    }

    //Apago o registro
    $sql = "delete from arquivos where idarquivo=" . $idarquivo;
    $res = mysqli_query($conn, $sql);
    die;
  }
}

//Lista Parceiros
$connP = mysqli_connect(db_host, db_user, db_pass, db_base);
$sqlP = "select CodParceiro,nome from usuarios
          where tipo='C'
          group by CodParceiro
          order by nome";
$resP = mysqli_query($connP, $sqlP);
while ($linhaP = mysqli_fetch_assoc($resP)) {
  $lista_parceiros[$linhaP['CodParceiro']] = $linhaP['nome'];
}

/* Edição */
if (isset($_GET['cod'])) {
  $conn = mysqli_connect(db_host, db_user, db_pass, db_base);
  $sql = "select * from alunos where idaluno=" . $_GET['cod'];
  $res = mysqli_query($conn, $sql);
  $linha = mysqli_fetch_assoc($res);



  $registro['idaluno'] = $linha['idaluno'];
  $registro['nome'] = $linha['nome'];
  $registro['sobrenome'] = $linha['sobrenome'];
  $registro['data_cadastro'] = dateEnToPTbr($linha['data_cadastro']);
  $registro['data_nascimento'] = dateEnToPTbr($linha['data_nascimento']);
  $registro['data_treinamento'] = dateEnToPTbr($linha['data_treinamento']);
  $registro['cpf'] = $linha['cpf'];
  $registro['cargo'] = $linha['cargo'];
  $registro['codParceiro'] = $linha['codParceiro'];
}
else {
  //Novo Registro
  $registro['idaluno'] = '';
  $registro['nome'] = '';
  $registro['sobrenome'] = '';
  $registro['data_cadastro'] = date('d/m/Y');
  $registro['data_nascimento'] = '';
  $registro['data_treinamento'] = '';
  $registro['cpf'] = '';
  $registro['cargo'] = '';
  $registro['codParceiro'] = '';
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Erlan001 - Home</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="js/jquery-ui/css/ui-lightness/jquery-ui-1.10.3.custom.min.css">
    <script src="js/jquery-1.10.2.min.js"></script>  
    <script src="js/jquery-ui/js/jquery-ui-1.10.3.custom.min.js"></script> 
    <script src="js/jquery.form.min.js"></script>    
    <script src="js/aluno/cad_aluno.js"></script>
    <style>
      body { padding: 30px }
      form { display: block; margin: 20px auto; background: #eee; border-radius: 10px; padding: 15px }

      .progress { position:relative; width:400px; border: 1px solid #ddd; padding: 1px; border-radius: 3px; }
      .bar { background-color: #B4F5B4; width:0%; height:20px; border-radius: 3px; }
      .percent { position:absolute; display:inline-block; top:3px; left:48%; }
    </style>    
  </head>
  <body>
    <div>
      <h1>Sistema - Cadastro Aluno</h1>
      <form name="form-aluno" id="form-aluno" action="" method="POST">
        <fieldset>
          <legend>Dados</legend>
          <input type="hidden" name="idaluno" id="idaluno" value="<?php echo $registro['idaluno']; ?>" /><br>
          <label>Nome</label><input type="text" name="nome" id="nome" value="<?php echo $registro['nome']; ?>" /><br>

          <label>Sobrenome</label>
          <input type="text" name="sobrenome" id="sobrenome" value="<?php echo $registro['sobrenome']; ?>" /><br>

          <label>Data Cadastro</label>
          <input type="text" name="data_cadastro" id="data_cadastro" value="<?php echo $registro['data_cadastro']; ?>" /><br>


          <label>Data Nascimento</label>
          <input type="text" name="data_nascimento" id="data_nascimento" value="<?php echo $registro['data_nascimento']; ?>" /><br>


          <label>Data treinamento</label>
          <input type="text" name="data_treinamento" id="data_treinamento" value="<?php echo $registro['data_treinamento']; ?>" /><br>

          <label>CPF</label>
          <input type="text" name="cpf" id="cpf" value="<?php echo $registro['cpf']; ?>" size="11" maxlength="11"/>*Apenas números ex: 26721993877 <br>

          <label>Cargo</label>
          <input type="text" name="cargo" id="cargo" value="<?php echo $registro['cargo']; ?>" /><br>

          <label>Cod Parceiro</label>

          <select name="codParceiro" id="codParceiro">
            <?php
            foreach ($lista_parceiros as $key => $value) {
              $sel = '';
              if ($registro['codParceiro'] == $key) {
                $sel = "selected='selected'";
              }
              echo "<option value='" . $key . "' " . $sel . " >" . $key . ' - ' . $value . "</option>";
            }
            ?>          
          </select><br>
        </fieldset>
        <fieldset>
          <legend>Arquivos</legend>

          <table border="1">
            <thead>
              <tr>
                <th>Arquivo</th>              
                <th>Ação</th>
              </tr>
            </thead>
            <tbody id="tbody_arquivos">
              <tr>              
                <td>lixo.doc</td>
                <td><a href="#">Excluir</a></td>
              </tr>            
            </tbody>
          </table>
          </br>

          <span id="ret_arquivo"></span>
        </fieldset>
        <input type="submit" value="salvar" name="btnsalvar" />


      </form>
      <h2>Enviar Arquivos</h2>	
      <form id="form-upload" name="form-upload" action="sobearquivo.php" method="post" enctype="multipart/form-data">
        <input type="file" name="file" id="file"><br>
        <input type="hidden" name="idaluno_upload" value="<?php echo $registro['idaluno']; ?>" />        
        <?php if ($registro['idaluno'] !== ''): ?>
          <input type="submit" value="Enviar o Arquivo">
        <?php endif; ?>
        <?php if ($registro['idaluno'] === ''): ?>
          <br><label>Somente é possível enviar arquivos após criar o aluno.</label>
        <?php endif; ?>          

      </form>
      <?php if ($registro['idaluno'] !== ''): ?>
        <div class="progress">
          <div class="bar"></div >
          <div class="percent">0%</div >
        </div>
      <?php endif; ?>
      <div id="status"></div>
      <hr>
      <a href="home.php">Voltar</a><br>   




    </div>
  </body>
</html>