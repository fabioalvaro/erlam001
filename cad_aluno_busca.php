<?php
require_once('config.php');
session_start();
if(!isset($_SESSION['usuario']['idusuario'])){
  header('Location:acesso_negado.html');
}
$limitaCliente='';
if ($_SESSION['usuario']['tipo']=='C'){
  $limitaCliente=" AND codParceiro='".$_SESSION['usuario']['codParceiro']."'";
};
       

$text_search='';
if (isset($_POST['texto'])&&($_POST['texto']!='')){   
  $text_search=$_POST['texto'];
}

    $conn = mysqli_connect(db_host, db_user, db_pass, db_base);
    $sql="select * from alunos where 
      (upper(nome) like upper('%".$text_search."%')
      OR  upper(sobrenome) like upper('%".$text_search."%'))".$limitaCliente;
    $res = mysqli_query($conn,$sql);       

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Erlan001 - Cad Aluno Busca</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script src="js/jquery-1.10.2.min.js"></script>  
    <script src="js/usuario/cad_aluno_lista.js"></script>    
  </head>
  <body>
    <div>
<h1>Sistema - Cadastro Aluno - Busca</h1>
<form name="form-busca" method="POST" enctype="multipart/form-data">

Nome do Aluno:<input type="text" name="texto" value="<?php echo $text_search;?>" /><input type="submit" value="Buscar" />
</form>
<hr>

<table border="1">
  <thead>
    <tr>
      <th>Código</th>
      <th>Nome</th>
      <th>Sobrenome</th>
      <th>CodParceiro</th>
      <th>Ação</th>
    </tr>
  </thead>
  <tbody>
    <?php
    if ($res)
    while ($linha = mysqli_fetch_assoc($res)) {       
      echo "<tr>
        <td>".$linha['idaluno']."</td>
        <td>".$linha['nome']."</td>
        <td>".$linha['sobrenome']."</td>
        <td>".$linha['codParceiro']."</td>
        <td> <a href='cad_aluno.php?cmd=edita&cod=".$linha['idaluno']."'>Editar</a>  <a href='#' onclick='confirma_excluir(".$linha['idaluno'].")'>Excluir </a></td>
      </tr>";
    }
    else{
      echo "<tr>
        <td colspan=5>Não foram encontrados Resultados</td>        
      </tr>";
    }
    ?>    

  </tbody>
</table>

<hr>
<a href="home.php">Voltar</a><br>      
    </div>
  </body>
</html>
<?php mysqli_close($conn);?>