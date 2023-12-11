var cc_number_saved = "";
function validar(input){
  var elemento = document.getElementById("cardNumber").value;
  if (/(4[0-9]{12}(?:[0-9]{3})?)/.test(elemento)) {
    document.getElementById("cardlogo").classList.add("fa-cc-visa");
    document.getElementById("cardLogoTop").innerHTML = "<img class='img-responsive pull-right' src='https://i.imgur.com/iqIDYfz.png'>"
  }
  if (/3[47][0-9]{13}/.test(elemento)) {
    document.getElementById("cardlogo").classList.add("fa-cc-amex");
    document.getElementById("cardLogoTop").innerHTML = "<img class='img-responsive pull-right' src='https://i.imgur.com/WluzPvZ.png'>"
  }
  if (/5[1-5][0-9]{14}/.test(elemento)) {
    document.getElementById("cardlogo").classList.add("fa-cc-mastercard");
    document.getElementById("cardLogoTop").innerHTML = "<img class='img-responsive pull-right' src='https://i.imgur.com/1U8OBnM.png'>"
  }
  if (/6(?:011|5[0-9]{2})[0-9]{12}/.test(elemento)) {
    document.getElementById("cardlogo").classList.add("fa-cc-discover");
    document.getElementById("cardLogoTop").innerHTML = "<img class='img-responsive pull-right' src='https://i.imgur.com/H5lJRwk.png'>"
  }
  if(elemento == 0){
    document.getElementById("cardlogo").classList.remove("fa-cc-visa");
    document.getElementById("cardLogoTop").innerHTML = "<img class='img-responsive pull-right' src='https://i.imgur.com/gIMFDbp.png'>"
document.getElementById("cardlogo").classList.remove("fa-cc-amex");
document.getElementById("cardlogo").classList.remove("fa-cc-mastercard");
document.getElementById("cardlogo").classList.remove("fa-cc-discover");
  }
  // Luhn Algorithm
	var sum = 0;
  var numdigits = input.length;
  var parity = numdigits % 2;
  for(var i=0; i < numdigits; i++) {
    var digit = parseInt(input.charAt(i))
    if(i % 2 == parity) digit *= 2;
    if(digit > 9) digit -= 9;
    sum += digit;
  }
  return (sum % 10) == 0;
}
