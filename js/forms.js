/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function check(input) {
if (input.value != document.getElementById('password').value) {
input.setCustomValidity('Las contraseñas no coinciden!');
} else {
// input is valid -- reset the error message
input.setCustomValidity('');
}
}

function check2(input) {
if (input.value != document.getElementById('password_repeat').value) {
    var item = document.getElementById('password_repeat');
item.setCustomValidity('Las contraseñas no coinciden!');
} else {
// input is valid -- reset the error message
input.setCustomValidity('');
}
check(item);
}

function emailExists(){
    document.getElementById('email').setCustomValidity('User exists!');
}

function terms(){
    Shadowbox.open({
        content:    '<div><b>1. Responsabilidad del usuario </b></div>'
                  + '<div>El usuario promete ser un noob</div>',
        player:     "html",
        title:      "Terminos y condiciones de servicio:",
        height:     550,
        width:      550
    });
}