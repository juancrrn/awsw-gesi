<?php

namespace Awsw\Gesi\FormulariosAjax\Asignatura;

use Awsw\Gesi\App;
use Awsw\Gesi\Datos\Asignatura;
use Awsw\Gesi\Formularios\Valido;
use Awsw\Gesi\FormulariosAjax\FormularioAjax;
use Awsw\Gesi\Sesion;

/**
 * Formulario AJAX de creación de una asignatura por parte de un administrador 
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

class AsignaturaPsCreate extends FormularioAjax
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
    private const FORM_ID = 'asignatura-ps-create';
    private const FORM_NAME = 'Crear asignatura';
    private const TARGET_OBJECT_NAME = 'Asignatura';
    private const SUBMIT_URL = '/ps/asignaturas/create/';
    private const EXPECTED_SUBMIT_METHOD = FormularioAjax::HTTP_POST;
    private const ON_SUCCESS_EVENT_NAME = 'created.asignatura';
    private const ON_SUCCESS_EVENT_TARGET = '#asignatura-lista'; // TODO

    /**
     * Constructs the form object
     */
    public function __construct()
    {
        Sesion::requerirSesionPs(true);

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
        // Formalización HATEOAS de niveles.
        $asignaturaLink = FormularioAjax::generateHateoasSelectLink(
            'nivel',
            'single',
             Valido::getNivelesHateoas()
        );

        // Mapear datos para que coincidan con los nombres de los inputs.
        $responseData = array(
            'status' => 'ok',
            'links' => array(
                $asignaturaLink
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
            <p class="form-help">Introduce el año de inicio del curso escolar. Por ejemplo, para el curso 2018 - 2019, introduce 2018.</p>
            <input class="form-control" type="number" name="curso_escolar" id="curso_escolar" placeholder="Curso escolar" required="required">
        </div>
        <div class="form-group">
            <label for="nombre_corto">Nombre corto</label>
            <input class="form-control" type="text" name="nombre_corto" id="nombre_corto" placeholder="Nombre corto" required="required" />
        </div>
        <div class="form-group">
            <label for="nombre_completo">Nombre completo</label>
            <input class="form-control" type="text" name="nombre_completo" id="nombre_completo" placeholder="Nombre completo" required="required" />
        </div>
        HTML;

        return $html;
    }

    public function processSubmit(array $data = array()) : void
    {
        //$nivel = isset($data['nivel']) ? $data['nivel'] : null;
        $curso_escolar = $data['curso_escolar'] ?? null;
        $nombre_corto = $data['nombre_corto'] ?? null;
        $nombre_completo = $data['nombre_completo'] ?? null;

        // Comprobar nivel.
        
        $nivel = $data['nivel'] ?? null;

        if (empty($nivel)) {
            $errors[] = 'El campo nivel no puede estar vacío.';
        }

        if(empty($curso_escolar)){
            $errors[] = 'El campo curso escolar no puede estar vacío.';
        }elseif(!Valido::testStdInt($curso_escolar)){
            $errors[] = 'El campo curso escolar no es válido.';
        }

        if (empty($nombre_corto)) {
            $errors[] = 'El campo nombre corto es obligatorio.';
        } elseif (!Valido::testCadenaB($nombre_corto)){
            $errors[] = 'El campo nombre corto no es válido.';
        }

        if (empty($nombre_completo)) {
            $errors[] = 'El campo nombre completo es obligatorio.';
        } elseif (!Valido::testCadenaB($nombre_completo)){
            $errors[] = 'El campo nombre completo no es válido.';
        }

        // Comprobar si hay errores.
        if (! empty($errors)) {
            $this->respondJsonError(400, $errors); // Bad request.
        } else {

            $asignatura = new Asignatura(
              null,
              $nivel,
              $curso_escolar,
              $nombre_corto,
              $nombre_completo
            );

            $asignatura_id = $asignatura->dbInsertar();

            if ($asignatura_id) {
                $responseData = array(
                    'status' => 'ok',
                    'messages' => array('La asignatura fue creada correctamente.'),
                    self::TARGET_OBJECT_NAME => $asignatura
                );
                
                $this->respondJsonOk($responseData);
            } else {
                $errors[] = 'Hubo un error al crear la asignatura.';

                $this->respondJsonError(400, $errors); // Bad request.
            }
        }
    }

    public static function autoHandle() : void
    {
        $form = new self();
        $form->manage();
    }
}

?>