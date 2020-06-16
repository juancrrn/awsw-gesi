/**
 * JavaScript de los horarios.
 * 
 * Usando el símbolo $ para variables de tipo objeto de jQuery.
 *
 * @package awsw-gesi
 * Gesi
 * Aplicación de gestión de institutos de educación secundaria
 *
 * @author Andrés Ramiro Ramiro
 * @author Nicolás Pardina Popp
 * @author Pablo Román Morer Olmos
 * @author Juan Francisco Carrión Molina
 *
 * @version 0.0.4-beta.01
 */

var gesiSchedule = {};

/**
 * Compara dos slots según el día y el inicio.
 * 
 * @param {Object} a
 * @param {Object} b
 * 
 * @return {bool}
 */
gesiSchedule.compare = function (a, b)
{
    // Ordenar por día de la semana.
    dayPosA = autoconf.GESI_SCHEDULE_DAY_VALID.indexOf(a.dia);
    dayPosB = autoconf.GESI_SCHEDULE_DAY_VALID.indexOf(b.dia);

    if (dayPosA == dayPosB) {
        // Si el día coincide, ordenar por inicio.
        return a.inicio > b.inicio;
    }

    return dayPosA > dayPosB;
}

/**
 * Genera las filas de la tabla del horario.
 * 
 * @return {string} Cadena de HTML con elementos <li>.
 */
gesiSchedule.rows = function ()
{
    const hi = new RegExp('(\\d?\\d):(\\d\\d)');
    
    const limiteInicio = hi.exec(autoconf.GESI_SCHEDULE_TIME_START_LIMIT);
    const limiteFinal = hi.exec(autoconf.GESI_SCHEDULE_TIME_END_LIMIT);

    const minutosInicio = limiteInicio[1] * 60 + parseInt(limiteInicio[2]);
    const minutosFinal = limiteFinal[1] * 60 + parseInt(limiteFinal[2]);

    var lineas = '';

    for (var minutosActual = minutosInicio; minutosActual <= minutosFinal; minutosActual += 30) {
        const horas = Math.floor(minutosActual / 60);
        const minutos = Math.round(minutosActual - (horas * 60));
        const minutosCero = minutos < 10 ? '0' + minutos : minutos;
        lineas += '<li><span>' + horas + ':' + minutosCero + '</span></li>';
    }
    
    return lineas;
}

/**
 * Genera el horario.
 * 
 * @param {HTMLElement} schedule
 */
gesiSchedule.launch = function (schedule)
{
    const lineas = gesiSchedule.rows();

    // Recoger los slots del JSON del atributo data (conversión automática).
    const slots = $(schedule).data('json');
    
    // Ordenar los slots.
    slots.sort(gesiSchedule.compare);

    const diasValidos = autoconf.GESI_SCHEDULE_DAY_VALID;
    var columnas = '';

    // Para cada día.
    for (var dia = 0; dia < diasValidos.length; dia++) {
        var slotsColumna = '';
        
        for (var slot = 0; slot < slots.length; slot++) {
            if (slots[slot].dia == diasValidos[dia]) {
                const slotActual = '\
                <li class="gesi-schedule__event">\
                    <a data-start="' + slots[slot].inicio + '" data-end="' + slots[slot].final + '" href="' + slots[slot].foroUrl + '">\
                        <span class="gesi-schedule__time">' + slots[slot].inicioHora + ' - ' + slots[slot].finalHora + '</span>\
                        <span class="gesi-schedule__subject">' + slots[slot].asignaturaNombre + '</span>\
                        <span class="gesi-schedule__teacher">' + slots[slot].profesorNombre + '</span>\
                    </a>\
                </li>';

                slotsColumna += slotActual;
            }
        }

        columnas += '\
        <li class="gesi-schedule__column">\
            <div class="gesi-schedule__header"><span>' + diasValidos[dia] + '</span></div>\
            <ul>' + slotsColumna + '</ul>\
        </li>';
    }

    const content = '\
    <div class="gesi-schedule__timeline">\
        <ul>' + lineas + '</ul>\
    </div>\
    <div class="gesi-schedule__events">\
        <ul>' + columnas + '</ul>\
    </div>';

    $(schedule).html(content);
}

/**
 * jQuery on document ready
 */
$(() => {
    const autoLanuched = $('.gesi-schedule[data-autolaunch="true"]');

    if (autoLanuched.length) {
        for (var i = 0; i < autoLanuched.length; i++) {
            gesiSchedule.launch(autoLanuched[i]);
        }
    }
});