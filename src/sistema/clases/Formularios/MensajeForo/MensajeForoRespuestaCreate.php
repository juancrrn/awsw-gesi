<?php

/**
 * Crea una respuesta a un mensaje de un foro.
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

namespace Awsw\Gesi\Formularios\MensajeForo;

use Awsw\Gesi\Datos\MensajeForo;
use Awsw\Gesi\Formularios\Formulario;
use Awsw\Gesi\Sesion;
use Awsw\Gesi\Vistas\Vista;

class MensajeForoRespuestaCreate extends Formulario
{

    private const FORM_ID = 'form-mensaje-foro-respuesta-create';

    private $foroId;

    public function __construct(string $action, int $foroId) {
        parent::__construct(self::FORM_ID, array('action' => $action));

        $this->foroId = $foroId;
    }
    
    protected function generaCampos(array & $datos_iniciales = array()): string
    {
        $padreId = $datos_iniciales['padreId'];

        $html = <<< HTML
        <input type="hidden" name="padreId" value="$padreId">
        <div class="form-group">
            <textarea class="form-control" name="contenido" placeholder="Responder..." required="required"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Continuar</button>
        HTML;

        return $html;
    }
    
    protected function procesa(array & $datos): void
    {
        $padreId = $datos['padreId'] ?? null;

        if (empty($padreId) || ! MensajeForo::dbExisteId($padreId)) {
            Vista::encolaMensajeError('Hubo un error al procesar el formulario.');
        } else {
            $padre = MensajeForo::dbGet($padreId);

            if (! $padre->getForo() == $this->foroId) {
                Vista::encolaMensajeError('Hubo un error al procesar el formulario.');
            }
        }

        $contenido = $datos['contenido'] ?? null;

        if (empty($contenido)) {
            Vista::encolaMensajeError('El campo contenido no puede estar vacío.');
        }

        // Comprobar si hay errores.
        if (empty($errors)) {
            $now = date('Y-m-d H:i:s');

            $mensaje = new MensajeForo(
                null,
                $this->foroId,
                $padreId,
                Sesion::getUsuarioEnSesion()->getId(),
                $now,
                $contenido
            );

            if ($mensaje->dbInsertar()) {
                Vista::encolaMensajeExito('La respuesta se creó correctamente.');
            } else {
                Vista::encolaMensajeError('Hubo un error al crear la respuesta.');
            }
        }
    }
}

?>