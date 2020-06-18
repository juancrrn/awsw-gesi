<?php 

namespace Awsw\Gesi\Vistas\Sesion;

use Awsw\Gesi\App;
use Awsw\Gesi\Sesion;
use Awsw\Gesi\Vistas\Modelo;

/**
 * Vista de perfil de un usuario en particular.
 *
 * - Cualquier usuario con sesión puede acceder.
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

class SesionPerfil extends Modelo
{

    private const VISTA_NOMBRE = "Mi perfil ";
    private const VISTA_ID = "mi-perfil";

    private $usuario;

    public function __construct()
    {
        Sesion::requerirSesionIniciada();

        $this->usuario = Sesion::getUsuarioEnSesion();

        $this->nombre = self::VISTA_NOMBRE;
        $this->id = self::VISTA_ID;
    }

    public function procesaContent() : void
    {
        $app = App::getSingleton();
        $urlSecretaria = $app->getUrl() . '/ses/secretaria/';

        switch ($this->usuario->getRol()) {
            case 1: $rol = 'Estudiante'; break;
            case 2: $rol = 'Personal docente'; break;
            case 3: $rol = 'Personal de Secretaría'; break;
        }

        $nif = $this->usuario->getNif();
        $nombre = $this->usuario->getNombre();
        $apellidos = $this->usuario->getApellidos();
        $email = $this->usuario->getEmail();
        $numeroTelefono = $this->usuario->getNumeroTelefono();
        $fechaNacimiento = $this->usuario->getFechaNacimiento();
        $fechaUltimoAcceso = $this->usuario->getFechaUltimoAcceso();

        $html = <<< HTML
        <h2 class="mb-4">$this->nombre</h2>
        <p class="mb-3">A continuación se muestran los datos personales recogidos en Gesi sobre tu usuario. Si necesitas modificar alguno, por favor, <a href="$urlSecretaria">ponte en contacto con Secretaría</a>.</p>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Rol</label>
                <input type="text" class="form-control" value="$rol" disabled="disabled">
            </div>
            <div class="form-group col-md-6">
                <label>NIF o NIE</label>
                <input type="text" class="form-control" value="$nif" disabled="disabled">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Nombre</label>
                <input type="text" class="form-control" value="$nombre" disabled="disabled">
            </div>
            <div class="form-group col-md-6">
                <label>Apellidos</label>
                <input type="text" class="form-control" value="$apellidos" disabled="disabled">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Dirección de correo electrónico</label>
                <input type="text" class="form-control" value="$email" disabled="disabled">
            </div>
            <div class="form-group col-md-6">
                <label>Número de teléfono</label>
                <input type="text" class="form-control" value="$numeroTelefono" disabled="disabled">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Fecha de nacimiento</label>
                <input type="text" class="form-control" value="$fechaNacimiento" disabled="disabled">
            </div>
            <div class="form-group col-md-6">
                <label>Fecha y hora de último acceso</label>
                <input type="text" class="form-control" value="$fechaUltimoAcceso" disabled="disabled">
            </div>
        </div>
        HTML;

        echo $html;
    }
}

?>