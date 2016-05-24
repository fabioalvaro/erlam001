<?php
require_once('config.php');
session_start();
if(!isset($_SESSION['usuario']['idusuario'])){
  header('Location:acesso_negado.html');
}
   $idaluno = base64_decode($_GET['idaluno']);
   $conn = mysqli_connect(db_host, db_user, db_pass, db_base);
    $sql="select * from alunos where idaluno=".$idaluno;
    $res_aluno = mysqli_query($conn,$sql);    
    $linha = mysqli_fetch_assoc($res_aluno);
    $sql="select * from arquivos where idaluno=".$idaluno;
    $res_arquivos = mysqli_query($conn,$sql);    
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Erlan001 - Visualiza Aluno </title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script src="js/jquery-1.10.2.min.js"></script>  
    <script src="js/aluno/cad_aluno_lista.js"></script>    
  </head>
  <body>
    <div>
<h1>Visualiza Aluno</h1>
<table border="1">
  <tbody>    
    <tr><td>Código</td><td><?php echo $linha['idaluno']?></td></tr>
    <tr><td>Nome</td><td><?php echo $linha['nome']?></td></tr>
    <tr><td>Sobrenome</td><td><?php echo $linha['sobrenome']?></td></tr>
    <tr><td>CPF</td><td><?php echo $linha['cpf']?></td></tr>
    <tr><td>Data nascimento</td><td><?php echo $linha['data_nascimento']?></td></tr>
    <tr><td>Data Cadastro</td><td><?php echo $linha['data_cadastro']?></td></tr>
    <tr><td>Data Treinamento</td><td><?php echo $linha['data_nascimento']?></td></tr>
    <tr><td>Cód.Parceiro</td><td><?php echo $linha['codParceiro']?></td></tr>
    <tr><td>Arquivos</td>
      <td>
        <table border="1">
      <?php
      while ($linha_file = mysqli_fetch_assoc($res_arquivos)){
       echo "<tr><td><a href='".dir_arquivos.$linha_file['caminho']."'>". $linha_file['caminho']."</a></td></tr>";
      }
      ?>        
       </table>
      </td>
    </tr>
  </tbody>
</table>

<hr>
<a href="consulta_alunos_lista.php">Voltar</a><br>      
    </div>
  </body>
</html>
<?php mysqli_close($conn);?>