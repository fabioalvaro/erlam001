<?php
require_once('config.php');
session_start();
if(!isset($_SESSION['usuario']['idusuario'])){
  header('Location:acesso_negado.html');
}
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
   $conn = mysqli_connect(db_host, db_user, db_pass, db_base);
    $sql="select * from alunos";
    $res = mysqli_query($conn,$sql);    
   
    
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Erlan001 - Cad Aluno Lista</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script src="js/jquery-1.10.2.min.js"></script>  
    <script src="js/aluno/cad_aluno_lista.js"></script>    
  </head>
  <body>
    <div>
<h1>Sistema - Cadastro Aluno - Listagem</h1>


<table border="1">
  <thead>
    <tr>
      <th>Código</th>
      <th>Nome</th>
      <th>Tipo</th>
      <th>CodParceiro</th>
      <th>Ação</th>
    </tr>
  </thead>
  <tbody>
    <?php
    while ($linha = mysqli_fetch_assoc($res)) {       
    echo "<tr>
      <td>".$linha['idaluno']."</td>
      <td>".$linha['nome']."</td>
      <td>".$linha['sobrenome']."</td>
      <td>".$linha['codParceiro']."</td>
      <td> <a href='cad_aluno.php?cmd=edita&cod=".$linha['idaluno']."'>Editar</a>  <a href='#' onclick='confirma_excluir(".$linha['idaluno'].")'>Excluir </a></td>
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