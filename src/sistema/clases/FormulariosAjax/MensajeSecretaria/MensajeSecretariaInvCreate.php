<?php

namespace Awsw\Gesi\FormulariosAjax\MensajeSecretaria;

use Awsw\Gesi\App;
use Awsw\Gesi\Datos\MensajeSecretaria;
use Awsw\Gesi\Formularios\Valido;
use Awsw\Gesi\FormulariosAjax\FormularioAjax;
use Awsw\Gesi\Sesion;

/**
 * Formulario AJAX de creación de un mensaje de Secretaría por parte de un 
 * usuario invitado (sin sesión iniciada).
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

class MensajeSecretariaInvCreate extends FormularioAjax
{

    /**
     * Initialize specific form constants
     *
     * @var string FORM_ID
     * @var string FORM_NAME
     * @var string DATA_OBJECT_NAME
     * @var string SUBMIT_URL
     * @var string EXPECTED_SUBMIT_METHOD
     * @var string ON_SUCCESS_EVENT_NAME
     * @var string ON_SUCCESS_EVENT_TARGET
     */
    private const FORM_ID = 'mensaje-secretaria-inv-create';
    private const FORM_NAME = 'Crear mensaje de Secretaría';
    private const TARGET_CLASS_NAME = 'MensajeSecretaria';
    private const SUBMIT_URL = '/inv/mensajesecretaria/create/';
    private const EXPECTED_SUBMIT_METHOD = FormularioAjax::HTTP_POST;

    /**
     * Constructs the form object.
     */
    public function __construct($api = false)
    {
        Sesion::requerirSesionNoIniciada($api);

        $app = App::getSingleton();

        parent::__construct(
            self::FORM_ID,
            self::FORM_NAME,
            self::TARGET_CLASS_NAME,
            $app->getUrl() . self::SUBMIT_URL,
            self::EXPECTED_SUBMIT_METHOD
        );
    }

    protected function getDefaultData(array $requestData) : array
    {
        $responseData = array(
            'status' => 'ok',
        );

        return $responseData;
    }

    public function generateFormInputs(): string
    {
        $html = <<< HTML
        <div class="form-group">
            <label for="fromNombre">Nombre</label>
            <input class="form-control" type="text" name="fromNombre" id="fromNombre" placeholder="Nombre" required="required" />
        </div>
        <div class="form-group">
            <label for="fromEmail">Dirección de correo electrónico</label>
            <input class="form-control" type="email" name="fromEmail" id="fromEmail" placeholder="Dirección de correo electrónico" required="required" />
        </div>
        <div class="form-group">
            <label for="fromTelefono">Número de teléfono</label>
            <input class="form-control" type="text" name="fromTelefono" id="fromTelefono" placeholder="Número de teléfono" required="required" />
        </div>
        <div class="form-group">
            <label for="contenido">Contenido del mensaje</label>
            <textarea class="form-control" name="contenido" id="contenido" rows="3" placeholder="Contenido del mensaje"></textarea>
        </div>
        HTML;

        return $html;
    }

    public function processSubmit(array $data = array()): void
    {
        $fromNombre = $data['fromNombre'] ?? null;
        $fromEmail = $data['fromEmail'] ?? null;
        $fromTelefono = $data['fromTelefono'] ?? null;
        $contenido = $data['contenido'] ?? null;

        if (empty($fromNombre)) {
            $errors[] = 'El campo nombre no puede estar vacío.';
        } elseif (! Valido::testStdString($fromNombre)) {
            $errors[] = 'El campo nombre no es válido. Solo puede contener letras, espacios y guiones; y debe tener entre 3 y 128 caracteres.';
        }

        if (empty($fromEmail)) {
            $errors[] = 'El campo dirección de correo electrónico no puede estar vacío.';
        } elseif (! Valido::testEmail($fromEmail)) {
            $errors[] = 'El campo dirección de correo electrónico no es válido.';
        }

        if (empty($fromTelefono)) {
            $errors[] = 'El campo número de teléfono no puede estar vacío.';
        } elseif (! Valido::testNumeroTelefono($fromTelefono)) {
            $errors[] = 'El campo número de teléfono no es válido.';
        }

        if (empty($contenido)) {
            $errors[] = 'El campo contenido no puede estar vacío.';
        }

        // Comprobar si hay errores.
        if (! empty($errors)) {
            $this->respondJsonError(400, $errors); // Bad request.
        } else {
            $now = date('Y-m-d H:i:s');

            $mensaje = new MensajeSecretaria(
                null,
                null,
                $fromNombre,
                $fromEmail,
                $fromTelefono,
                $now,
                $contenido
            );

            if ($mensaje->dbInsertar()) {
                $responseData = array(
                    'status' => 'ok',
                    'messages' => array('Mensaje de Secretaría enviado correctamente.')
                );
                
                $this->respondJsonOk($responseData);
            } else {
                $errors[] = 'Hubo un error al enviar el mensaje de Secretaría.';

                $this->respondJsonError(400, $errors); // Bad request.
            }
        }
    }
}

?>