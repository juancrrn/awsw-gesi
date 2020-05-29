<?php 

/**
 * Vista de landing.
 *
 * Invitados: verán información de acceso público.
 * Usuarios registrados: verán información personalizada.
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

namespace Awsw\Gesi\Vistas\Home;

use \Awsw\Gesi\Sesion;
use \Awsw\Gesi\App;
use Awsw\Gesi\Vistas\Modelo;

class Home extends Modelo
{
    public const VISTA_NOMBRE = 'Inicio';
    public const VISTA_ID = 'inicio';

    public function __construct()
    {
        $this->nombre = self::VISTA_NOMBRE;
        $this->id = self::VISTA_ID;
    }

    public function procesaContent() : void
    {

        $saludo = '';

        if (Sesion::isSesionIniciada()) {
            $saludo = $this->generaConSesion();
        } else {
            $saludo = $this->generaSinSesion();
        }

        $html = <<< HTML
        <h2 class="mb-4">$this->nombre</h2>
        <div class="row">
            <div class="col"></div>
            <div class="col-mb-5 px-2 text-center">
                $saludo
            </div>
            <div class="col"></div>
        </div>
        HTML;

        echo $html;

    }

    private function generaConSesion() : string
    {
        $app = App::getSingleton();
        $nombre = Sesion::getUsuarioEnSesion()->getNombre();

        $urlImagen = $app->getUrl() . '/img/landing.svg';

        $html = <<< HTML
        <h3 class="mb-5">¡Hola, $nombre!</h3>
        <img src="$urlImagen" alt="Gesi" class="mb-4">
        <p class="mb-3">Te damos la bienvenida a Gesi.</p>
        <p class="mb-3">Mira todo lo que puedes hacer abriendo el menú lateral.</p>
        HTML;

        return $html;
    }

    private function generaSinSesion() : string
    {
        $app = App::getSingleton();

        $urlImagen = $app->getUrl() . '/img/landing.svg';
        $urlIniciar = $app->getUrl() . '/sesion/iniciar/';
        
        $html = <<< HTML
        <h3 class="mb-5">¡Hola!</h3>
        <img src="$urlImagen" alt="Gesi" class="mb-4">
        <p class="mb-3">Te damos la bienvenida. Gesi es la aplicación web que gestiona tu instituto de educación secundaria.</p>
        <p class="mb-3">Accede a tus contenidos iniciando sesión.</p>
        <p><a class="btn btn-primary" href="$urlIniciar">Iniciar sesión</a></p>
        HTML;

        return $html;
    }
}

?>