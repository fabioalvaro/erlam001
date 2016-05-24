<?php
require_once('config.php');
session_start();
if(!isset($_SESSION['usuario']['idusuario'])){
  header('Location:acesso_negado.html');
}
   $conn = mysqli_connect(db_host, db_user, db_pass, db_base);
    $sql="select * from alunos where codParceiro=".$_SESSION['usuario']['codParceiro'];
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
<h1>Sistema - Consulta Alunos</h1>
<h1>Cód. Parceiro: <?php echo $_SESSION['usuario']['codParceiro'];?></h1>


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
      <td> <a href='visualiza_aluno.php?cmd=consulta&idaluno=".  base64_encode($linha['idaluno'])."'>Visualizar</a>  </td>
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