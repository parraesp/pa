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

function factura(estado, fecha, pagado, param) {
    var t = ' <img src="images/tick.png"><br>&iexcl;Haz click aqu&iacute; para marcar como pagado!';
    if (pagado != "No pagada") {
        t = '<img src="images/cross.png"><br>Marcar como no pagado';
    }
    var k = '';
    if (param == 'true') {
        k = '<div><a href="facturas.php?fec=' + fecha + '&delete=true">&iquest;Borrar?</a></div>';
    }
    Shadowbox.open({
        content: '<div>Estado: ' + estado + '</div>'
                + '<div>Fecha: ' + new Date(fecha * 1000) + '</div>'
                + '<div>Tu parte: ' + pagado + '</div>' + k
                + '<div style="text-align:center;"><a href="facturas.php?fec=' + fecha + '&pay=' + pagado.substr(0, 1) + '">' + t + '</a></div>',
        player: "html",
        title: "Ver Factura",
        height: 250,
        width: 250
    });
}

function crearFactura(user) {
    var tiempo = new Date();
    Shadowbox.open({
        content: '<br><div>Detalles: </div>'
                + '<p>Fecha: <strong>' + tiempo + '</strong></p>'
                + '<form action="facturas.php" method="post">\n\
                <input type="text" placeholder="Nombre de la factura" name="nombre" required>\n\
                <input type="number" placeholder="P.Ej: 8,87" name="valor" required>€<br>\n\\n\
                                <input type ="hidden" name="creador" value="' + user + '">\n\
                <input type ="hidden" name="fecha" value="' + Math.floor(Date.now() / 1000) + '">\n\
                <input type="submit" value="Enviar" name="gast">\n\
                </form>',
        player: "html",
        title: 'Crear Factura',
        height: 550,
        width: 550,
        options: {enableKeys: false}
    });
}

function mostrarFormularioLimpieza() {
    $('#formularioLimpieza').toggle(2000);
}

function mostrarCuenta() {
    $('#datosPiso').toggle(1000);
    $('#datosUsuario').toggle(1000);
}

function mostrarPiso() {
    $('#datosUsuario').toggle(1000);
    $('#datosPiso').toggle(1000);
}

function aniadir_zonas(num) {
    var form = document.getElementById('formularioLimpieza');
    while (form.childNodes.length > 22) {
        form.removeChild(form.lastChild);
    }
    for (var i = 0; i < num.value; i++) {
        var nodoZona = document.createElement('input');
        nodoZona.setAttribute('type', 'text');
        nodoZona.setAttribute('name', 'zona' + i);
        var nodoLabel = document.createElement('label');
        nodoLabel.appendChild(document.createTextNode('Zona de limpieza: '));
        form.appendChild(nodoLabel);
        form.appendChild(nodoZona);
        form.appendChild(document.createElement('br'));
    }
    var nodoEnviar = document.createElement('input');
    nodoEnviar.setAttribute('type', 'submit');
    nodoEnviar.setAttribute('name', 'enviarLimpieza');
    nodoEnviar.setAttribute('value', 'Enviar');
    form.appendChild(nodoEnviar);
}

function contacto(id, nombre, telefono, email) {
    Shadowbox.open({
        content: '<div>Nombre: ' + nombre + '</div>'
                + '<div>Telefono: ' + telefono + '</div>'
                + '<div>Email: ' + email + '</div>'
                + '<a href="contactos.php?edit=' + id + '"><img src="images/edit.png" style="width:20%;height:30%;"></a>'
                + '<a href="contactos.php?delete=' + id + '"><img src="images/delete.png" style="width:20%;height:30%;"></a>',
        player: "html",
        title: "Contacto",
        height: 150,
        width: 250
    });
}

function  mensaje(autor, receptor, fecha, id, cuerpo) {
    Shadowbox.open({
        content: '<div>Autor: ' + autor + '</div>'
                + '<div>Receptor: ' + receptor + '</div>'
                + '<div>Fecha: ' + new Date(fecha * 1000) + '</div>'
                + '<div>Estado: ' + 'Pendiente' + '</div>'
                + '<div>Mensaje:<br> ' + cuerpo + '</div>'
                + '<div style="text-align:center;"><a href="home.php?accept=' + id + '"><img src="images/tick.png" style="width:20%;height:30%;"></a>'
                + '<a href="home.php?reject=' + id + '"><img src="images/cross.png" style="width:20%;height:30%;"></a><br>Aceptar Rechazar</div>',
        player: "html",
        title: "Mensaje",
        height: 350,
        width: 350
    });
}

function crearContacto(piso) {
    var tiempo = new Date();
    Shadowbox.open({
        content: '<form action="contactos.php" method="post">\n\
                Nombre <input type="text" placeholder="Nombre del contacto" name="nombre">\n\
                Telefono <input type="text" placeholder="Telefono" name="tel">\n\
                Email <input type="email" placeholder="Correo electr&oacute;nico" name="email"><br>\n\
                                <input type ="hidden" name="creador" value="' + piso + '">\n\
                <input type ="hidden" name="fecha" value="' + Math.floor(Date.now() / 1000) + '">\n\
                <input type="submit" value="Enviar" name="contacto">\n\
                </form>',
        player: "html",
        title: 'Crear Contacto',
        height: 550,
        width: 550,
        options: {enableKeys: false}
    });
}

function editarContacto(id, nombre, telefono, email) {
    Shadowbox.open({
        content: '<form action="contactos.php" method="post">\n\
                Nombre <input type="text"  name="nombre" value=' + nombre + '>\n\
                Telefono <input type="text" name="tel" value=' + telefono + '>\n\
                Email <input type="email" name="email" value=' + email + '><br>\n\
                <input type="hidden" name="piso" value=' + id + '>\n\
                <input type="submit" value="Enviar" name="editarContacto">\n\
                </form>',
        player: "html",
        title: 'Editar Contacto',
        height: 550,
        width: 550,
        options: {enableKeys: false}
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
                <input type ="hidden" name="autor" value="' + user + '">\n\
                <input type ="hidden" name="recep" value="' + dueno + '">\n\
                </form>',
        player: "html",
        title: 'Enviar solicitud',
        height: 550,
        width: 550,
        options: {enableKeys: false}
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

function confirmDel(mensaje, direccion) {
    var confirmar = confirm(mensaje);
    if (confirmar) {
        window.location = direccion;
    }
}

function editarNombre() {
    Shadowbox.open({
        content: '<form action="preferencias.php" method="post">\n\
                <label>Nuevo nombre:</label> <input type="text"  name="nombre" required="required">\n\
                <label>Contrase&ntilde;a: </label><input type="password" name="password" required="required">\n\
                <input type="submit" value="Enviar" name="editarNombre">\n\
                </form>',
        player: "html",
        title: 'Editar nombre',
        height: 550,
        width: 550,
        options: {enableKeys: false}
    });
}

function cambiarContrasenia() {
    Shadowbox.open({
        content: '<form action="preferencias.php" method="post">\n\
                <label>Contrase&ntilde;a antigua:</label> <input type="password"  name="passAnt" required="required">\n\
                <label>Contrase&ntilde;a nueva:</label> <input type="password"  name="newPass" required="required">\n\
                <label>Confirmar contrase&ntilde;a nueva:</label> <input type="password"  name="confPass" required="required">\n\
                <input type="submit" value="Enviar" name="cambiarPass">\n\
                </form>',
        player: "html",
        title: 'Cambiar contrase&ntilde;a',
        height: 550,
        width: 550,
        options: {enableKeys: false}
    });
}
