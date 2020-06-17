<?php

namespace Awsw\Gesi\FormulariosAjax\Evento;

use Awsw\Gesi\Datos\Grupo;
use Awsw\Gesi\FormulariosAjax\FormularioAjax;
use Awsw\Gesi\Datos\Usuario;
use Awsw\Gesi\Datos\Asignacion;
use Awsw\Gesi\Datos\Evento;

use Awsw\Gesi\Sesion;
use Awsw\Gesi\App;

/**
 * Formulario AJAX de visualización de un evento docente por parte 
 * de un administrador (personal de Secretaría).
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

class EventoPdRead extends FormularioAjax
{

    /**
     * Initialize specific form constants.
     *
     * @var string FORM_ID
     * @var string FORM_NAME
     * @var string TARGET_CLASS_NAME
     * @var string SUBMIT_URL
     */
    private const FORM_ID = 'evento-pd-read';
    private const FORM_NAME = 'Ver Evento';
    private const TARGET_CLASS_NAME = 'Evento';
    private const SUBMIT_URL = '/pd/eventos/read/';

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
        if (! Evento::dbExisteId($uniqueId)) {
            $responseData = array(
                'status' => 'error',
                'error' => 404, // Not found.
                'messages' => array(
                    'El evento solicitado no existe.'
                )
            );

            return $responseData;
        }
        $IdProfesor = Sesion::getUsuarioEnSesion()->getId();

        $asignaciones = Asignacion::dbGetByProfesor($IdProfesor);

        // Formalizacion HATEOAS de asignaciones.
        $asignacionLink = FormularioAjax::generateHateoasSelectLink(
            'asignacion',
            'single', 
            $asignaciones
        );


        $responseData = array(
            'status' => 'ok',
            'links' => array(
                $asignacionLink,
                //$asignaturasLink,
            )
        );

        return $responseData;
    }

    public function generateFormInputs(): string
    {
        $html = <<< HTML
        <div class="form-group">
            <label for="fecha">Fecha</label>
            <input class="form-control" type="text" name="fecha" disabled="disabled" />
        </div>
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input class="form-control" type="text" name="nombre" disabled="disabled" />
        </div>
        <div class="form-group">
            <label for="descripcion">Descripcion</label>
            <input class="form-control" type="text" name="descripcion" disabled="disabled"/>
        </div>
        <div class="form-group">
            <label for="lugar">Lugar</label>
            <input class="form-control" type="text" name="lugar" disabled="disabled" />
        </div>
        <div class="form-group">
            <label for="asignacion">Asignacion</label>
            <input class="form-control" type="text" name="asignacion" id="asignacion" disabled="disabled" />
        </div>
        
        
        
        HTML;

        return $html;
    }

    public function processSubmit(array $data = array()): void
    {
    }
}

?>