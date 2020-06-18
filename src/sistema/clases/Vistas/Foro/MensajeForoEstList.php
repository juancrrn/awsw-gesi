<?php

namespace Awsw\Gesi\Vistas\Foro;

use Awsw\Gesi\Sesion;

use Awsw\Gesi\Datos\Asignacion;
use Awsw\Gesi\Datos\Asignatura;
use Awsw\Gesi\Datos\Foro;
use Awsw\Gesi\Datos\MensajeForo;
use Awsw\Gesi\Datos\Usuario;

use Awsw\Gesi\Formularios\MensajeForo\MensajeForoRespuestaCreate as MensajeForoMensajeForoRespuestaCreate;
use Awsw\Gesi\FormulariosAjax\MensajeForo\MensajeForoCreate as MensajeForoCreate;

use Awsw\Gesi\Validacion\Valido;

use Awsw\Gesi\Vistas\Modelo;
use Awsw\Gesi\Vistas\Vista;

/**
 * Vistas de foro de un estudiante.
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

class MensajeForoEstList extends Modelo
{
    private const VISTA_NOMBRE = "Ver foro";
    private const VISTA_ID = "mensaje-foro-est-list";

    private $formRespuesta;

    private $foro;
    private $mensajes;
    private $asignacion;
    private $profesor;
    private $asignatura;

    public function __construct($foroId)
    {
        Sesion::requerirSesionEst();
        
        if (! Foro::dbExisteId($foroId)) {
            Vista::encolaMensajeError('El foro solicitado no existe.', '');
        } elseif (! Foro::dbEstTienePermiso(Sesion::getUsuarioEnSesion()->getId(), $foroId)) {
            Vista::encolaMensajeError('No tienes permisos para acceder a est foro.', '');
        }

        $this->nombre = self::VISTA_NOMBRE;
        $this->id = self::VISTA_ID;

        $this->foro = Foro::dbGet($foroId);

        $this->formRespuesta = new MensajeForoMensajeForoRespuestaCreate('/est/foros/' . $this->foro->getId() . '/', $this->foro->getId());
        $this->formRespuesta->gestiona();

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

        $formMensajePrincipal = new MensajeForoCreate(true, $this->foro->getId());
        $modalMensajePrincipal = $formMensajePrincipal->generateModal();
        $botonMensajePrincipal = $formMensajePrincipal->generateButton('Crear un mensaje nuevo', null);

        $mensajes = $this->generaListaMensajes();
        
        echo <<< HTML
        <h2 class="mb-4">$this->nombre</h2>
        <header class="mb-5">
            <h3 class="mb-3">$nombreForo</h3>
            <p class="mb-3">Este foro figura como foro principal de asignatura con los siguientes datos:</p>
            <p class="mb-2">
                <span class="badge badge-primary">Asignatura</span>
                $nombreAsignatura
            </p>
            <p class="mb-4">
                <span class="badge badge-primary">Profesor</span>
                $nombreProfesor
            </p>
            <p>$botonMensajePrincipal</p>
        </header>
        <div id="mensaje-foro-ses-list">
            $mensajes
        </div>
        $modalMensajePrincipal
        HTML;
    }

    private function generaListaMensajes(): string
    {
        $bufferModales = '';

        if (! empty($this->mensajes)) {
            $buffer = '';

            foreach ($this->mensajes as $mensaje) {
                $usuario = Usuario::dbGet($mensaje->getUsuario());
                $autor = $usuario->getNombreCompleto();
                $fecha = \DateTime::createFromFormat(Valido::MYSQL_DATETIME_FORMAT, $mensaje->getFecha())
                    ->format(Valido::ESP_DATETIME_SHORT_FORMAT);
                $contenido = htmlspecialchars($mensaje->getContenido());
                $respuestas = $this->generaRespuestasMensaje($mensaje);
                $badgeProfesor = $usuario->getId() == $this->profesor->getId() ? '<span class="badge badge-primary">Profesor</span>' : '';

                $mensajeId = $mensaje->getId();
                $contenedorRespuestas = 'mensaje-foro-respuestas-' . $mensajeId;

                $default = array('padreId' => $mensajeId);
                $this->formRespuesta->genera($default);
                $textarea = $this->formRespuesta->getHtml();
                
                $buffer .= <<< HTML
                <div class="card mb-2">
                    <div class="card-header">
                    <p class="mb-2"><span class="badge badge-secondary">Mensaje principal ($fecha)</span></p>
                        <p class="mb-2"><strong>$autor</strong> $badgeProfesor</p>
                        <p class="mb-4">$contenido</p>
                    </div>
                    <ul class="list-group list-group-flush mensaje-foro-ses-respuestas-list" id="$contenedorRespuestas">
                        $respuestas
                        <li class="list-group-item">$textarea</li>
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

        return $buffer . $bufferModales;
    }

    private function generaRespuestasMensaje(MensajeForo $mensaje): string
    {
        $buffer = '';

        $respuestas = $mensaje->dbGetRespuestas();

        foreach ($respuestas as $respuesta) {
            $usuario = Usuario::dbGet($respuesta->getUsuario());
            $nombre = $usuario->getNombreCompleto();
            $fecha = \DateTime::createFromFormat(Valido::MYSQL_DATETIME_FORMAT, $respuesta->getFecha())
            ->format(Valido::ESP_DATETIME_SHORT_FORMAT);
            $contenido = htmlspecialchars($respuesta->getContenido());
            $badgeProfesor = $usuario->getId() == $this->profesor->getId() ? '<span class="badge badge-primary">Profesor</span>' : '';

            $buffer .= <<< HTML
            <li class="list-group-item">
                <p class="mb-2"><span class="badge badge-secondary">Respuesta ($fecha)</span></p>
                <p class="mb-2"><strong>$nombre</strong> $badgeProfesor</p>
                <p>$contenido</p>
            </li>
            HTML;
        }

        return $buffer;
    }
}

?>