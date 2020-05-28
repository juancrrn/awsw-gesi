<?php

namespace Awsw\Gesi\FormulariosAjax\Asignacion;

use Awsw\Gesi\Datos\Asignacion;
use Awsw\Gesi\Datos\Asignatura;
use Awsw\Gesi\Datos\Foro;
use Awsw\Gesi\Datos\Grupo;
use Awsw\Gesi\FormulariosAjax\FormularioAjax;
use Awsw\Gesi\Datos\Usuario;

/**
 * Formulario AJAX de visualización de una asignación profesor-asignatura-grupo
 * por parte de un administrador (personal de Secretaría).
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

class AsignacionPsRead extends FormularioAjax
{

    /**
     * Initialize specific form constants.
     *
     * @var string FORM_ID
     * @var string FORM_NAME
     * @var string TARGET_CLASS_NAME
     * @var string SUBMIT_URL
     */
    private const FORM_ID = 'asignacion-ps-read';
    private const FORM_NAME = 'Ver asignación';
    private const TARGET_CLASS_NAME = 'Asignacion';
    private const SUBMIT_URL = '/ps/asignacion/read/';

    /**
     * Constructs the form object
     */
    public function __construct()
    {
        parent::__construct(
            self::FORM_ID,
            self::FORM_NAME,
            self::TARGET_CLASS_NAME,
            self::SUBMIT_URL,
            null
        );

        $this->setReadOnlyTrue();
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

    public function generateFormInputs() : string
    {
        $html = <<< HTML
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
            <label>Horario</label>
            <input class="form-control" type="text" name="horario" disabled="disabled">
        </div>
        <div class="form-group">
            <label>Foro principal</label>
            <select class="form-control" name="foroPrincipal" disabled="disabled">
            </select>
        </div>
        HTML;

        return $html;
    }

    public function processSubmit(array $data = array()) : void
    {
    }
}

?>