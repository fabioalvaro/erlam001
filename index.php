<?php
require_once('config.php');
session_start();
if(!isset($_SESSION['usuario']['idusuario'])){
  header('Location:index.html');
}
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if( isset($_GET['cmd'])){
  if ($_GET['cmd']=='sair'){
    //mata a sessao
    limpa_sessao();
    header('Location: index.html');
  }
  if ($_GET['cmd']=='login'){
    //var_dump($_POST);
    $ret = valida($_POST['usuario'],$_POST['senha']);
    if ($ret==false) {
      header('Location: index.html?erro=usuario invalido');
    }else{
      header('Location: home.php');
    }
    //mata a sessao
    //header('Location: index.html');
  }
  
}

function valida($user='',$senha=''){
    $conn = mysqli_connect(db_host, db_user, db_pass, db_base);
    $sql="select * from usuarios where nome='".$user."'";
    $result=mysqli_query($conn,$sql);    
    $resp = mysqli_fetch_assoc($result);
    
    if (sizeof($resp)==0){
      return false;    
    }else{
      if ($resp['senha']==$senha){
        session_start();
        $_SESSION['usuario']['idusuario']=1;
        $_SESSION['usuario']['nome']=$resp['nome'];
        $_SESSION['usuario']['tipo']=$resp['tipo'];
        $_SESSION['usuario']['codParceiro']=$resp['codParceiro'];
        return true;  
      }else{
        return false;      
      }            
    }    
    
    mysqli_close($conn);

}

function limpa_sessao(){
    // Initialize the session.
    // If you are using session_name("something"), don't forget it now!
    session_start();

    // Unset all of the session variables.
    $_SESSION = array();

    // If it's desired to kill the session, also delete the session cookie.
    // Note: This will destroy the session, and not just the session data!
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time()-42000, '/');
    }

    // Finally, destroy the session.
    session_destroy();  
}


echo 'chegou!"';

?>
