<?php 

/**
 * Métodos relacionados con las vistas y la generación de contenido visible 
 * para el usuario en el navegador.
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
 * @version 0.0.2
 */

namespace Awsw\Gesi\Vistas;

use Awsw\Gesi\App;

class Vista
{
    // Título de la página actual.
    private static $pagina_actual_nombre;

    // Id de la página actual.
    private static $pagina_actual_id;

    // Directorio donde se encuentran los ficheros comunes.
    private const DIRECTORIO_COMUN = __DIR__ . "/../../comun/";

    // Valor de $_SESSION donde se almacenan los mensajes.
    private const SESSION_MENSAJES = "gesi_mensajes";

    /**
     * Establece el nombre y el id de la página actual.
     * 
     * @param string $nombre Nombre de la página actual.
     * @param string $id Identificador de la página actual.
     */
    private static function setPaginaActual(string $nombre, string $id) : void
    {
        self::$pagina_actual_nombre = $nombre;
        self::$pagina_actual_id = $id;
    }

    /**
     * Devuelve el nombre de la página actual.
     * 
     * @return string Nombre de la página actual.
     */
    public static function getPaginaActualNombre() : string
    {
        return self::$pagina_actual_nombre;
    }

    /**
     * Devuelve el id de la página actual.
     * 
     * @return string Id de la página actual.
     */
    public static function getPaginaActualId() : string
    {
        return self::$pagina_actual_id;
    }

    /**
     * Incluye la cabecera HTML.
     */
    private static function incluirCabecera() : void
    {
        require_once self::DIRECTORIO_COMUN . "cabecera.php";
    }

    /**
     * Incluye el pie HTML.
     */
    private static function incluirPie() : void
    {
        require_once self::DIRECTORIO_COMUN . "pie.php";
    }

    /**
     * 
     * Mensajes para el usuario.
     * 
     */

    /**
     * Añade un mensaje de error a la cola de mensajes para el usuario.
     * 
     * @param string $message Mensaje a mostrar al usuario.
     * @param string $header_location Opcional para redirigir al mismo tiempo 
     * que se encola el mensaje.
     */
    public static function encolaMensajeError(string $mensaje, string $header_location = null) : void
    {
        $_SESSION[self::SESSION_MENSAJES][] = array(
            "tipo" => "error",
            "contenido" => $mensaje
        );

        if ($header_location !== null) {
            header("Location: " . App::getSingleton()->getUrl() . $header_location);
            die();
        }
    }

    /**
     * Añade un mensaje de éxito a la cola de mensajes para el usuario.
     * 
     * @param string $message Mensaje a mostrar al usuario.
     * @param string $header_location Opcional para redirigir al mismo tiempo 
     * que se encola el mensaje.
     */
    public static function encolaMensajeExito(string $mensaje, string $header_location = null) : void
    {
        $_SESSION[self::SESSION_MENSAJES][] = array(
            "tipo" => "exito",
            "contenido" => $mensaje
        );

        if ($header_location !== null) {
            header("Location: " . App::getSingleton()->getUrl() . $header_location);
            die();
        }
    }

    /**
     * Genera un elemento Bootstrap toast para mostrar un mensaje.
     */
    public static function generaToast(string $tipo, string $contenido) : string
    {
        $app = App::getSingleton();
        $autohide = $app->isDesarrollo() ? 'false' : 'true';
        $appNombre = $app->getNombre();

        $toast = <<< HTML
        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-autohide="$autohide" data-delay="3000">
            <div class="toast-header">
                <span class="type-indicator $tipo"></span>
                <strong class="mr-auto">$appNombre</strong>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="toast-body">$contenido</div>
        </div>
        HTML;

        return $toast;
    }

    /**
     * Imprime todos los mensajes de la cola de mensajes.
     */
    public static function imprimeMensajes() : void
    {
        echo '<div id="toasts-container" aria-live="polite" aria-atomic="true">';

        if (! empty($_SESSION[self::SESSION_MENSAJES])) {
            foreach ($_SESSION[self::SESSION_MENSAJES] as $clave => $mensaje) {
                echo self::generaToast($mensaje['tipo'], $mensaje['contenido']);

                // Eliminar mensaje de la cola tras mostrarlo.
                unset($_SESSION[self::SESSION_MENSAJES][$clave]);
            }
        }

        echo '</div>';
    }

    /**
     * Comprueba si hay algún mensaje de error en la cola de mensajes.
     */
    public static function hayMensajesError() : bool
    {
        if (! empty($_SESSION[self::SESSION_MENSAJES])) {
            foreach ($_SESSION[self::SESSION_MENSAJES] as $mensaje) {
                if ($mensaje["tipo"] == "error") {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Dibuja una vista completa.
     */
    public static function dibuja(Modelo $vista) : void
    {
        self::setPaginaActual($vista->getNombre(), $vista->getId());
        
        self::incluirCabecera();

        self::imprimeMensajes();

        echo <<< HTML
        <div id="main-container" class="container mt-4 mb-4">
        HTML;

        $vista->procesaContent();

        echo <<< HTML
        </div>
        HTML;

        self::incluirPie();
    }

    /**
     * Genera un item de una lista no ordenada (<li> de una <ul>) para el menú 
     * principal lateral.
     * 
     * Por defecto añade la ruta de la URL principal al principio del enlace.
     * 
     * @param string $url
     * @param string $titulo
     * @param string $paginaId Identificador de la página de destino, para saber
     *                         si es la actual.
     */
    public static function generarSideMenuLink(string $url, string $titulo, string $paginaId) : string
    {
        $appUrl = App::getSingleton()->getUrl();

        $activeClass = Vista::getPaginaActualId() === $paginaId ? 'active' : '';

        $classAttr = 'class="list-group-item list-group-item-action ' . $activeClass . '"';
        $hrefAttr = 'href="' . $appUrl . $url . '"';

        $li = <<< HTML
        <li $classAttr><a $hrefAttr>$titulo</a></li>
        HTML;

        return $li;
    }

    /**
     * Genera un item de una lista no ordenada (<li> de una <ul>) para el menú 
     * de sesión de usuario.
     * 
     * Por defecto añade la ruta de la URL principal al principio del enlace.
     * 
     * @param string $content
     * @param string|null $paginaId Identificador de la página de destino, para 
     *                              saber si es la actual.
     */
    public static function generarUserMenuItem(string $content, $paginaId = null) : string
    {
        $activeClass = Vista::getPaginaActualId() === $paginaId ? 'active' : '';

        $classAttr = 'class="nav-item ' . $activeClass . '"';

        $li = <<< HTML
        <li $classAttr>$content</li>
        HTML;

        return $li;
    }

    /**
     * Genera un item divisor de una lista no ordenada (<li> de una <ul>) para 
     * el menú principal lateral.
     * 
     * @param string $url
     * @param string $titulo
     * @param string $paginaId Identificador de la página de destino, para saber
     *                         si es la actual.
     */
    public static function generarSideMenuDivider(string $titulo) : string
    {
        $classAttr = 'class="list-group-item mt-3"';

        $li = <<< HTML
        <li $classAttr>$titulo</li>
        HTML;

        return $li;
    }
}