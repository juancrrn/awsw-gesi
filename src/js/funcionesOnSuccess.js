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
 * @author Cintia María Herrera Arenas
 * @author Nicolás Pardina Popp
 * @author Pablo Román Morer Olmos
 * @author Juan Francisco Carrión Molina
 *
 * @version 0.0.4
 */

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

    const formId = $modalData.data('ajax-form-id');
    const targetObjectName = $modalData.data('ajax-target-object-name');
    
    const uniqueId = result[targetObjectName].uniqueId;
    const nif = result[targetObjectName].nif;
    const nombreCompleto = result[targetObjectName].nombre + ' ' + result[targetObjectName].apellidos;

    const $list = $(e.currentTarget).find('tbody');
    // TODO: añadir botones
    $rowHtml = '\
    <tr data-unique-id="' + uniqueId + '">\
        <td scope="row" data-col-name="nif">' + nif + '</td>\
        <td data-col-name="nombre-completo">' + nombreCompleto + '</td>\
        <td class="text-right">\
            <button class="btn-ajax-modal-fire btn btn-sm btn-primary mb-1" data-ajax-form-id="usuario-est-read" data-ajax-unique-id="' + uniqueId + '">Ver</button>\
            <button class="btn-ajax-modal-fire btn btn-sm btn-primary mb-1" data-ajax-form-id="usuario-est-update" data-ajax-unique-id="' + uniqueId + '">Editar</button>\
            <button class="btn-ajax-modal-fire btn btn-sm btn-primary mb-1" data-ajax-form-id="usuario-est-delete" data-ajax-unique-id="' + uniqueId + '">Eliminar</button>\
        </td>\
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

    const $list = $(e.currentTarget).find('tbody');
    // TODO: añadir botones
    $rowHtml = '\
    <tr data-unique-id="' + uniqueId + '">\
        <td scope="row" data-col-name="nif">' + nif + '</td>\
        <td data-col-name="nombre-completo">' + nombreCompleto + '</td>\
        <td class="text-right">\
            <button class="btn-ajax-modal-fire btn btn-sm btn-primary mb-1" data-ajax-form-id="usuario-pd-read" data-ajax-unique-id="' + uniqueId + '">Ver</button>\
            <button class="btn-ajax-modal-fire btn btn-sm btn-primary mb-1" data-ajax-form-id="usuario-pd-update" data-ajax-unique-id="' + uniqueId + '">Editar</button>\
            <button class="btn-ajax-modal-fire btn btn-sm btn-primary mb-1" data-ajax-form-id="usuario-pd-delete" data-ajax-unique-id="' + uniqueId + '">Eliminar</button>\
        </td>\
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

    const formId = $modalData.data('ajax-form-id');
    const targetObjectName = $modalData.data('ajax-target-object-name');
    
    const uniqueId = result[targetObjectName].uniqueId;
    const nif = result[targetObjectName].nif;
    const nombreCompleto = result[targetObjectName].nombre + ' ' + result[targetObjectName].apellidos;

    const $list = $(e.currentTarget).find('tbody');
    // TODO: añadir botones
    $rowHtml = '\
    <tr data-unique-id="' + uniqueId + '">\
        <td scope="row" data-col-name="nif">' + nif + '</td>\
        <td data-col-name="nombre-completo">' + nombreCompleto + '</td>\
        <td class="text-right">\
            <button class="btn-ajax-modal-fire btn btn-sm btn-primary mb-1" data-ajax-form-id="usuario-ps-read" data-ajax-unique-id="' + uniqueId + '">Ver</button>\
            <button class="btn-ajax-modal-fire btn btn-sm btn-primary mb-1" data-ajax-form-id="usuario-ps-update" data-ajax-unique-id="' + uniqueId + '">Editar</button>\
            <button class="btn-ajax-modal-fire btn btn-sm btn-primary mb-1" data-ajax-form-id="usuario-ps-delete" data-ajax-unique-id="' + uniqueId + '">Eliminar</button>\
        </td>\
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
    console.log($row);

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