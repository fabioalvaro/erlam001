$(document).ready(function() {
  $("#data_cadastro").datepicker({dateFormat: "dd/mm/yy"});
  $("#data_nascimento").datepicker({dateFormat: "dd/mm/yy"});
  $("#data_treinamento").datepicker({dateFormat: "dd/mm/yy"});



  $("#form-aluno").submit(function(event) {
    if (($("#nome").val() !== "")
            && ($("#sobrenome").val() !== "")
            && ($("#data_nascimento").val() !== "")
            && ($("#data_treinamento").val() !== "")
            && ($("#cpf").val() !== "")
            )
    {
      $("span").text("Aluno Salvo com sucesso!").show();
      return;
    }

    $("span").text("Preencha todos os campos!").show().fadeOut(2000);
    event.preventDefault();
  });


  //upload

$('#form-upload').ajaxForm({beforeSubmit: validate});

  var bar = $('.bar');
  var percent = $('.percent');
  var status = $('#status');

  $('#form-upload').ajaxForm({
    beforeSend: function() {
      status.empty();
      var percentVal = '0%';
      bar.width(percentVal)
      percent.html(percentVal);
    },
    beforeSubmit: validate,
    uploadProgress: function(event, position, total, percentComplete) {
      var percentVal = percentComplete + '%';
      bar.width(percentVal)
      percent.html(percentVal);
    },
    success: function() {
      var percentVal = '100%';
      bar.width(percentVal)
      percent.html(percentVal);
    },
    complete: function(xhr) {
      status.html(xhr.responseText);
      carrega_arquivos();
      $("#file").val('');
    }
  });

  

//carrega os arquivos
carrega_arquivos();
});

function validate(formData, jqForm, options) {
  if ($("#file").val() === '') {
    alert('Selecione um arquivo antes de subir');
    return false;
  }
}


function carrega_arquivos(){
  var url='cad_aluno.php?cmd=busca_arquivos&idaluno='+$('#idaluno').val();
  $.post(url,function(data){
    $('#tbody_arquivos').html(data);
  });
}

function excluiArquivo(idarquivo){
  var url='cad_aluno.php?cmd=exclui_arquivo&idarquivo='+idarquivo;
  $.post(url,function(data){    
    carrega_arquivos();
  }); 
  
  
}