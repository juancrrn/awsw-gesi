<?php

namespace Awsw\Gesi\FormulariosAjax\Asignatura;

use Awsw\Gesi\App;
use Awsw\Gesi\Datos\Asignacion;
use Awsw\Gesi\FormulariosAjax\FormularioAjax;
use Awsw\Gesi\Datos\Asignatura;

/**
 * Formulario AJAX para eliminar una asignatura por parte de 
 * un administrador (personal de Secretaría).
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

 class AsignaturaPsDelete extends FormularioAjax
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
    private const FORM_ID = 'asignatura-ps-delete';
    private const FORM_NAME = 'Eliminar asignatura';
    private const TARGET_OBJECT_NAME = 'Asignatura';
    private const SUBMIT_URL = '/ps/asignaturas/delete/';
    private const EXPECTED_SUBMIT_METHOD = FormularioAjax::HTTP_DELETE;
    private const ON_SUCCESS_EVENT_NAME = 'deleted.asignatura';
    private const ON_SUCCESS_EVENT_TARGET = '#asignatura-ps-list';

    public function __construct()
    {
        $app = App::getSingleton();

        parent::__construct(
            self::FORM_ID,
            self::FORM_NAME,
            self::TARGET_OBJECT_NAME,
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
        if (! Asignatura::dbExisteId($uniqueId)) {
            $responseData = array(
                'status' => 'error',
                'error' => 404, // Not found
                'messages' => array(
                    'La asignatura solicitada no existe.'
                )
            );

            return $responseData;
        }

        $record = Asignatura::dbGet($uniqueId);

        // Map data to match placeholder inputs' names
        $responseData = array(
            'status' => 'ok',
            // Link are not necessary in this case
            self::TARGET_OBJECT_NAME => $record
        );

        return $responseData;
    }
    
    public function generateFormInputs() : string
    {
        $html = <<< HTML
        <input type="hidden" name="uniqueId">
        <div class="form-group">
            <label>Nombre</label>
            <input name="nombre_completo" type="text" class="form-control"  disabled="disabled">
        </div>
        <div class="form-group">
            <label>Curso</label>
            <input name="curso_escolar" type="text" class="form-control"  disabled="disabled">
        </div>
        <div class="form-group">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="checkbox" id="asignatura-delete-checkbox" required="required">
                <label class="custom-control-label" for="asignatura-delete-checkbox">Confirmar la eliminación.</label>
            </div>
        </div>
        HTML;

        return $html;
    }
    
    public function processSubmit(array $data = array()) : void
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
        if (! Asignatura::dbExisteId($uniqueId)) {
            $errors[] = 'La asignatura solicitada no existe.';

            $this->respondJsonError(404, $errors); // Not found.
        }

        //Comprobamos si la asignatura esta asignada
        if(!Asignacion::dbAnyByAsignatura($uniqueId)){
            if (Asignatura::dbEliminar($uniqueId)) {
                $responseData = array(
                    'status' => 'ok',
                    'messages' => array(
                        'Asignatura eliminada correctamente.'
                    )
                );
    
                $this->respondJsonOk($responseData);
            } else {
                $errors[] = 'Hubo un problema al eliminar la asignatura.';
    
                $this->respondJsonError(400, $errors); // Bad request.
            }
        }else{
            $errors[] = 'Hubo un problema al eliminar la asignatura.';
    
            $this->respondJsonError(400, $errors); // Bad request.
        }
    }
}

?>