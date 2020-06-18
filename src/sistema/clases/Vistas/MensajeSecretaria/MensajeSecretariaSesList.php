<?php 

/**
 * Vista de mensajes de Secretaría por un usuario registrado, del rol que sea.
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

namespace Awsw\Gesi\Vistas\MensajeSecretaria;

use Awsw\Gesi\Datos\MensajeSecretaria;
use Awsw\Gesi\Validacion\Valido;
use Awsw\Gesi\FormulariosAjax\MensajeSecretaria\MensajeSecretariaSesCreate;
use Awsw\Gesi\FormulariosAjax\MensajeSecretaria\MensajeSecretariaSesRead;
use Awsw\Gesi\Vistas\Modelo;
use Awsw\Gesi\Sesion;

class MensajeSecretariaSesList extends Modelo
{
    public const VISTA_NOMBRE = "Contactar con Secretaría";
    public const VISTA_ID = "mensaje-secretaria-ses-list";

    private $listado;

    public function __construct()
    {
        Sesion::requerirSesionIniciada();

        $this->nombre = self::VISTA_NOMBRE;
        $this->id = self::VISTA_ID;

        $this->listado = MensajeSecretaria::dbGetByUsuario(Sesion::getUsuarioEnSesion()->getId());
    }

    public function procesaContent(): void
    {
        // Create mensaje de Secretaría.
        $formSesCreate = new MensajeSecretariaSesCreate();
        $formSesCreateModal = $formSesCreate->generateModal();

        // Read mensaje de Secretaría.
        $formSesRead = new MensajeSecretariaSesRead();
        $formSesReadModal = $formSesRead->generateModal();

        $listaMensajes = $this->generaListaMensajesSecretaria($formSesRead);

        $formSesCreateButton = $formSesCreate
            ->generateButton('Nuevo mensaje', null, true);

        $html = <<< HTML
        <h2 class="mb-4">$formSesCreateButton $this->nombre</h2>
        <p>A continuación se muestra una lista con los mensajes de Secretaría que has enviado.</p>
        <table id="mensaje-secretaria-ses-list" class="table table-borderless table-striped">
            <thead>
                <tr>
                    <th scope="col">De</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Contenido</th>
                    <th scope="col" class="text-right">Acciones</th>
                </tr>
            </thead>
            <tbody>
                $listaMensajes
            </tbody>
        </table>
        $formSesCreateModal
        $formSesReadModal
        HTML;

        echo $html;

    }

    public function generaListaMensajesSecretaria(MensajeSecretariaSesRead $formSesRead): string
    {
        $buffer = '';

        if (! empty($this->listado)) {
            foreach ($this->listado as $mensaje) {
                $fechaConvertida = $mensaje->getFecha(Valido::ESP_DATETIME_SHORT_FORMAT);

                $extractoContenido = $mensaje->getContenido(32);

                $formSesReadBtn = $formSesRead->generateButton('Ver', $mensaje->getId(), true);
                
                $buffer .= <<< HTML
                <tr>
                    <td data-col-name="usuario">(Yo)</td>
                    <td data-col-name="fecha">$fechaConvertida</td>
                    <td data-col-name="extractoContenido">$extractoContenido</td>
                    <td class="text-right">$formSesReadBtn</td>
                </tr>
                HTML;
            }

            //$buffer .= $formSesReadModal;
        } else {
            $buffer .= <<< HTML
            <tr>
                <td></td>
                <td></td>
                <td>Aún no has enviado ningún mensaje de Secretaría.</td>
                <td></td>
            </tr>
            HTML;
        }

        return $buffer;
    }
}

?>