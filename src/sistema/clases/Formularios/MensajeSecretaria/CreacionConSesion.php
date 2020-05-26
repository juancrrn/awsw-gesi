<?php

/**
 * Gesión del formulario de creación de un mensaje de secretaría
 * con sesión iniciada.
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

namespace Awsw\Gesi\Formularios\MensajeSecretaria;

use \Awsw\Gesi\Formularios\Formulario;
use \Awsw\Gesi\Datos\MensajeSecretaria;
use \Awsw\Gesi\Vistas\Vista;
use \Awsw\Gesi\Sesion;

class CreacionConSesion extends Formulario
{
    public function __construct(string $action) {
        parent::__construct('form-creacion-mensaje-con-sesion', array('action' => $action));
    }
    
    protected function generaCampos(array & $datos_iniciales = array()) : void
    {
        $from_nombre = Sesion::getUsuarioEnSesion()->getNombreCompleto();
        $from_email = Sesion::getUsuarioEnSesion()->getEmail();
        $from_telefono = Sesion::getUsuarioEnSesion()->getNumeroTelefono();
        $contenido = "";

        if (! empty($datos_iniciales)) {
            $contenido = isset($datos_iniciales["contenido"]) ? $datos_iniciales["contenido"] : $contenido;
        }

        $this->html .= '<div class="form-group">';
        $this->html .= '<label for="from_nombre">Nombre</label>';
        $this->html .= '<input class="form-control" id="from_nombre" type="text" name="from_nombre" placeholder="Nombre" value="' . $from_nombre . '" disabled="disabled">';
        $this->html .= '</div>';

        $this->html .= '<div class="form-group">';
        $this->html .= '<label for="from_email">Dirección de correo electrónico</label>';
        $this->html .= '<input class="form-control" id="from_email" type="text" name="from_email" placeholder="Dirección de correo electrónico" value="' . $from_email . '" disabled="disabled">';
        $this->html .= '</div>';

        $this->html .= '<div class="form-group">';
        $this->html .= '<label for="from_telefono">Número de teléfono</label>';
        $this->html .= '<input class="form-control" id="from_telefono" type="text" name="from_telefono" placeholder="Número de teléfono" value="' . $from_telefono . '" disabled="disabled">';
        $this->html .= '</div>';

        $this->html .= '<div class="form-group">';
        $this->html .= '<label for="contenido">Contenido del mensaje</label>';
        $this->html .= '<textarea class="form-control" id="contenido" type="text" name="contenido" placeholder="Contenido del mensaje" value="' . $contenido . '"></textarea>';
        $this->html .= '</div>';

        $this->html .= '<button type="submit" class="btn" name="login">Entrar</button>';
    }
    
    /**
     * Procesa un formulario enviado.
     */
    protected function procesa(array & $datos) : void
    {
        $contenido = isset($datos["contenido"]) ? $datos["contenido"] : null;

        if (empty($contenido)) {
            Vista::encolaMensajeError("El contenido del mensaje no puede estar vacío.");
        }

        // Si no hay ningún error, continuar.
        if (! Vista::hayMensajesError()) {
            $mensaje = new MensajeSecretaria(
                null,
                Sesion::getUsuarioEnSesion()->getId(),
                null,
                null,
                null,
                time(),
                $contenido
            );

            if ($mensaje->dbInsertar()) {
                Vista::encolaMensajeExito("Tu mensaje se ha enviado correctamente.");
            }
        }

        $this->genera();

    }
}