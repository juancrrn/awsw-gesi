<?php

namespace Awsw\Gesi\FormulariosAjax\Asignatura;

use Awsw\Gesi\App;
use Awsw\Gesi\Datos\Asignatura;
use Awsw\Gesi\FormulariosAjax\FormularioAjax;
use Awsw\Gesi\Formularios\Valido;
use Awsw\Gesi\Sesion;

/**
 * Formulario AJAX de actualizacion de una asignatura por parte de 
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

class AsignaturaPsUpdate extends FormularioAjax
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
    private const FORM_ID = 'asignatura-ps-update';
    private const FORM_NAME = 'Editar asignatura';
    private const TARGET_OBJECT_NAME = 'Asignatura';
    private const SUBMIT_URL = '/ps/asignaturas/update/';
    private const EXPECTED_SUBMIT_METHOD = FormularioAjax::HTTP_PATCH;
    private const ON_SUCCESS_EVENT_NAME = 'updated.asignatura';
    private const ON_SUCCESS_EVENT_TARGET = '#asignatura-ps-list';

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
        
        // Formalización HATEOAS de niveles.
        $nivelLink = FormularioAjax::generateHateoasSelectLink(
            'nivel',
            'single',
            Valido::getNivelesHateoas()
        );

        $asignatura = Asignatura::dbGet($uniqueId);

        $responseData = array(
            'status' => 'ok',
            'links' => array(
                $nivelLink
            ),
            self::TARGET_OBJECT_NAME => $asignatura
        );

        return $responseData;
    }

    public function generateFormInputs() : string
    {
        $html = <<< HTML
        <input type="hidden" name="uniqueId">
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
            <input class="form-control" type="text" name="nombre_corto" id="nombre_corto" placeholder="Nombre corto" required="required">
        </div>
        <div class="form-group">
            <label for="nombre_completo">Nombre completo</label>
            <input class="form-control" type="text" name="nombre_completo" id="nombre_completo" placeholder="Nombre completo" required="required">
        </div>
        HTML;


        return $html;
    }

    public function processSubmit(array $data = array()) : void
    {
        $uniqueId = $data['uniqueId'] ?? null;

        // Mapear los datos para que coincidan con los nombres de los inputs.
        if (! $uniqueId) {
            $errors[] = 'Falta el parámetro "uniqueId".';

            $this->respondJsonError(400, $errors); // Bad request.
        } elseif (! Asignatura::dbExisteId($uniqueId)) {
            $errors[] = 'La asignatura solicitada no existe.';

            $this->respondJsonError(404, $errors); // Not found.
        }

        $curso_escolar = $data['curso_escolar'] ?? null;
        $nombre_corto = $data['nombre_corto'] ?? null;
        $nombre_completo = $data['nombre_completo'] ?? null;
        $nivel = $data['nivel'] ?? null;

        if (empty($nivel)) {
            $errors[] = 'El campo nivel no puede estar vacío.';
        } elseif (! Valido::testNivelRaw($nivel)) {
            $errors[] = 'El campo nivel no es válido.';
        }

        if (empty($curso_escolar)) {
            $errors[] = 'El campo curso escolar no puede estar vacío.';
        } elseif(!Valido::testStdInt($curso_escolar)) {
            $errors[] = 'El campo curso escolar no es válido.';
        }

        if (empty($nombre_corto)) {
            $errors[] = 'El campo nombre corto es obligatorio.';
        } elseif (!Valido::testCadenaB($nombre_corto)) {
            $errors[] = 'El campo nombre corto no es válido.';
        }

        if (empty($nombre_completo)) {
            $errors[] = 'El campo nombre completo es obligatorio.';
        } elseif (!Valido::testCadenaB($nombre_completo)) {
            $errors[] = 'El campo nombre completo no es válido.';
        }
        
        // Comprobar si hay errores.
        if (! empty($errors)) {
            $this->respondJsonError(400, $errors); // Bad request.
        } else {
            $asignatura = new Asignatura(
                $uniqueId,
                $nivel,
                $curso_escolar,
                $nombre_corto,
                $nombre_completo
            );
  
            $actualizar = $asignatura->dbActualizar();

            if ($actualizar) {
                $responseData = array(
                    'status' => 'ok',
                    'messages' => array('Asignatura actualizada correctamente.'),
                    self::TARGET_OBJECT_NAME => $asignatura
                );
                
                $this->respondJsonOk($responseData);
            } else {
                $errors[] = 'Error al actualizar la asignatura.';

                $this->respondJsonError(400, $errors); // Bad request.
            }
        }
    }
}

?>