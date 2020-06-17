<?php

namespace Awsw\Gesi\FormulariosAjax\Asignacion;

use Awsw\Gesi\App;
use Awsw\Gesi\Datos\Asignacion;
use Awsw\Gesi\Datos\Asignatura;
use Awsw\Gesi\Datos\Foro;
use Awsw\Gesi\Datos\Grupo;
use Awsw\Gesi\FormulariosAjax\FormularioAjax;
use Awsw\Gesi\Datos\Usuario;
use Awsw\Gesi\Sesion;

/**
 * Formulario AJAX para eliminar un usuario de personal docente por parte de 
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

 class AsignacionPsDelete extends FormularioAjax
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
    private const FORM_ID = 'asignacion-ps-delete';
    private const FORM_NAME = 'Eliminar asignación profesor-grupo-asignatura';
    private const TARGET_CLASS_NAME = 'Asignacion';
    private const SUBMIT_URL = '/ps/asignacion/delete/';
    private const EXPECTED_SUBMIT_METHOD = FormularioAjax::HTTP_DELETE;
    private const ON_SUCCESS_EVENT_NAME = 'deleted.asignacion';
    private const ON_SUCCESS_EVENT_TARGET = '#asignacion-ps-list';

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

        // Comprobar que el uniqueId es válido.
        if (! Asignacion::dbExisteId($uniqueId)) {
            $responseData = array(
                'status' => 'error',
                'error' => 404, // Not found.
                'messages' => array(
                    'El usuario estudiante solicitado no existe.'
                )
            );

            return $responseData;
        }

        $asignacion = Asignacion::dbGet($uniqueId);
        
        // Formalización HATEOAS de profesor.
        $profesorLink = FormularioAjax::generateHateoasSelectLink(
            'profesor',
            'single',
            Usuario::dbGet($asignacion->getProfesor())
        );
        
        // Formalización HATEOAS de asignatura.
        $asignaturaLink = FormularioAjax::generateHateoasSelectLink(
            'asignatura',
            'single',
            Asignatura::dbGet($asignacion->getAsignatura())
        );
        
        // Formalización HATEOAS de grupo.
        $grupoLink = FormularioAjax::generateHateoasSelectLink(
            'grupo',
            'single',
            Grupo::dbGet($asignacion->getGrupo())
        );
        
        // Formalización HATEOAS de foro.
        $foroLink = FormularioAjax::generateHateoasSelectLink(
            'foroPrincipal',
            'single',
            Foro::dbGet($asignacion->getForoPrincipal())
        );

        // Map data to match placeholder inputs' names
        $responseData = array(
            'status' => 'ok',
            'links' => array(
                $profesorLink,
                $asignaturaLink,
                $grupoLink,
                $foroLink
            ),
            self::TARGET_CLASS_NAME => $asignacion
        );

        return $responseData;
    }
    
    public function generateFormInputs(): string
    {
        $html = <<< HTML
        <input type="hidden" name="uniqueId">
        <div class="form-group">
            <label>Profesor</label>
            <select class="form-control" name="profesor" disabled="disabled">
            </select>
        </div>
        <div class="form-group">
            <label>Asignatura</label>
            <select class="form-control" name="asignatura" disabled="disabled">
            </select>
        </div>
        <div class="form-group">
            <label>Grupo</label>
            <select class="form-control" name="grupo" disabled="disabled">
            </select>
        </div>
        <div class="form-group">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="checkbox" id="asignacion-delete-checkbox" required="required">
                <label class="custom-control-label" for="asignacion-delete-checkbox">Confirmar la eliminación.</label>
            </div>
        </div>
        <div class="form-group">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="checkbox" id="asignacion-delete-foro-principal" disabled="disabled">
                <label class="custom-control-label" for="asignacion-delete-foro-principal">Eliminar también el foro principal de la asignación y todos sus mensajes.</label>
                <small class="form-text text-danger">TODO: Esta funcionalidad no está implementada aún.</small>
                <small class="form-text text-warning">Al eliminar una asignación sin elimnar el foro, este quedará huérfano y podrá ser asignado como foro principal a otra asignación.</small>
            </div>
        </div>
        <div class="mt-4">
            
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
        if (! Asignacion::dbExisteId($uniqueId)) {
            $errors[] = 'La asignación solicitada no existe.';

            $this->respondJsonError(404, $errors); // Not found.
        }

        // TODO comprobar si hay que eliminar el foro y hacerlo.

        if (Asignacion::dbEliminar($uniqueId)) {
            $responseData = array(
                'status' => 'ok',
                'messages' => array(
                    'Asignación eliminada correctamente.'
                )
            );

            $this->respondJsonOk($responseData);
        } else {
            $errors[] = 'Hubo un problema al eliminar la asignación.';

            $this->respondJsonError(400, $errors); // Bad request.
        }

    }
}

?>