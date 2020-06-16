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
 * Convierte una hora 'hh:mm' a minutos.
 * 
 * @param {string} time Hora en formato 'hh:mm'.
 * 
 * @return {int} Tiempo en minutos.
 */
gesiSchedule.getTimeStamp = function (time)
{
    const hhmm = new RegExp('(\\d?\\d):(\\d\\d)');
    
    const result = hhmm.exec(time);

    const timeStamp = parseInt(result[1]) * 60 + parseInt(result[2]);
    
    return timeStamp;
}

/**
 * Genera las filas de la tabla del horario.
 * 
 * @return {string} Cadena de HTML con elementos <li>.
 */
gesiSchedule.rows = function ()
{
    const minutosInicio = gesiSchedule.getTimeStamp(autoconf.GESI_SCHEDULE_TIME_START_LIMIT);
    const minutosFinal = gesiSchedule.getTimeStamp(autoconf.GESI_SCHEDULE_TIME_END_LIMIT);

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
 * Genera las posiciones de los eventos del hoario.
 * 
 * @param {HTMLElement} schedule
 */
gesiSchedule.organize = function (schedule)
{
    const globalStart = gesiSchedule.getTimeStamp(autoconf.GESI_SCHEDULE_TIME_START_LIMIT);
    const globalEnd = gesiSchedule.getTimeStamp(autoconf.GESI_SCHEDULE_TIME_END_LIMIT);
    const globalDuration = globalEnd - globalStart;

    const $scheduleEvents = $(schedule).find('.gesi-schedule__event');

    const colHeaderHeight = $(schedule).find('.gesi-schedule__header:first-child').height();

    const scheduleHeight = $(schedule).find('.gesi-schedule__column > ul').height() - colHeaderHeight;

    for (var i = 0; i < $scheduleEvents.length; i++) {
        const $a = $($scheduleEvents[i]).find('> a');
        const start = gesiSchedule.getTimeStamp($a.data('start'));
        const duration = gesiSchedule.getTimeStamp($a.data('end')) - start;

        const eventTop = scheduleHeight / (globalDuration / (start - globalStart));
        const eventHeight = scheduleHeight * duration / globalDuration;

        $($scheduleEvents[i]).css({ top: eventTop, height: eventHeight });
    }
}

/**
 * Genera el HTML base del horario.
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
                    <a data-start="' + slots[slot].inicio + '" data-end="' + slots[slot].final + '" href="' + slots[slot].foroUrl + '" style="background-color: ' + slots[slot].nameColor + ';";>\
                        <span class="gesi-schedule__time">' + slots[slot].inicio + ' - ' + slots[slot].final + '</span>\
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

    const timelineContent = '\
    <div class="gesi-schedule__timeline">\
        <ul>' + lineas + '</ul>\
    </div>';

    const $timeline = $(timelineContent);
    $(schedule).append($timeline);

    const eventsContent = '\
    <div class="gesi-schedule__events">\
        <ul>' + columnas + '</ul>\
    </div>';

    const $events = $(eventsContent);
    $(schedule).append($events);

    // Set columns height.
    $(schedule).find('.gesi-schedule__column > ul').height($timeline.height());
    
    // Organize events.
    gesiSchedule.organize(schedule);
}

/**
 * jQuery on document ready
 */
$(() => {
    const autoLanuched = $('.gesi-schedule[data-autolaunch="true"]');

    for (var i = 0; i < autoLanuched.length; i++) {
        gesiSchedule.launch(autoLanuched[i]);
    }

    $('.gesi-schedule-modal').on('shown.bs.modal', function () {
        gesiSchedule.launch($(this).find('.gesi-schedule'));
        $(this).modal('handleUpdate');
    });

    $('.gesi-schedule-modal').on('hidden.bs.modal', function () {
        $(this).find('.gesi-schedule').empty();
    });
});