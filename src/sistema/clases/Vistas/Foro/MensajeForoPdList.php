<?php 

/**
 * Vistas de foros.
 *
 * - PDI: puede ver y gestionar todos los foros.
 * - Resto: pueden ver los foros a los que tienen acceso.
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

namespace Awsw\Gesi\Vistas\Foro;

use Awsw\Gesi\Sesion;


use Awsw\Gesi\Datos\Asignacion;
use Awsw\Gesi\Datos\Asignatura;
use Awsw\Gesi\Datos\Foro;
use Awsw\Gesi\Datos\MensajeForo;
use Awsw\Gesi\Datos\Usuario;
use Awsw\Gesi\Formularios\Valido;
use Awsw\Gesi\Vistas\Modelo;
use Awsw\Gesi\Vistas\Vista;

class MensajeForoPdList extends Modelo
{
    private const VISTA_NOMBRE = "Ver foro";
    private const VISTA_ID = "mensaje-foro-pd-list";

    private $foro;
    private $mensajes;
    private $asignacion;
    private $profesor;
    private $asignatura;

    public function __construct($foroId)
    {
        Sesion::requerirSesionPd();

        if (! Foro::dbExisteId($foroId)) {
            Vista::encolaMensajeError('El foro solicitado no existe.', '');
        } elseif (! Foro::dbPdTienePermiso(Sesion::getUsuarioEnSesion()->getId(), $foroId)) {
            Vista::encolaMensajeError('No tienes permisos para acceder a este foro.', '');
        }

        $this->nombre = self::VISTA_NOMBRE;
        $this->id = self::VISTA_ID;

        $this->foro = Foro::dbGet($foroId);
        $this->mensajes = MensajeForo::getAllByForo($foroId);
        $this->asignacion = Asignacion::dbGetByForoPrincipal($foroId);
        $this->profesor = Usuario::dbGet($this->asignacion->getProfesor());
        $this->asignatura = Asignatura::dbGet($this->asignacion->getAsignatura());
    }

    public function procesaContent(): void
    {
        $nombreForo = $this->foro->getNombre();
        $nombreAsignatura = $this->asignatura->getNombreCompleto();
        $nombreProfesor = $this->profesor->getNombreCompleto();

        $mensajes = $this->generaListaMensajes();
        
        echo <<< HTML
        <h2 class="mb-4">$this->nombre</h2>
        <header class="mb-5">
            <h3 class="mb-3">$nombreForo</h3>
            <p class="mb-3">Este foro figura como foro principal de asignatura con los siguientes datos:</p>
            <p class="mb-2">
                <span class="badge badge-secondary">Asignatura</span>
                $nombreAsignatura
            </p>
            <p>
                <span class="badge badge-secondary">Profesor</span>
                $nombreProfesor
            </p>
        </header>
        <div id="mensaje-foro-ses-list">
            $mensajes
        </div>
        HTML;

    }

    private function generaListaMensajes(): string
    {
        if (! empty($this->mensajes)) {
            $buffer = '';

            foreach ($this->mensajes as $mensaje) {
                $autor = Usuario::dbGet($mensaje->getUsuario())
                    ->getNombreCompleto();
                $fecha = \DateTime::createFromFormat(Valido::MYSQL_DATETIME_FORMAT, $mensaje->getFecha())
                    ->format(Valido::ESP_DATETIME_SHORT_FORMAT);
                $contenido = $mensaje->getContenido();
                $respuestas = $this->generaRespuestasMensajes($mensaje);

                $buffer .= <<< HTML
                <div class="card">
                    <div class="card-header">
                        <p><strong>$autor</strong></p>
                        <p>$fecha</p>
                    </div>
                    <div class="card-body">
                        $contenido
                        <p class="mt-3 text-right"><button class="btn btn-sm btn-primary">Responder</button></p>
                    </div>
                    <ul class="list-group list-group-flush">
                        $respuestas
                    </ul>
                </div>
                HTML;
            }
        } else {
            $buffer = <<< HTML
            <div class="card">
                <div class="card-body">
                    <p>No se han encontrado mensajes en este foro.</p>
                </div>
            </div>
            HTML;
        }

        return $buffer;
    }

    private function generaRespuestasMensajes(MensajeForo $mensaje): string
    {
        $buffer = '';

        // TODO recoger respuestas de los mensajes.

        $buffer .= <<< HTML
        <li class="list-group-item">Respuesta</li>
        <li class="list-group-item">Respuesta</li>
        <li class="list-group-item">Respuesta</li>
        HTML;

        return $buffer;
    }
}

?>