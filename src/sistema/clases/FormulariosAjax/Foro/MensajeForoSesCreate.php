<?php

namespace Awsw\Gesi\FormulariosAjax\Foro;

use Awsw\Gesi\App;
use Awsw\Gesi\Sesion;
use Awsw\Gesi\Datos\MensajeForo;
use Awsw\Gesi\Formularios\Valido;
use Awsw\Gesi\FormulariosAjax\FormularioAjax;

/**
 * Formulario AJAX de creación de un mensaje por parte de un usuario con 
 * sesión iniciada.
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

class MensajeForoSesCreate extends FormularioAjax
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
    private const FORM_ID = 'mensaje-foro-ses-create';
    private const FORM_NAME = 'Crear mensaje  de Foro';
    private const TARGET_CLASS_NAME = 'MensajeForo';
    private const SUBMIT_URL = '/ses/mensajesforo/est/create/';
    private const EXPECTED_SUBMIT_METHOD = FormularioAjax::HTTP_POST;
    private const ON_SUCCESS_EVENT_NAME = 'created.ses.mensajesforo';
    private const ON_SUCCESS_EVENT_TARGET = '#mensaje-foro-ses-list'; // TODO

    /**
     * Constructs the form object
     */
    public function __construct($api = false)
    {
        $app = App::getSingleton();

        Sesion::requerirSesionIniciada($api);

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
        // Mapear datos para que coincidan con los nombres de los inputs.
        $responseData = array(
            'status' => 'ok'
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

            $mensaje = new MensajeForo(
                null,
                
                $now,
                $contenido
            );

            $usuario_id = $usuario->dbInsertar();

            if ($usuario_id) {
                $responseData = array(
                    'status' => 'ok',
                    'messages' => array('El usuario estudiante fue creado correctamente.'),
                    self::TARGET_CLASS_NAME => $usuario
                );
                
                $this->respondJsonOk($responseData);
            } else {
                $errors[] = 'Hubo un error al crear el usuario estudiante.';

                $this->respondJsonError(400, $errors); // Bad request.
            }
        }
    }

    public static function autoHandle(): void
    {
        $form = new self();
        $form->manage();
    }
}

?>