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
use Awsw\Gesi\Datos\Usuario;
use Awsw\Gesi\Formularios\Valido;
use Awsw\Gesi\FormulariosAjax\MensajeSecretaria\MensajeSecretariaPsRead;
use Awsw\Gesi\Vistas\Modelo;
use Awsw\Gesi\Sesion;

class MensajeSecretariaPsList extends Modelo
{
    public const VISTA_NOMBRE = 'Mensajes de Secretaría';
    public const VISTA_ID = 'mensaje-secretaria-ps-list';

    private $listado;

    public function __construct()
    {
        Sesion::requerirSesionIniciada();

        $this->nombre = self::VISTA_NOMBRE;
        $this->id = self::VISTA_ID;

        $this->listado = MensajeSecretaria::dbGetAll();
    }

    public function procesaContent(): void
    {
        // Read mensaje de Secretaría.
        $formPsRead = new MensajeSecretariaPsRead();
        $formPsReadModal = $formPsRead->generateModal();

        $listaMensajes = $this->generaListaMensajesSecretaria($formPsRead);

        $html = <<< HTML
        <h2 class="mb-4">$this->nombre</h2>
        <p>A continuación se muestra una lista con los mensajes de Secretaría que has enviado.</p>
        <table id="mensaje-secretaria-ses-list" class="table table-borderless table-striped">
            <thead>
                <tr>
                    <th scope="col">Tipo</th>
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
        $formPsReadModal
        HTML;

        echo $html;

    }

    public function generaListaMensajesSecretaria(MensajeSecretariaPsRead $formPsRead): string
    {
        $buffer = '';

        if (! empty($this->listado)) {
            foreach ($this->listado as $mensaje) {
                if ($mensaje->getUsuario()) {
                    $badge = 'Registrado';
                    $nombre = Usuario::dbGet($mensaje->getUsuario())
                        ->getNombreCompleto();
                } else {
                    $badge = 'Invitado';
                    $nombre = $mensaje->getFromNombre();
                }

                $fechaConvertida = $mensaje->getFecha(Valido::ESP_DATETIME_SHORT_FORMAT);

                $extractoContenido = $mensaje->getContenido(32);

                $formPsReadBtn = $formPsRead->generateButton('Ver', $mensaje->getId(), true);
                
                $buffer .= <<< HTML
                <tr>
                    <td><span class="badge badge-secondary">$badge</span></td>
                    <td>$nombre</td>
                    <td>$fechaConvertida</td>
                    <td>$extractoContenido</td>
                    <td class="text-right">$formPsReadBtn</td>
                </tr>
                HTML;
            }
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