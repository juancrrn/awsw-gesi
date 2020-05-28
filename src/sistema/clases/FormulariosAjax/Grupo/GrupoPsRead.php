<?php

namespace Awsw\Gesi\FormulariosAjax\Grupo;

use Awsw\Gesi\Datos\Grupo;
use Awsw\Gesi\FormulariosAjax\FormularioAjax;
use Awsw\Gesi\Datos\Usuario;
use Awsw\Gesi\Formularios\Valido;

/**
 * Formulario AJAX de visualización de un grupo por parte de un administrador 
 * (personal de Secretaría).
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

class GrupoPsRead extends FormularioAjax
{

    /**
     * Initialize specific form constants.
     *
     * @var string FORM_ID
     * @var string FORM_NAME
     * @var string TARGET_CLASS_NAME
     * @var string SUBMIT_URL
     */
    private const FORM_ID = 'grupo-read';
    private const FORM_NAME = 'Ver Grupo';
    private const TARGET_CLASS_NAME = 'Grupo';
    private const SUBMIT_URL = '/admin/grupo/read/';

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
        if (! Usuario::dbExisteId($uniqueId)) {
            $responseData = array(
                'status' => 'error',
                'error' => 404, // Not found.
                'messages' => array(
                    'El Grupo solicitado no existe.'
                )
            );

            return $responseData;
        }
        
       // Formalizacion HATEOAS de niveles.
       $nivelesLink = FormularioAjax::generateHateoasSelectLink(
        'nivel',
        'single',
        Valido::getNivelesHateoas()
    );

    // Formalización HATEOAS de tutores.
    $tutoresLink = FormularioAjax::generateHateoasSelectLink(
        'tutor',
        'single',
        Usuario::dbGetByRol(2)
    );

       

        // Map data to match placeholder inputs' names
        $responseData = array(
            'status' => 'ok',
            'links' => array(
                $nivelesLink,
                $tutoresLink
            )
        );

        return $responseData;
    }

    public function generateFormInputs() : string
    {
        $html = <<< HTML
        <div class="form-group">
            <label for="nivel">Nivel</label>
            <select class="form-control" name="nivel" id="nivel" required="required">
            </select>
        </div>
        <div class="form-group">
        <label for="curso_escolar">Curso escolar</label>
            <input class="form-control" type="number" name="curso_escolar" id="curso_escolar"  placeholder="Curso escolar" required="required">
        </div>
        <div class="form-group">
        <label for="nombre_completo">Nombre completo</label>
            <input class="form-control" type="text" name="nombre_completo" id="nombre_completo"  placeholder="Nombre" required="required" />
        </div>
        <div class="form-group">
            <label for="fecha_nacimiento">Fecha de nacimiento</label>
            <input class="form-control" type="text" name="fecha_nacimiento" id="fecha_nacimiento" placeholder="Fecha de nacimiento" required="required" />
        </div>
        <div class="form-group">
        <label for="tutor">Tutor</label>
            <select class="form-control" name="tutor" id="tutor" required="required">
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