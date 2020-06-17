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
 * @author Nicolás Pardina Popp
 * @author Pablo Román Morer Olmos
 * @author Juan Francisco Carrión Molina
 *
 * @version 0.0.4
 */

/**
 * jQuery on document ready
 */
$(() => {
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
});