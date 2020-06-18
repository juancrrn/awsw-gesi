<?php

namespace Awsw\Gesi\FormulariosAjax\Grupo;

use Awsw\Gesi\App;
use Awsw\Gesi\Datos\Grupo;
use Awsw\Gesi\FormulariosAjax\FormularioAjax;
use Awsw\Gesi\Datos\Usuario;
use Awsw\Gesi\Validacion\Valido;
use Awsw\Gesi\Sesion;

/**
 * Formulario AJAX de creación de un usuario de personal docente por parte de 
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

class GrupoPsUpdate extends FormularioAjax
{

    /**
     * Initialize specific form constants.
     *
     * @var string FORM_ID
     * @var string FORM_NAME
     * @var string DATA_OBJECT_NAME
     * @var string SUBMIT_URL
     * @var string EXPECTED_SUBMIT_METHOD
     * @var string ON_SUCCESS_EVENT_NAME
     * @var string ON_SUCCESS_EVENT_TARGET
     */
    private const FORM_ID = 'grupo-ps-update';
    private const FORM_NAME = 'Editar grupo';
    private const TARGET_CLASS_NAME = 'Grupo';
    private const SUBMIT_URL = '/ps/grupo/update/';
    private const EXPECTED_SUBMIT_METHOD = FormularioAjax::HTTP_PATCH;
    private const ON_SUCCESS_EVENT_NAME = 'updated.grupo.ps';
    private const ON_SUCCESS_EVENT_TARGET = '#grupo-ps-list';

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
        // Mapear los datos para que coincidan con los nombres de los inputs.
        if(! isset($requestData['uniqueId'])){
            $responseData = array(
                'status' => 'error',
                'error' => 400, // Bad request
                'messages' => array(
                    'Falta el parámetro "uniqueId".'
                )
            );
        }

        $uniqueId = $requestData['uniqueId'];

        // Comprobar que el uniqueId es válido.
        if (! Grupo::dbExisteId($uniqueId)) {
            $responseData = array(
                'status' => 'error',
                'error' => 404, // Not found.
                'messages' => array(
                    'El grupo solicitado no existe.'
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

        $grupo = Grupo::dbGet($uniqueId);

        //Mapear datos para que coincidan con los nombres de los inputs.$app

        $responseData = array(
            'status' => 'ok',
            'links' => array(
                $nivelesLink,
                $tutoresLink
            ),
            self::TARGET_CLASS_NAME => $grupo
        );

        return $responseData;
    }

    public function generateFormInputs(): string
    {
        $html = <<< HTML
        <input type="hidden" name="uniqueId">
        <div class="form-group">
            <label for="nivel">Nivel</label>
            <select class="form-control" name="nivel" id="nivel" required="required">
            </select>
        </div>
        <div class="form-group">
            <label for="cursoEscolar">Curso escolar</label>
            <input class="form-control" type="number" name="cursoEscolar" id="cursoEscolar"  placeholder="Curso escolar" required="required" />
        </div>
        <div class="form-group">
            <label for="nombreCompleto">Nombre completo</label>
            <input class="form-control" type="text" name="nombreCompleto" id="nombreCompleto"  placeholder="Nombre" required="required" />
        </div>
        <div class="form-group">
            <label for="nombreCorto">Nombre corto</label>
            <input class="form-control" type="text" name="nombreCorto" id="nombreCorto"  placeholder="Nombre" required="required" />
        </div>
        <div class="form-group">
        <label for="tutor">Tutor</label>
            <select class="form-control" name="tutor" id="tutor" required="required">
            </select>
        </div>
        HTML;


        return $html;
      
    }

    public function processSubmit(array $data = array()): void
    {
        $uniqueId = $data['uniqueId'] ?? null;
        
        // Check Record's uniqueId is valid
        if (! Grupo::dbExisteId($uniqueId)) {
            $errors[] = 'El grupo solicitado no existe.';

            $this->respondJsonError(404, $errors); // Not found.
        }
        $nivel = $data['nivel'] ?? null;
        $curso_escolar = $data['cursoEscolar'] ?? null;
        $nombre_corto = $data['nombreCorto'] ?? null;
        $nombre_completo = $data['nombreCompleto'] ?? null;
        $tutor = $data['tutor'] ?? null;

        if (empty($nivel))  {
            $errors[] = 'El campo nivel no puede estar vacío';
        }

        if (empty($curso_escolar)) {
            $errors[] ='El campo curso escolar no puede estar vacío.';
        } elseif (! Valido::testStdInt($curso_escolar)) {
            $errors[] ='El campo curso escolar no es válido.';
        }

        if (empty($nombre_corto)) {
            $errors[] ='El campo nombre corto es obligatorio.';
        } elseif(!Valido::testCadenaB($nombre_completo)){
            $errors[] ='El campo nombre completo no es válido.';
		}
			
		if (empty($nombre_completo)) {
			$errors[] ='El campo nombre completo es obligatorio.';
		} elseif (!Valido::testCadenaB($nombre_corto)){
            $errors[] ='El campo nombre corto no es válido.';
        }

        /*
         * Comprobar que el tutor no está vacío y existe.
         */

        if (empty($tutor) || ! Valido::testStdInt($tutor) || ! Usuario::dbExisteId($tutor)) {
            $errors[] ='El campo tutor no es válido.';
        }


        // Comprobar si hay errores.
        if (! empty($errors)) {
            $this->respondJsonError(400, $errors); // Bad request.
        } else {
            // Obtener datos que no se habían modificado.
        

           
            $grupo = new Grupo(
                $uniqueId,
                $nivel,
                $curso_escolar,
                $nombre_corto,
                $nombre_completo,
                $tutor

            );

            $actualizar = $grupo->dbActualizar();

            if ($actualizar) {
                $responseData = array(
                    'status' => 'ok',
                    'messages' => array('Grupo actualizado correctamente.'),
                    self::TARGET_CLASS_NAME => $grupo
                );
                
                $this->respondJsonOk($responseData);
            } else {
                $errors[] = 'Grupo usuario estudiante.';

                $this->respondJsonError(400, $errors); // Bad request.
            }

        }
    
    }
}

?>