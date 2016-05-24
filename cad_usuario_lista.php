<?php
require_once('config.php');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    $conn = mysqli_connect(db_host, db_user, db_pass, db_base);
    $sql="select * from usuarios";
    $res = mysqli_query($conn,$sql);    
   
    
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Erlan001 - Cad Usuário Lista</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script src="js/jquery-1.10.2.min.js"></script>  
    <script src="js/usuario/cad_usuario_lista.js"></script>    
  </head>
  <body>
    <div>
<h1>Sistema - Cadastro Usuario - Listagem</h1>


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
      <td>".$linha['idusuario']."</td>
      <td>".$linha['nome']."</td>
      <td>".$linha['tipo']."</td>
      <td>".$linha['codParceiro']."</td>
      <td> <a href='cad_usuario.php?cmd=edita&cod=".$linha['idusuario']."'>Editar</a>  <a href='#' onclick='confirma_excluir(".$linha['idusuario'].")'>Excluir </a></td>
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