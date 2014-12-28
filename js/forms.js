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