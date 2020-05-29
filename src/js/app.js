/**
 * JavaScript principal.
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
 * Toasts
 */
toast = {};

/**
 * Creates a toast
 */
toast.create = (type, text) =>
{
    const autohide = autoconf.APP_PRODUCTION;
    const appName = autoconf.APP_NAME;

    const dismisAllButton = '<button type="button" class="toasts-remove-all btn btn-outline-secondary btn-sm">Ocultar todo</button>';
    
    const toastHtml = '<div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-autohide="' + autohide + '" data-delay="3000"><div class="toast-header"><span class="type-indicator ' + type + '"></span><strong class="mr-auto">' + appName + '</strong>' + dismisAllButton + '<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="toast-body">' + text + '</div></div>';

    const $toast = $(toastHtml);

    return $toast;
}

/**
 * Creates and shows a success toast
 */
toast.success = (text) =>
{
    var $toast = toast.create('exito', text);
    $('#toasts-container').prepend($toast);
    $toast.toast('show');
}

/**
 * Creates and shows an error toast
 */
toast.error = (text) =>
{
    var $toast = toast.create('error', text);
    $('#toasts-container').prepend($toast);
    $toast.toast('show');
}

/**
 * 
 * Aux functions
 * 
 */

/**
 * Aux object used for namespace
 */
var aux = {};

/**
 * Retrieves a form's data and converts it to a JSON string
 * 
 * @param {jQuery} $form
 */
aux.jQueryFormToJsonString = ($form) =>
{
    var resultObject = {};

    // Get form inputs' values
    const formArray = $form.serializeArray();

    // Transfer data
    for (i = 0; i < formArray.length; i++) {
        const key = formArray[i].name;
        const value = formArray[i].value;

        // If key was already added
        if (resultObject[key]) {
            // If position was already an array
            if (Array.isArray(resultObject[key])) {
                resultObject[key].push(value);
            } else {
                // Else, create an array and insert existing and new values
                const existing = resultObject[key];
                resultObject[key] = [ existing, value ];
            }
        } else {
            resultObject[key] = value;
        }
    }

    return JSON.stringify(resultObject);
}

/**
 * Finds an object with a specific attribute in an array.
 * 
 * @param {array} array
 * @param {string} attributeName
 * @param {string} attributeValue
 */
aux.findObjectInArray = (array, attributeName, attributeValue) =>
{
    for (var i = 0; i < array.length; i++) {
        if (array[i][attributeName] === attributeValue) {
            return array[i];
        }
    }
    
    return null;
}

/**
 * Empties all form controls
 * 
 * @param {jQuery} $form
 */
aux.doEmptyForm = ($form) =>
{
    $form.find('input, select, textarea').val('');
    $form.find('input[type="checkbox"], input[type="radio"]').prop('checked', false);
    $form.find('select, textarea').empty();

    const $formElement = $form.find('form');

    for (var i = 0; i < $formElement.length; i++)
        $formElement[i].reset();
}

/**
 * jQuery on document ready
 */
$(() => {

    /**
     * Inicializar toasts.
     */
    $('#toasts-container .toast').toast('show');

    /**
     * Ocultar todos los toast.
     */
    $(document).on('click', '.toasts-remove-all', () => {
        $('#toasts-container .toast').fadeOut(300, function() {
            $(this).remove();
        });
    });

    /**
     * Side menu.
     */
    $('#btn-side-menu-show').on('click', (e) => {
        e.preventDefault();
        $('#side-menu-wrapper').addClass('active');
    });

    $('#btn-side-menu-hide, #toasts-container, #main-container, #main-footer').on('click', () => {
        $('#side-menu-wrapper').removeClass('active');
    });

    $(document).on('keyup', (e) => {
        if (e.key === "Escape") {
            $('#side-menu-wrapper').removeClass('active');
        }
    });

    /**
     * Loading progress bar.
     */
    var $loadingProgressBar = $('#loading-progress-bar');

    /**
     * AJAX form initialization.
     */
    $(document).on('click', '.btn-ajax-modal-fire', (e) => {
        var $btn = $(e.currentTarget);

        // Get formId.
        var formId = $btn.data('ajax-form-id');

        var $modal = $('.ajax-modal[data-ajax-form-id="' + formId + '"]');
        var url = $modal.data('ajax-submit-url');

        // Check that modal and URL exist
        if (url) {
            $loadingProgressBar.fadeIn();

            // Get formId
            var data = {
                "form-id": formId,
            };

            /**
             * uniqueId represents the id of the record to read, update or
             * delete; it is optional (i. e. in creation forms)
             */
            var uniqueId = $btn.data('ajax-unique-id');
            if (uniqueId) {
                data.uniqueId = uniqueId;
            }

            // Load default data and token
            $.ajax({
                url: url,
                type: 'GET',
                contentType: 'application/json; charset=utf-8',
                dataType: 'json',
                data: data,
                success: (result) => {
                    if (! autoconf.APP_PRODUCTION) {
                        console.log('#btn-ajax-modal-fire click AJAX success');
                        console.log(result);
                    }

                    // Pre-empty form
                    aux.doEmptyForm($modal);

                    // Array for late prevention
                    var linkRels = [];

                    // Get data payload (named with the target object's name)
                    var resultData = result[$modal.data('ajax-target-object-name')];

                    // Check if foreign attribute links were provided
                    if (result.links) {
                        result.links.forEach(link => {
                            linkRels.push(link.rel);

                            // First populate the select
                            var $select = $modal.find('select[name="' + link.rel + '"]');

                            link.data.forEach(value => {
                                const option = '<option value="' + value.uniqueId + '">' + value.selectName + '</option>';
                                $select.append(option);
                            });

                            // Then select the option by id (same for single and multi selects) (first check if any object data was sent)
                            if (resultData) {
                                $modal.find('select[name="' + link.rel + '"]').val(resultData[link.rel]);
                            }
                        });
                    }

                    // Fill form id and CSRF token
                    $modal.find('input[name="form-id"]').val(result['form-id']);
                    $modal.find('input[name="csrf-token"]').val(result['csrf-token']);
                    
                    // Fill form placeholder inputs
                    for (const name in resultData) {
                        // Prevent from filling linked inputs (selects)
                        if ($.inArray(name, linkRels) === -1) {
                            $modal.find('input[name="' + name + '"], textarea[name="' + name + '"]').val(resultData[name]);
                        }
                    }
                    
                    // Hide loader and show modal
                    $loadingProgressBar.fadeOut();
                    $modal.modal('show');
                },
                error: (result) => {
                    // Hide loader and log error
                    $loadingProgressBar.fadeOut();

                    if (! autoconf.APP_PRODUCTION) {
                        console.log('#btn-ajax-modal-fire click AJAX error');
                        console.error(result);
                    }
                }
            });
        }
    });

    /**
     * AJAX form submit processing
     */
    $('.ajax-modal form').on('submit', (e) => {
        e.preventDefault();
        
        $loadingProgressBar.fadeIn();

        const $form = $(e.currentTarget);
        const formDataJson = aux.jQueryFormToJsonString($form);
        const $modal = $form.closest('.ajax-modal');
        
        const onSuccessEventName = $modal.data('ajax-on-success-event-name');
        const onSuccessEventTarget = $modal.data('ajax-on-success-event-target');
        const submitUrl = $modal.data('ajax-submit-url');
        const submitMethod = $modal.data('ajax-submit-method');

        $.ajax({
            url: submitUrl,
            type: submitMethod,
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            data: formDataJson,
            success: (result) => {
                if (! autoconf.APP_PRODUCTION) {
                    console.log('.ajax-modal form submit AJAX success');
                    console.log(result);
                }

                // Copy the modal so data is not emptied on hidden.bs.modal
                const $modalData = $modal;

                // Trigger success event on the target
                if (onSuccessEventName && onSuccessEventTarget) {
                    $(onSuccessEventTarget).trigger(onSuccessEventName, {
                        modalData: $modalData,
                        result: result
                    });
                    
                    if (! autoconf.APP_PRODUCTION) console.log('Triggering event "' + onSuccessEventName + '" on "' + onSuccessEventTarget + '".');
                }

                $modal.modal('hide');

                $loadingProgressBar.fadeOut();

                if (result.messages) {
                    result.messages.forEach(m => toast.success(m));
                }
            },
            error: (result) => {
                $loadingProgressBar.fadeOut();
                toast.error('Hubo un error al procesar el formulario.');
 
                if (result.responseJSON) {
                    // Refill form id and CSRF token.
                    if (result.responseJSON['csrf-token']) {
                        $modal.find('input[name="csrf-token"]').val(result.responseJSON['csrf-token']);
                    }

                    // Show error messages.
                    if (result.responseJSON.messages) {
                        result.responseJSON.messages.forEach(m => toast.error(m));
                    }
                }

                if (! autoconf.APP_PRODUCTION) {
                    console.log('.ajax-modal form submit AJAX error');
                    console.error(result);
                }
            }
        });
    });

    /**
     * AJAX form modal empty on hide
     */
    $('.ajax-modal').on('hidden.bs.modal', (e) => {
        aux.doEmptyForm($(e.currentTarget));
    });

    /**
     * Vista de lista de usuarios (personal de Secretaría).
     */

    $('#usuario-est-lista').on('created.usuario.est',
        onSuccessFn.listaUsuariosEstCreated);
    $('#usuario-est-lista').on('updated.usuario.est',
        onSuccessFn.listaUsuariosUpdated);
    $('#usuario-est-lista').on('deleted.usuario.est',
        onSuccessFn.listaUsuariosDeleted);
    $('#usuario-pd-lista').on('created.usuario.pd',
        onSuccessFn.listaUsuariosPdCreated);
    $('#usuario-pd-lista').on('updated.usuario.pd',
        onSuccessFn.listaUsuariosUpdated);
    $('#usuario-pd-lista').on('deleted.usuario.pd',
        onSuccessFn.listaUsuariosDeleted);
    $('#usuario-ps-lista').on('created.usuario.ps',
        onSuccessFn.listaUsuariosPsCreated);
    $('#usuario-ps-lista').on('updated.usuario.ps',
        onSuccessFn.listaUsuariosUpdated);
    $('#usuario-ps-lista').on('deleted.usuario.ps',
        onSuccessFn.listaUsuariosDeleted);

    /**
     * Vista de asignaciones (personal de Secretaría).
     */

    $('#asignacion-ps-list').on('created.asignacion',
        onSuccessFn.listaPsAsignacionesCreated);
    $('#asignacion-ps-list').on('updated.asignacion',
        onSuccessFn.listaPsAsignacionesUpdated);
    $('#asignacion-ps-list').on('deleted.asignacion',
        onSuccessFn.listaPsAsignacionesDeleted);

    /**
     * Vista de lista de mensajes de Secretaría (usuario en sesión).
     */

    $('#mensaje-secretaria-ses-list').on('created.ses.mensajesecretaria',
        onSuccessFn.listaSesMensajesSecretariaCreated);

    /**
     * Vista de lista de asignaturas (personal de Secretaría).
     */

    $('#asignatura-ps-list').on('created.asignatura',
        onSuccessFn.listaPsAsignaturasCreated);
    $('#asignatura-ps-list').on('updated.asignatura',
        onSuccessFn.listaPsAsignaturasUpdated);
    $('#asignatura-ps-list').on('deleted.asignatura',
        onSuccessFn.listaPsAsignaturasDeleted);

    /**
     * Vista de lista de grupos (personal de Secretaría).
    */

    $('#grupo-list').on('created.grupo',
        onSuccessFn.listaGrupoCreated);
    $('#grupo-list').on('updated.grupo',
        onSuccessFn.listaGrupoUpdated);
    $('#grupo-list').on('deleted.grupo',
        onSuccessFn.listaGrupoDeleted);  
});