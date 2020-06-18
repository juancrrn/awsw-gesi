/**
 * Funciones AJAX on-success.
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
 * @version 0.0.4
 */

/**
 * Aux object used for namespace.
 */
var x = {};

/**
 * Genera un botón de disparo de un modal para una fila concreta.
 * 
 * @param {string} formId Identificador del formulario.
 * @param {int} uniqueId Identificador único de la fila.
 * @param {string} content Contenido del botón.
 */
x.genBtn = (formId, uniqueId, content) =>
{
    return '<button class="btn-ajax-modal-fire btn btn-sm btn-primary mb-1 mx-1" data-ajax-form-id="' + formId + '" data-ajax-unique-id="' + uniqueId + '">' + content + '</button>';
}

/**
 * Aux object used for namespace.
 */
var onSuccessFn = {};

/**
 * Actualiza la lista de usuarios cuando se crea uno, del rol estudiante.
 * 
 * @param {eventObject} e Evento.
 * @param {Object} params Contiene el modal y el resultado.
 */
onSuccessFn.listaUsuariosEstCreated = (e, params) =>
{
    const $modalData = params.modalData;
    const result = params.result;

    const targetObjectName = $modalData.data('ajax-target-object-name');
    
    const uniqueId = result[targetObjectName].uniqueId;
    const nif = result[targetObjectName].nif;
    const nombreCompleto = result[targetObjectName].nombre + ' ' + result[targetObjectName].apellidos;

    const buttons =
        x.genBtn('usuario-est-ps-read', uniqueId, 'Ver') +
        x.genBtn('usuario-est-ps-update', uniqueId, 'Editar') +
        x.genBtn('usuario-est-ps-delete', uniqueId, 'Eliminar');

    const $list = $(e.currentTarget).find('tbody');
    $rowHtml = '\
    <tr data-unique-id="' + uniqueId + '">\
        <td scope="row" data-col-name="nif">' + nif + '</td>\
        <td data-col-name="nombre-completo">' + nombreCompleto + '</td>\
        <td class="text-right">' + buttons + '</td>\
    </tr>';

    $list.append($rowHtml);
}

/**
 * Actualiza la lista de usuarios cuando se crea uno, del rol personal docente.
 * 
 * @param {eventObject} e Evento.
 * @param {Object} params Contiene el modal y el resultado.
 */
onSuccessFn.listaUsuariosPdCreated = (e, params) =>
{
    const $modalData = params.modalData;
    const result = params.result;

    const formId = $modalData.data('ajax-form-id');
    const targetObjectName = $modalData.data('ajax-target-object-name');
    
    const uniqueId = result[targetObjectName].uniqueId;
    const nif = result[targetObjectName].nif;
    const nombreCompleto = result[targetObjectName].nombre + ' ' + result[targetObjectName].apellidos;

    const buttons =
        x.genBtn('usuario-pd-ps-read', uniqueId, 'Ver') +
        x.genBtn('usuario-pd-ps-update', uniqueId, 'Editar') +
        x.genBtn('usuario-pd-ps-delete', uniqueId, 'Eliminar');

    const $list = $(e.currentTarget).find('tbody');
    
    $rowHtml = '\
    <tr data-unique-id="' + uniqueId + '">\
        <td scope="row" data-col-name="nif">' + nif + '</td>\
        <td data-col-name="nombre-completo">' + nombreCompleto + '</td>\
        <td class="text-right">' + buttons + '</td>\
    </tr>';

    $list.append($rowHtml);
}

/**
 * Actualiza la lista de usuarios cuando se crea uno, del rol personal de 
 * Secretaría.
 * 
 * @param {eventObject} e Evento.
 * @param {Object} params Contiene el modal y el resultado.
 */
onSuccessFn.listaUsuariosPsCreated = (e, params) =>
{
    const $modalData = params.modalData;
    const result = params.result;

    const targetObjectName = $modalData.data('ajax-target-object-name');
    
    const uniqueId = result[targetObjectName].uniqueId;
    const nif = result[targetObjectName].nif;
    const nombreCompleto = result[targetObjectName].nombre + ' ' + result[targetObjectName].apellidos;

    const buttons =
        x.genBtn('usuario-ps-ps-read', uniqueId, 'Ver') +
        x.genBtn('usuario-ps-ps-update', uniqueId, 'Editar') +
        x.genBtn('usuario-ps-ps-delete', uniqueId, 'Eliminar');

    const $list = $(e.currentTarget).find('tbody');

    $rowHtml = '\
    <tr data-unique-id="' + uniqueId + '">\
        <td scope="row" data-col-name="nif">' + nif + '</td>\
        <td data-col-name="nombre-completo">' + nombreCompleto + '</td>\
        <td class="text-right">' + buttons + '</td>\
    </tr>';

    $list.append($rowHtml);
}

/**
 * Actualiza la lista de usuarios cuando se edita uno, del rol que sea.
 * 
 * @param {eventObject} e Evento.
 * @param {Object} params Contiene el modal y el resultado.
 */
onSuccessFn.listaUsuariosUpdated = (e, params) =>
{
    const $modalData = params.modalData;
    const result = params.result;

    const targetObjectName = $modalData.data('ajax-target-object-name');
    
    const uniqueId = result[targetObjectName].uniqueId;
    const nif = result[targetObjectName].nif;
    const nombreCompleto = result[targetObjectName].nombre + ' ' + result[targetObjectName].apellidos;

    const $list = $(e.currentTarget).find('tbody');
    const $row = $list.find('tr[data-unique-id="' + uniqueId + '"]');

    $row.find('td[data-col-name="nif"]').text(nif);
    $row.find('td[data-col-name="nombre-completo"]').text(nombreCompleto);
}

/**
 * Actualiza la lista de usuarios cuando se elimina uno, del rol que sea.
 * 
 * @param {eventObject} e Evento.
 * @param {Object} params Contiene el modal y el resultado.
 */
onSuccessFn.listaUsuariosDeleted = (e, params) =>
{
    const $modalData = params.modalData;

    const uniqueId = $modalData.find('input[name="uniqueId"]').val();

    const $list = $(e.currentTarget).find('tbody');
    const $row = $list.find('tr[data-unique-id="' + uniqueId + '"]');

    $row.remove();
}

/**
 * Actualiza la lista de asignaciones (personal de Secretaría) cuando se crea 
 * una.
 * 
 * @param {eventObject} e Evento.
 * @param {Object} params Contiene el modal y el resultado.
 */
onSuccessFn.listaPsAsignacionesCreated = (e, params) =>
{
    const $modalData = params.modalData;
    const result = params.result;

    const targetObjectName = $modalData.data('ajax-target-object-name');
    
    const uniqueId = result[targetObjectName].uniqueId;
    const profesorNombre = result[targetObjectName].profesorNombre;
    const asignaturaNombre = result[targetObjectName].asignaturaNombre;
    const grupoNombre = result[targetObjectName].grupoNombre;

    const buttons =
        x.genBtn('asignacion-ps-read', uniqueId, 'Ver') +
        x.genBtn('asignacion-ps-update', uniqueId, 'Editar') +
        x.genBtn('asignacion-ps-delete', uniqueId, 'Eliminar');

    const $list = $(e.currentTarget).find('tbody');
    
    $rowHtml = '\
    <tr data-unique-id="' + uniqueId + '">\
        <td data-col-name="profesorNombre">' + profesorNombre + '</td>\
        <td data-col-name="asignaturaNombre">' + asignaturaNombre + '</td>\
        <td data-col-name="grupoNombre">' + grupoNombre + '</td>\
        <td class="text-right">' + buttons + '</td>\
    </tr>';

    $list.append($rowHtml);
}

/**
 * Actualiza la lista de asignaciones (personal de Secretaría) cuando se 
 * acutaliza una.
 * 
 * @param {eventObject} e Evento.
 * @param {Object} params Contiene el modal y el resultado.
 */
onSuccessFn.listaPsAsignacionesUpdated = (e, params) =>
{
    const $modalData = params.modalData;
    const result = params.result;

    const targetObjectName = $modalData.data('ajax-target-object-name');
    
    const uniqueId = result[targetObjectName].uniqueId;
    const profesorNombre = result[targetObjectName].profesorNombre;
    const asignaturaNombre = result[targetObjectName].asignaturaNombre;
    const grupoNombre = result[targetObjectName].grupoNombre;

    const $list = $(e.currentTarget).find('tbody');
    const $row = $list.find('tr[data-unique-id="' + uniqueId + '"]');

    $row.find('td[data-col-name="profesorNombre"]').text(profesorNombre);
    $row.find('td[data-col-name="asignaturaNombre"]').text(asignaturaNombre);
    $row.find('td[data-col-name="grupoNombre"]').text(grupoNombre);
}

/**
 * Actualiza la lista de asignaciones (personal de Secretaría) cuando se 
 * elimina una.
 * 
 * @param {eventObject} e Evento.
 * @param {Object} params Contiene el modal y el resultado.
 */
onSuccessFn.listaPsAsignacionesDeleted = (e, params) =>
{
    const $modalData = params.modalData;

    const uniqueId = $modalData.find('input[name="uniqueId"]').val();

    const $list = $(e.currentTarget).find('tbody');
    const $row = $list.find('tr[data-unique-id="' + uniqueId + '"]');

    $row.remove();
}

/**
 * Actualiza la lista de mensajes de Secretaría cuando se elimina uno.
 * 
 * @param {eventObject} e Evento.
 * @param {Object} params Contiene el modal y el resultado.
 */
onSuccessFn.listaSesMensajesSecretariaCreated = (e, params) =>
{
    const $modalData = params.modalData;
    const result = params.result;

    const targetObjectName = $modalData.data('ajax-target-object-name');
    
    const uniqueId = result[targetObjectName].uniqueId;
    const fecha = result[targetObjectName].fecha;
    const extractoContenido = result[targetObjectName].extractoContenido;

    const buttons = x.genBtn('mensaje-secretaria-ses-read', uniqueId, 'Ver');

    const $list = $(e.currentTarget).find('tbody');
    
    $rowHtml = '\
    <tr>\
        <td>(Yo)</td>\
        <td>' + fecha + '</td>\
        <td>' + extractoContenido + '</td>\
        <td class="text-right">' + buttons + '</td>\
    </tr>';

    $list.append($rowHtml);
}

/**
 * Actualiza la lista de Asignaturas cuando se crea una.
 * 
 * @param {eventObject} e Evento.
 * @param {Object} params Contiene el modal y el resultado.
 */
onSuccessFn.listaPsAsignaturasCreated = (e, params) =>
{
    const $modalData = params.modalData;
    const result = params.result;

    const targetObjectName = $modalData.data('ajax-target-object-name');
    
    const uniqueId = result[targetObjectName].uniqueId;
    const corto = result[targetObjectName].nombreCorto;
    const nivel = result[targetObjectName].nivelEscolar;
    const curso = result[targetObjectName].curso;
    const largo = result[targetObjectName].nombreCompleto;

    const buttons =
        x.genBtn('asignatura-ps-read', uniqueId, 'Ver') +
        x.genBtn('asignatura-ps-update', uniqueId, 'Editar') +
        x.genBtn('asignatura-ps-delete', uniqueId, 'Eliminar');

    const $list = $(e.currentTarget).find('tbody');
    
    $rowHtml = '\
    <tr data-unique-id="' + uniqueId + '">\
        <td scope="row" data-col-name="nombreCorto">'+ corto + '</td>\
        <td data-col-name="nivel">'+ nivel +'</td>\
        <td data-col-name="curso">'+ curso + '</td>\
        <td data-col-name="nombreCompleto">'+ largo + '</td>\
        <td class="text-right">' + buttons + '</td>\
    </tr>';
    
    $list.append($rowHtml);
}

/**
 * Actualiza la lista de Asignaturas cuando se actualiza una.
 * 
 * @param {eventObject} e Evento.
 * @param {Object} params Contiene el modal y el resultado.
 */
onSuccessFn.listaPsAsignaturasUpdated = (e, params) =>
{
    const $modalData = params.modalData;
    const result = params.result;

    const targetObjectName = $modalData.data('ajax-target-object-name');
    
    const uniqueId = result[targetObjectName].uniqueId;
    const corto = result[targetObjectName].nombreCorto;
    const nivel = result[targetObjectName].nivelEscolar;
    const curso = result[targetObjectName].curso;
    const largo = result[targetObjectName].nombreCompleto;

    const $list = $(e.currentTarget).find('tbody');
    const $row = $list.find('tr[data-unique-id="' + uniqueId + '"]');

    $row.find('td[data-col-name="nombreCorto"]').text(corto);
    $row.find('td[data-col-name="nivel"]').text(nivel);
    $row.find('td[data-col-name="curso"]').text(curso);
    $row.find('td[data-col-name="nombreCompleto"]').text(largo);
}

/**
 * Actualiza la lista de asignaturas cuando se elimina una.
 * 
 * @param {eventObject} e Evento.
 * @param {Object} params Contiene el modal y el resultado.
 */
onSuccessFn.listaPsAsignaturasDeleted = (e, params) =>
{
    const $modalData = params.modalData;

    const uniqueId = $modalData.find('input[name="uniqueId"]').val();

    const $list = $(e.currentTarget).find('tbody');
    const $row = $list.find('tr[data-unique-id="' + uniqueId + '"]');

    $row.remove();
}

onSuccessFn.listaGruposPsCreated = (e, params) =>
{
    const $modalData = params.modalData;
    const result = params.result;

    const targetObjectName = $modalData.data('ajax-target-object-name');

    const uniqueId = result[targetObjectName].uniqueId;
    const nivel = result[targetObjectName].nivel;
    const nombre_completo = result[targetObjectName].nombre_completo; 

    const buttons =
        x.genBtn('grupo-ps-read', uniqueId, 'Ver') +
        x.genBtn('grupo-ps-update', uniqueId, 'Editar') +
        x.genBtn('grupo-ps-delete', uniqueId, 'Eliminar');
    
    const $list = $(e.currentTarget).find('tbody');
    
    $rowHtml = '\
    <tr data-unique-id="' + uniqueId + '">\
        <td data-col-name="nivel">'+ nivel +'</td>\
        <td scope="row" data-col-name="nombre-completo">'+ nombre_completo + '</td>\
        <td class="text-right">' + buttons + '</td>\
    </tr>';

    $list.append($rowHtml);
}

onSuccessFn.listaGruposPsUpdated = (e, params) =>
{
    const $modalData = params.modalData;
    const result = params.result;

    const targetObjectName = $modalData.data('ajax-target-object-name');

    const uniqueId = result[targetObjectName].uniqueId;

    const $list = $(e.currentTarget).find('tbody');
    const $row = $list.find('tr[data-unique-id="' + uniqueId + '"]');

    $row.find('td[data-col-name="nif"]').text(nif);
    $row.find('td[data-col-name="nombre-completo"]').text(nombreCompleto);
}

onSuccessFn.listaGruposPsDeleted = (e, params) =>
{
    const $modalData = params.modalData;

    const uniqueId = $modalData.find('input[name="uniqueId"]').val();

    const $list = $(e.currentTarget).find('tbody');
    const $row = $list.find('tr[data-unique-id="' + uniqueId + '"]');

    $row.remove();
}


/** Eventos */

onSuccessFn.listaEventoPsCreated = (e, params) =>
{
    const $modalData = params.modalData;
    const result = params.result;

    const targetObjectName = $modalData.data('ajax-target-object-name');
    
    const uniqueId = result[targetObjectName].uniqueId;
    const fecha = result[targetObjectName].fecha;
    const nombre = result[targetObjectName].nombre;
    const descripcion = result[targetObjectName].descripcion;
    const lugar = result[targetObjectName].lugar;

    const buttons =
        x.genBtn('evento-ps-read', uniqueId, 'Ver') +
        x.genBtn('evento-ps-update', uniqueId, 'Editar') +
        x.genBtn('evento-ps-delete', uniqueId, 'Eliminar');

    const $list = $(e.currentTarget).find('tbody');

    $rowHtml = '\
    <tr data-unique-id="' + uniqueId + '">\
        <td scope="row" data-col-name="fecha">'+ fecha + '</td>\
        <td data-col-name="nombre">'+ nombre +'</td>\
        <td data-col-name="lugar">'+ lugar + '</td>\
        <td data-col-name="descripcion">'+ descripcion + '</td>\
        <td class="text-right">' + buttons + '</td>\
    </tr>';
    
    $list.append($rowHtml);
}

/**
 * Actualiza la lista de Asignaturas cuando se actualiza una.
 * 
 * @param {eventObject} e Evento.
 * @param {Object} params Contiene el modal y el resultado.
 */
onSuccessFn.listaEventoPsUpdated = (e, params) =>
{
    const $modalData = params.modalData;
    const result = params.result;

    const targetObjectName = $modalData.data('ajax-target-object-name');

    const uniqueId = result[targetObjectName].uniqueId;
    const fecha = result[targetObjectName].fecha;
    const nombre = result[targetObjectName].nombre;
    const descripcion = result[targetObjectName].descripcion;
    const lugar = result[targetObjectName].lugar;

    const $list = $(e.currentTarget).find('tbody');
    const $row = $list.find('tr[data-unique-id="' + uniqueId + '"]');

    $row.find('td[data-col-name="fecha"]').text(fecha);
    $row.find('td[data-col-name="nombre"]').text(nombre);
    $row.find('td[data-col-name="descripcion"]').text(descripcion);
    $row.find('td[data-col-name="lugar"]').text(lugar);
}

/**
 * Actualiza la lista de asignaturas cuando se elimina una.
 * 
 * @param {eventObject} e Evento.
 * @param {Object} params Contiene el modal y el resultado.
 */
onSuccessFn.listaEventoPsDeleted = (e, params) =>
{
    const $modalData = params.modalData;

    const uniqueId = $modalData.find('input[name="uniqueId"]').val();

    const $list = $(e.currentTarget).find('tbody');
    const $row = $list.find('tr[data-unique-id="' + uniqueId + '"]');

    $row.remove();
}

/**
 * Actualiza la lista de Foros cuando se crea uno.
 * 
 * @param {eventObject} e Evento.
 * @param {Object} params Contiene el modal y el resultado.
 */
onSuccessFn.listaPsForosCreated = (e, params) =>
{
    const $modalData = params.modalData;
    const result = params.result;

    const targetObjectName = $modalData.data('ajax-target-object-name');
    
    const uniqueId = result[targetObjectName].uniqueId;
    const nombre = result[targetObjectName].nombre;

    const buttons =
        x.genBtn('foro-ps-read', uniqueId, 'Ver') +
        x.genBtn('foro-ps-update', uniqueId, 'Editar') +
        x.genBtn('foro-ps-delete', uniqueId, 'Eliminar');

    const $list = $(e.currentTarget).find('tbody');
    
    $rowHtml = '\
    <tr data-unique-id="' + uniqueId + '">\
        <td scope="row" data-col-name="foroNombre">'+ nombre + '</td>\
        <td class="text-right">' + buttons + '</td>\
    </tr>';
    
    $list.append($rowHtml);

}

/**
 * Actualiza la lista de foros cuando se actualiza uno.
 * 
 * @param {eventObject} e Evento.
 * @param {Object} params Contiene el modal y el resultado.
 */
onSuccessFn.listaPsForosUpdated = (e, params) =>
{
    const $modalData = params.modalData;
    const result = params.result;

    const targetObjectName = $modalData.data('ajax-target-object-name');
    
    const uniqueId = result[targetObjectName].uniqueId;
    const nombre = result[targetObjectName].nombre;

    const $list = $(e.currentTarget).find('tbody');
    const $row = $list.find('tr[data-unique-id="' + uniqueId + '"]');

    $row.find('td[data-col-name="foroNombre"]').text(nombre);
}

/**
 * Actualiza la lista de foros cuando se elimina una.
 * 
 * @param {eventObject} e Evento.
 * @param {Object} params Contiene el modal y el resultado.
 */
onSuccessFn.listaPsForosDeleted = (e, params) =>
{
    const $modalData = params.modalData;

    const uniqueId = $modalData.find('input[name="uniqueId"]').val();

    const $list = $(e.currentTarget).find('tbody');
    const $row = $list.find('tr[data-unique-id="' + uniqueId + '"]');

    $row.remove();
}

/**
 * Actualiza la lista de mensajes de foro cuando se añade uno.
 * 
 * @param {eventObject} e Evento.
 * @param {Object} params Contiene el modal y el resultado.
 */
onSuccessFn.listaMensajeForoCreated = (e, params) =>
{
    const $modalData = params.modalData;
    const result = params.result;

    const data = result[$modalData.data('ajax-target-object-name')];

    const fecha = data.fecha;
    const usuarioNombre = data.usuarioNombre;
    const contenido = data.contenido;

    const mensaje = '\
    <div class="card mb-2">\
        <div class="card-header">\
            <p class="mb-2"><span class="badge badge-secondary">Mensaje principal (' + fecha + ')</span></p>\
            <p class="mb-2"><strong>' + usuarioNombre + '</strong></p>\
            <p class="mb-4">' + contenido + '</p>\
            <p>(Recarga la página para poder responder a este mensaje.)</p>\
        </div>\
        <ul class="list-group list-group-flush mensaje-foro-ses-respuestas-list"></ul>\
    </div>';

    $(e.currentTarget).append(mensaje);
}