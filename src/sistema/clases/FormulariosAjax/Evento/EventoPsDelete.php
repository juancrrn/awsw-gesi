<?php

namespace Awsw\Gesi\FormulariosAjax\Evento;

use Awsw\Gesi\App;
use Awsw\Gesi\Sesion;
use Awsw\Gesi\Datos\Grupo;
use Awsw\Gesi\Datos\Usuario;
use Awsw\Gesi\Validacion\Valido;
use Awsw\Gesi\FormulariosAjax\FormularioAjax;
use Awsw\Gesi\Datos\Evento;

use Awsw\Gesi\Datos\Asignatura;
use Awsw\Gesi\Datos\Asignacion;

/**
 * Formulario AJAX de creación de un usuario estudiante por parte de un 
 * administrador (personal de Secretaría).
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

class EventoPsDelete extends FormularioAjax
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
    private const FORM_ID = 'evento-ps-delete';
    private const FORM_NAME = 'Eliminar Evento';
    private const TARGET_CLASS_NAME = 'Evento';
    private const SUBMIT_URL = '/ps/eventos/delete/';
    private const EXPECTED_SUBMIT_METHOD = FormularioAjax::HTTP_DELETE;
    private const ON_SUCCESS_EVENT_NAME = 'deleted.evento.ps';
    private const ON_SUCCESS_EVENT_TARGET = '#evento-ps-lista';

    /**
     * Constructs the form object
     */
    public function __construct($api = false)
    {   
        Sesion::requerirSesionPs($api);

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
        // Check that uniqueId was provided
        if (! isset($requestData['uniqueId'])) {
            $responseData = array(
                'status' => 'error',
                'error' => 400, // Bad request
                'messages' => array(
                    'Falta el parámetro "uniqueId".'
                )
            );
            return $responseData;
        }

        $uniqueId = $requestData['uniqueId'];

        // Check that uniqueId is valid
        if (! Evento::dbExisteId($uniqueId)) {
            $responseData = array(
                'status' => 'error',
                'error' => 404, // Not found
                'messages' => array(
                    'El Evento solicitado no existe.'
                )
            );

            return $responseData;
        }

        $evento = Evento::dbGet($uniqueId);

        // Map data to match placeholder inputs' names
        $responseData = array(
            'status' => 'ok',
            // Link are not necessary in this case
            self::TARGET_CLASS_NAME => $evento
        );

        return $responseData;
    }

    public function generateFormInputs(): string
    {
        $html = <<< HTML
        <input type="hidden" name="uniqueId">
        <div class="form-group">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="checkbox" id="evento-delete-checkbox" required="required">
                <label class="custom-control-label" for="evento-delete-checkbox">Confirmar la eliminación.</label>
            </div>
        </div>
        HTML;

        return $html;
    }

    public function processSubmit(array $data = array()): void
    {
        $uniqueId = $data['uniqueId'] ?? null;
        $checkbox = $data['checkbox'] ?? null;

            // Check all required fields were sent
        if (empty($uniqueId) || empty($checkbox)) {
            if (empty($uniqueId)) {
                $errors[] = 'Falta el parámetro "uniqueId".';
            }

            if (empty($checkbox)) {
                $errors[] = 'El campo "checkbox" es obligatorio.';
            }

            $this->respondJsonError(400, $errors); // Bad request
        }

        // Check if confirmation checkbox is valid
        if ($uniqueId !== $checkbox) {
            $this->respondJsonError(400, array('El campo "checkbox" no es válido.')); // Bad request.
        }
        
        // Check Record's uniqueId is valid
        if (! Evento::dbExisteId($uniqueId)) {
            $errors[] = 'El Evento solicitado no existe.';

            $this->respondJsonError(404, $errors); // Not found.
        }

        
        if ( Evento::dbEliminar($uniqueId)) {
            $responseData = array(
                'status' => 'ok',
                'messages' => array(
                    'Evento eliminado correctamente.'
                )
            );

            $this->respondJsonOk($responseData);
        } else {
            $errors[] = 'Hubo un problema al eliminar el evento.';

            $this->respondJsonError(400, $errors); // Bad request.
        }
    }
}

?>