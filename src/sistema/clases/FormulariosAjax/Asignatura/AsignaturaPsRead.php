<?php

namespace Awsw\Gesi\FormulariosAjax\Asignatura;

use Awsw\Gesi\App;
use Awsw\Gesi\Datos\Grupo;
use Awsw\Gesi\Datos\Asignatura;
use Awsw\Gesi\FormulariosAjax\FormularioAjax;
use Awsw\Gesi\Formularios\Valido;
use Awsw\Gesi\Sesion;

/**
 * Formulario AJAX de visualización de una asignatura por parte 
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

class AsignaturaPsRead extends FormularioAjax
{

    /**
     * Initialize specific form constants.
     *
     * @var string FORM_ID
     * @var string FORM_NAME
     * @var string TARGET_CLASS_NAME
     * @var string SUBMIT_URL
     */
    private const FORM_ID = 'asignatura-ps-read';
    private const FORM_NAME = 'Ver Asignatura';
    private const TARGET_CLASS_NAME = 'Asignatura';
    private const SUBMIT_URL = '/ps/asignaturas/read/';

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
        if (! Asignatura::dbExisteId($uniqueId)) {
            $responseData = array(
                'status' => 'error',
                'error' => 404, // Not found.
                'messages' => array(
                    'La asignatura solicitada no existe.'
                )
            );

            return $responseData;
        }
        
        // Formalización HATEOAS de grupos.
        $asignaturaLink = FormularioAjax::generateHateoasSelectLink(
            'nivel',
            'single',
            Valido::getNivelesHateoas()
        );

        $asignatura = Asignatura::dbGet($uniqueId);

        // Map data to match placeholder inputs' names
        $responseData = array(
            'status' => 'ok',
            'links' => array(
                $asignaturaLink
            ),
            self::TARGET_CLASS_NAME => $asignatura
        );

        return $responseData;
    }

    public function generateFormInputs(): string
    {
        $html = <<< HTML
        <div class="form-group">
            <label for="nivel">Nivel</label>
            <select class="form-control" name="nivel" id="nivel" disabled="disabled">
            </select>
        </div>
        <div class="form-group">
            <label for="curso_escolar">Curso escolar</label>
            <input class="form-control" type="number" name="curso_escolar" id="curso_escolar" placeholder="Curso escolar" disabled="disabled">
        </div>
        <div class="form-group">
            <label for="nombre_corto">Nombre corto</label>
            <input class="form-control" type="text" name="nombre_corto" id="nombre_corto" placeholder="Nombre corto" disabled="disabled">
        </div>
        <div class="form-group">
            <label for="nombre_completo">Nombre completo</label>
            <input class="form-control" type="text" name="nombre_completo" id="nombre_completo" placeholder="Nombre completo" disabled="disabled">
        </div>
        HTML;

        return $html;
    }

    public function processSubmit(array $data = array()): void
    {
    }
}

?>