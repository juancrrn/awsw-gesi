<?php

namespace Awsw\Gesi\FormulariosAjax\Grupo;

use Awsw\Gesi\App;
use Awsw\Gesi\Datos\Grupo;
use Awsw\Gesi\Datos\Usuario;
use Awsw\Gesi\Validacion\Valido;
use Awsw\Gesi\FormulariosAjax\FormularioAjax;
use Awsw\Gesi\Sesion;

/**
 * Formulario AJAX de creación de un grupo por parte de un administrador 
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

class GrupoPsCreate extends FormularioAjax
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

    private const FORM_ID = 'grupo-ps-create';
    private const FORM_NAME = 'Crear grupo';
    private const TARGET_CLASS_NAME = 'Grupo';
    private const SUBMIT_URL = '/ps/grupo/create/';
    private const EXPECTED_SUBMIT_METHOD = FormularioAjax::HTTP_POST;
    private const ON_SUCCESS_EVENT_NAME = 'created.grupo.ps';
    private const ON_SUCCESS_EVENT_TARGET = '#grupo-ps-list';


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

    protected function getDefaultData(array $requestData) : array {

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


        //Mapear datos para que coincidan con los nombres de los inputs.$app

        $responseData = array(
            'status' => 'ok',
            'links' => array(
                $nivelesLink,
                $tutoresLink
            )
        );

            return $responseData;
    }


    public function generateFormInputs(): string 
    {
        $html = <<< HTML
        <div class="form-group">
            <label for="nivel">Nivel</label>
            <select class="form-control" name="nivel" id="nivel" required="required">
            </select>
        </div>
        <div class="form-group">
            <label for="curso_escolar">Curso escolar</label>
            <input class="form-control" type="number" name="curso_escolar" id="curso_escolar"  placeholder="Curso escolar" required="required" />
        </div>
        <div class="form-group">
            <label for="nombre_completo">Nombre completo</label>
            <input class="form-control" type="text" name="nombre_completo" id="nombre_completo"  placeholder="Nombre Completo" required="required" />
        </div>
        <div class="form-group">
            <label for="nombre_corto">Nombre corto</label>
            <input class="form-control" type="text" name="nombre_corto" id="nombre_corto"  placeholder="Nombre Corto" required="required" />
        </div>
        <div class="form-group">
        <label for="tutor">Tutor</label>
            <select class="form-control" name="tutor" id="tutor" required="required">
            </select>
        </div>
        HTML;


        return $html;
    }



    public function processSubmit(array $data = array()): void{
        
        $nivel = $data['nivel'] ?? null;
       
        $curso_escolar = $data['curso_escolar'] ?? null;
        $nombre_corto = $data['nombre_corto'] ?? null;
        $nombre_completo = $data['nombre_completo'] ?? null;
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

        //Comprobar si hay errores

        if( !empty($errors)){
            $this->respondJsonError(400,$errors);
        }else{
            $now = date('Y-m-d H:i:s');


            $grupo = new Grupo(
                null,
                $nivel,
                $curso_escolar,
                $nombre_corto,
                $nombre_completo,
                $tutor

            );

            $grupo_id = $grupo->dbInsertar();


            if($grupo_id){

                $responseData = array(
                    'status' => 'ok',
                    'messages' => array('El grupo fue creado correctamente'),
                    self::TARGET_CLASS_NAME => $grupo
                );

                $this->respondJsonOk($responseData);

            }else{

                $errors[] ='Hubo un error al crear el grupo';

                $this->respondJsonError(400,$errors);
            }
        }


    }


 }


?>