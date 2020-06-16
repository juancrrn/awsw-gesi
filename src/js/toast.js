/**
 * JavaScript de mensajes toast.
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

/**
 * Objeto para namespace.
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
});