<?php
require_once('config.php');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//$_SESSION['usuario']['idusuario']=1;
//$_SESSION['usuario']['nome']='Fabio';
//$_SESSION['usuario']['tipo']='U';
//$_SESSION['usuario']['codParceiro']=7777;
session_start();
if(!isset($_SESSION['usuario']['idusuario'])){
  header('Location:acesso_negado.html');
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Erlan001 - Home</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  </head>
  <body>
    <div>
<h1>Home - Sistema</h1>
<h2>Info: <?php echo $_SESSION['usuario']['nome'];?> Código: <?php echo $_SESSION['usuario']['idusuario'];?></h2>
<br>
<?php if($_SESSION['usuario']['tipo']=='U') :?>
    Cadastro de Usuarios <a href="cad_usuario.php"> Novo </a> <a href="cad_usuario_lista.php"> Listar</a><br>
    Cadastro de Alunos <a href="cad_aluno.php"> Novo </a> <a href="cad_aluno_lista.php"> Listar</a><br>
<?php endif; ?>  
  
<?php if($_SESSION['usuario']['tipo']=='C') :?>
    Cadastro de Alunos <a href="consulta_alunos_lista.php"> Listar</a> <br>    
<?php endif; ?>  
  
    Cadastro de Alunos <a href="cad_aluno_busca.php"> Buscar</a> <br>    
    
<br><a href="index.php?cmd=sair">Sair</a><br>      
    </div>
  </body>
</html>