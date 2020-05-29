<?php 

/**
 * Vista de mensajes de Secretaría por un invitado.
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

namespace Awsw\Gesi\Vistas\MensajeSecretaria;

use Awsw\Gesi\FormulariosAjax\MensajeSecretaria\MensajeSecretariaInvCreate;
use Awsw\Gesi\Vistas\Modelo;
use Awsw\Gesi\Sesion;

class MensajeSecretariaInvList extends Modelo
{
    public const VISTA_NOMBRE = "Contactar con Secretaría";
    public const VISTA_ID = "mensaje-secretaria-inv-list";

    public function __construct()
    {
        Sesion::requerirSesionNoIniciada();

        $this->nombre = self::VISTA_NOMBRE;
        $this->id = self::VISTA_ID;
    }

    public function procesaContent(): void
    {
        $form = new MensajeSecretariaInvCreate();
        $formModal = $form->generateModal();
        $formButton = $form->generateButton('Enviar mensaje a Secretaría');

        $html = <<< HTML
        <h2 class="mb-4">$this->nombre</h2>
        <div class="row">
            <div class="col"></div>
            <div class="col-5 text-center">
                <p class="mb-3">Si necesitas contactar con Secretaría, simplemente tienes que rellenar este formulario para enviar un mensaje:</p>
                $formButton
            </div>
            <div class="col"></div>
        </div>
        $formModal
        HTML;

        echo $html;

    }
}

?>