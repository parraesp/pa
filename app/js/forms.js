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

function terms() {
    Shadowbox.open({
        content: '<div><b>1. Responsabilidad del usuario </b></div>'
                + '<div>El usuario promete ser un noob</div>',
        player: "html",
        title: "Terminos y condiciones de servicio:",
        height: 550,
        width: 550
    });
}

function factura(estado, fecha, deudores){
     Shadowbox.open({
        content: '<div>Estado: '+estado+'</div>'
                + '<div>Fecha: '+new Date(fecha*1000)+'</div>',
        player: "html",
        title: "Ver Factura",
        height: 250,
        width: 250
    });
}

function crearFactura(user){
    var tiempo  = new Date();
    Shadowbox.open({
        content: '<br><div>Detalles: </div>'
                + '<p>Fecha: <strong>' + tiempo + '</strong></p>'
                + '<form action="facturas.php" method="post">\n\
                <input type="text" placeholder="Nombre de la factura" name="nombre">\n\
                <input type="number" placeholder="P.Ej: 8,87" name="valor">€<br>\n\
                <input type="submit" value="Enviar" name="solicitud">\n\
                <input type ="hidden" name="creador" value="'+user+'">\n\
                <input type ="hidden" name="fecha" value="'+tiempo.getSeconds()+'">\n\
                </form>',
        player: "html",
        title: 'Crear Factura',
        height: 550,
        width: 550,
        options: { enableKeys: false }
    });
}
function SendRequest(desc, dueno, user) {
    Shadowbox.open({
        content: '<br><div>Descripci&oacute;n: </div>'
                + '<p>Due&ntilde;o <strong>' + dueno + '</strong></p>'
                + '<p><em>' + desc + '</em></p>'
                + '<div>&iquest;Es el piso que buscabas? &iexcl;M&aacute;ndale una solicitud!</div>'
                + '<form action="reg.php" method="post">\n\
                <textarea id="shadowbox_contenido" name="contenido" autofocus></textarea><br>\n\
                <input type="submit" value="Enviar" name="solicitud">\n\
                <input type ="hidden" name="autor" value="'+user+'">\n\
                <input type ="hidden" name="recep" value="'+dueno+'">\n\
                </form>',
        player: "html",
        title: 'Enviar solicitud',
        height: 550,
        width: 550,
        options: { enableKeys: false }
    });
}

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.watchPosition(showPosition);
    } else {
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function showPosition(position) {
    var t = position.coords.latitude + " " +
            position.coords.longitude;
    setToForm(t);
}

function setToForm(t) {
    var elem = document.getElementById("coord");
    elem.value = t;
}