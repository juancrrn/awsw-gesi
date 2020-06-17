<?php

namespace Awsw\Gesi\FormulariosAjax\MensajeSecretaria;

use Awsw\Gesi\App;
use Awsw\Gesi\Datos\MensajeSecretaria;
use Awsw\Gesi\FormulariosAjax\FormularioAjax;
use Awsw\Gesi\Sesion;

/**
 * Formulario AJAX de creación de un mensaje de Secretaría por parte de un 
 * usuario con sesión iniciada, del rol que sea.
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

class MensajeSecretariaSesCreate extends FormularioAjax
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
    private const FORM_ID = 'mensaje-secretaria-ses-create';
    private const FORM_NAME = 'Crear mensaje de Secretaría';
    private const TARGET_CLASS_NAME = 'MensajeSecretaria';
    private const SUBMIT_URL = '/ses/mensajesecretaria/create/';
    private const EXPECTED_SUBMIT_METHOD = FormularioAjax::HTTP_POST;
    private const ON_SUCCESS_EVENT_NAME = 'created.ses.mensajesecretaria';
    private const ON_SUCCESS_EVENT_TARGET = '#mensaje-secretaria-ses-list';

    /**
     * Constructs the form object.
     */
    public function __construct($api = false)
    {
        Sesion::requerirSesionIniciada($api);

        $app = App::getSingleton();

        parent::__construct(
            self::FORM_ID,
            self::FORM_NAME,
            self::TARGET_CLASS_NAME,
            $app->getUrl() . self::SUBMIT_URL,
            self::EXPECTED_SUBMIT_METHOD
        );

        $this->setOnSuccess(
            self::ON_SUCCESS_EVENT_NAME,
            self::ON_SUCCESS_EVENT_TARGET
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
            <label for="contenido">Contenido del mensaje</label>
            <textarea class="form-control" name="contenido" id="contenido" rows="3" placeholder="Contenido del mensaje"></textarea>
        </div>
        HTML;

        return $html;
    }

    public function processSubmit(array $data = array()): void
    {
        $contenido = $data['contenido'] ?? null;

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
                Sesion::getUsuarioEnSesion()->getId(),
                null,
                null,
                null,
                $now,
                $contenido
            );

            if ($mensaje->dbInsertar()) {
                $responseData = array(
                    'status' => 'ok',
                    'messages' => array('Mensaje de Secretaría enviado correctamente.'),
                    self::TARGET_CLASS_NAME => $mensaje
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