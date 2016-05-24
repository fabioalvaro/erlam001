$(document).ready(function() {


});

function confirma_excluir(idregistro){
  var r = confirm("Deseja excluir o Registro "+idregistro+" ?");
  if (r == true)
    {
    remove_registro(idregistro);
    }  
}

function remove_registro(idregistro){
  var url='cad_usuario.php?cmd=exclui&cod='+idregistro;
  $.post(url,function(){
    window.location='cad_usuario_lista.php';  
  });
  
}

