// Esto arregla la validacion despues de cargar una pagina a traves de AJAX
// Ademas tambien compatibiliza la validacion de MVC y la de easyUI
// Se la llama en el OnLoad pasandole el DIV donde esta el FORM
(function ($) {
    $.validator.unobtrusive.addValidation = function (selector) {
        //get the relevant form 
        var form = $(selector);
        // delete validator in case someone called form.validate()
        $(form).removeData("validator");
        $.validator.unobtrusive.parse(form);
    }
})(jQuery);

var cmenu;                  // El menu contextual de las cabeceras del Grid
var lIndexSelected = -1;    // El index del elemento seleccionado dentor del grid
var lIdSelected = -1;       // El index del elemento seleccionado dentor del grid
var lControllador = "";
var lfitColumns = true;     // Si las columnas se tienen que resicear para ocupar todo el grid
var lIniciado = false;

var lBuscarFiltro = "";
var lTituloFiltro = "";
var lBuscarCampo = "";
var lBuscarValor = "";
var lURLFiltroAvanzado = "";


//Sobrecargas de los metodos parse y format de los objetos DateBox y DateTimeBox, para que el formado sea yyyy/MM/dd
$.fn.datebox.defaults.formatter = function (date) {
    var y = date.getFullYear();
    var m = date.getMonth() + 1;
    var d = date.getDate();
    m = (m < 10 ? '0' : '') + m
    d = (d < 10 ? '0' : '') + d
    //    alert("return " + y + '/' + m + '/' + d);
    return d + '/' + m + '/' + y;
}
$.fn.datebox.defaults.parser = function (s) {
    //Descompongo la fecha en sus partes
    var t = parseDate(s);
    if (!isNaN(t)) {
        return new Date(t);
    } else {
        return new Date();
    }
}
var parseDate = function (s) {
    var Res = null;
    var re = /^(\d\d)\/(\d\d)\/(\d{4}) (\d\d):(\d\d):(\d\d)$/;
    if (s.length == 10) {
        re = /^(\d\d)\/(\d\d)\/(\d{4})$/;
        var m = re.exec(s);
        Res = m ? new Date(m[3], m[2] - 1, m[1]) : null;
    } else {
        var m = re.exec(s);
        Res = m ? new Date(m[3], m[2] - 1, m[1], m[4], m[5], m[6]) : null;
    }
    return Res;
};

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

function Inicia() {
    $('#Centro').layout();
    //easyui-layout
    $(window).resize(function () {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(Resice, 200);
    });

    cantidadFilas = Math.floor(($("#Centro").height() - 119) / AltoFilasGrid);
}

var resizeTimer;
//function doSomething() {
//    var lH = parseInt($('#PanelCentral').css("height"));
//    var lW = parseInt($('#PanelCentral').css("width"));
//    //    $('#MiMain').css("height", lH/2).css("width", lW);
//    //    $('#dg').datagrid('resize');
//    // Preparamos un timer de 1 seg, para recargar el grid, lo matamos mientras estemos resiceando
//    Resice();
//};

function Resice() {
    // Paro el timer
    clearTimeout(resizeTimer);
    
    // Recalculo el DIV Centro
    $('#Centro').css("height", $('#contenido').css("height"));
    $('#Centro').css("width", $('#contenido').css("width"));
    $('#Centro').layout('panel', 'south').panel('resize', {
        width: $('#contenido').css("width"),
        height: $('#contenido').css("height")
    });
    
    // Recalculo la cantidad de filas
    var cantidadFilasActual = Math.floor(($("#Centro").height() - 119) / AltoFilasGrid);
    if (cantidadFilas != cantidadFilasActual) {
        var Pie = $('#dg').datagrid('options').showFooter ? 1 : 0;
        cantidadFilas = cantidadFilasActual;
        $('#dg').datagrid({ pageList: [cantidadFilas - Pie], pageSize: cantidadFilas - Pie });
        // Quitar el combo de la paginacion
        $(".pagination").pagination({showPageList:false});
    }
}

function ActualizarBotones() {
    var lItem = $('#dg').datagrid('getSelected');
    if (lItem != null) {
        lIdSelected = lItem.Id;
        $('#Edit').linkbutton('enable');
        $('#Del').linkbutton('enable');
        $('#View').linkbutton('enable');
    } else {
        lIndexSelected = -1;
        lIdSelected = -1;
        $('#Edit').linkbutton('disable');
        $('#Del').linkbutton('disable');
        $('#View').linkbutton('disable');
    }
}

//La creacion del menu contextual para ocultar/visualizar columnas
function createColumnMenu(aColumnas) {
    cmenu = $('<div/>').appendTo('body');
    cmenu.menu({
        onClick: function (item) {
            if (item.iconCls == 'icon-ok') {
                $('#dg').datagrid('hideColumn', item.name);
                cmenu.menu('setIcon', {
                    target: item.target,
                    iconCls: 'icon-empty'
                });
            } else {
                $('#dg').datagrid('showColumn', item.name);
                cmenu.menu('setIcon', {
                    target: item.target,
                    iconCls: 'icon-ok'
                });
            }
        }
    });
    var fields = $('#dg').datagrid('getColumnFields');
    var lsColumnas = "," + aColumnas + ",";
    for (var i = 0; i < fields.length; i++) {
        var field = fields[i];
        if (lsColumnas.indexOf("," + field + ",") !== -1) {
            var col = $('#dg').datagrid('getColumnOption', field);
            var lIcon = 'icon-ok';
            if (col.hidden) {
                lIcon = 'icon-empty';
            }
            cmenu.menu('appendItem', {
                text: col.title,
                name: field,
                iconCls: lIcon
            });
        };
    }
    $(".menu-top").width(150);
};

// Los botones Añadir / Modificar y Borrar
function Añadir(asTitulo) {
    CrearPanel(asTitulo, lURLAñadir, 'icon-add');
}

function Editar(asTitulo) {
    var lItem = $('#dg').datagrid('getSelected');
    if (lItem != null) {
        CrearPanel(eval(asTitulo), lURLEdicion + lItem.Id, 'icon-edit');
    }
}
function Borrar() {
    //Preguntar si esta seguro
    $.messager.confirm('Confirm', 'Esta seguro de eliminar el registro?', function (r) {
        if (r) {
            BorrarRegistro();
        }
    });
}

// La creacion del panel para poder añadir o modificar
function CrearPanel(asTitulo, asURL, asIcon) {
    // Obtengo el tamaño del centro para ocuparlo todo
    try {
        $('#Centro').layout('expand', 'south');
        $('#Centro').layout('panel', 'south').panel({ title: asTitulo, href: asURL, iconCls: asIcon, loadingMessage: 'Cargando datos', maximized: false });
    }
    catch (e) {
        var lItem = $('#Centro').layout('add', {
            id: 'Edicion',
            region: 'south',
            title: asTitulo,
            href: asURL,
            iconCls: asIcon,
            loadingMessage: 'Cargando datos',
            fit: true,
            maximized: false,
            collapsible: false,
            split: false
        }).layout('resize');
    }
}

// Para cerrar el panel
function Cerrar() {
    $('#Centro').layout('remove', 'south');
    $('#dg').datagrid('resize');
    // Quitar las ventanitas de errores
    $(".formError").remove();
    CerrarPanel();
}

function Buscar(asCampo, asValor) {
    // Compruebo en que estado esta
    lBuscarCampo = asCampo;
    lBuscarValor = asValor;
    $('#dg').datagrid({ title: lsTitulo + ObtenerTituloBusqueda(), queryParams: ObtenerQP() });
    // Quitar el combo de la paginacion
    $(".pagination").pagination({ showPageList: false });  
}

function ObtenerQP() {
    var lsRes = "";
    if (lBuscarFiltro != "") {
        lsRes += '"Filtro": ' + lBuscarFiltro + ',';
    }
    if (lBuscarCampo != "" && lBuscarValor != "") {
        lsRes += '"WhereCampo": "' + lBuscarCampo + '",';
        lsRes += '"WhereValor": "' + lBuscarValor + '",';
    }
    if (lsRes.length > 0) {
        lsRes = lsRes.substring(0, lsRes.length - 1);
    }
    return jQuery.parseJSON('{' + lsRes + '}');
}
function ObtenerTituloBusqueda() {
    var lsRes = "";

    if (lBuscarFiltro != "") {
        lsRes = ", filtro: " + lTituloFiltro;
    }
    if (lBuscarCampo != "" && lBuscarValor != "") {
        lsRes += ", " + lBuscarCampo + ": " + lBuscarValor;
    }
    return lsRes;
}
// Fin, Para las busquedas
function roundNumber(Number, Decimals) {
    // Argumentos: Numero a redondear, cantidad de decimales
    var Factor = Math.pow(10, Decimals);
    return Math.round(Number * Factor) / Factor;
}

$(document).ready(function () {
    // Cargo el buscador
    $('#Buscador').searchbox({
        searcher: function (value, name) {
            Buscar(name, value);
        },
        menu: '#OpcionesBuscador',
        prompt: lLiteralBusqueda
    });

    clearTimeout(CaducidadTimer);
    CaducidadTimer = setTimeout(Caducidad, 5000);

});

var CaducidadTimer;
function Caducidad() {
    clearTimeout(CaducidadTimer);
    var lsCaducidad = $.getCookie("Caducidad");
    var d = new Date(lsCaducidad);
    var d2 = new Date();
    var lTiempoRestante = Math.floor((d - d2).toString() / 1000);

    var lMinutos = Math.floor(lTiempoRestante / 60);
    var lSegundos = lTiempoRestante % 60;

    if (lTiempoRestante < 0) {
        // Redireccion al login
        window.location.replace(URLLogin);
    } else {
	    lMinutos = (lMinutos  < 10 ? '0' : '') + lMinutos
	    lSegundos = (lSegundos< 10 ? '0' : '') + lSegundos
        $("#CapaTiempoRestanteDesconexion").html(lMinutos + ":" + lSegundos);
        CaducidadTimer = setTimeout(Caducidad, 1000);
    }
}

$.getCookie = function (c_name) {
    var i, x, y, ARRcookies = document.cookie.split(";");
    for (i = 0; i < ARRcookies.length; i++) {
        x = ARRcookies[i].substr(0, ARRcookies[i].indexOf("="));
        y = ARRcookies[i].substr(ARRcookies[i].indexOf("=") + 1);
        x = x.replace(/^\s+|\s+$/g, "");
        if (x == c_name) {
            return unescape(y);
        }
    }
};