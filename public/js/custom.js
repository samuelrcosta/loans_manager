$('.phone-format').mask('(00) 0000-00009');
$('.phone-format').blur(function(event) {
  if($(this).val().length == 15){ // Celular com 9 dígitos + 2 dígitos DDD e 4 da máscara
    $(this).mask('(00) 00000-0009');
  } else {
    $(this).mask('(00) 0000-00009');
  }
});

$('.currency-format').mask("#.##0,00", {reverse: true});
$('.number-format').mask("0#");