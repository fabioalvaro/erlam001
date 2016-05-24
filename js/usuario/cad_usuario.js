$(document).ready(function() {
  $("#form-usuario").submit(function(event) {
    if( ($("#nome").val() !== "") && ($("#senha").val() !== "")    )
    {
      $("span").text("Salvo com sucesso!").show();
      return;
    }

    $("span").text("Preencha todos os campos!").show().fadeOut(2000);
    event.preventDefault();
  });

});

