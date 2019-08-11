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

function urlB64ToUint8Array(base64String) {
  const padding = '='.repeat((4 - base64String.length % 4) % 4);
  const base64 = (base64String + padding)
    .replace(/\-/g, '+')
    .replace(/_/g, '/');

  const rawData = window.atob(base64);
  const outputArray = new Uint8Array(rawData.length);

  for (let i = 0; i < rawData.length; ++i) {
    outputArray[i] = rawData.charCodeAt(i);
  }
  return outputArray;
}

Fingerprint2.get({}, function (components) {
  components.splice(components.findIndex(i => i.key === 'deviceMemory'), 1);
  let values = components.map(function (component) { return component.value });
  let murmur = Fingerprint2.x64hash128(values.join(''), 31);
  localStorage.setItem('fingerprint', murmur);
});