<?php

namespace Awsw\Gesi\FormulariosAjax\Asignacion;

use Awsw\Gesi\App;
use Awsw\Gesi\Datos\Asignacion;
use Awsw\Gesi\Datos\Asignatura;
use Awsw\Gesi\Datos\Foro;
use Awsw\Gesi\Datos\Grupo;
use Awsw\Gesi\Datos\Usuario;
use Awsw\Gesi\Formularios\Valido;
use Awsw\Gesi\FormulariosAjax\FormularioAjax;
use Awsw\Gesi\Validacion\GesiScheduleSlot;

/**
 * Formulario AJAX de creación de una asignación profesor-asignatura-grupo por 
 * parte de un administrador (personal de Secretaría).
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

class AsignacionPsCreate extends FormularioAjax
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
    private const FORM_ID = 'asignacion-ps-create';
    private const FORM_NAME = 'Crear asignación profesor-grupo-asignatura';
    private const TARGET_OBJECT_NAME = 'Usuario';
    private const SUBMIT_URL = '/ps/asignacion/create/';
    private const EXPECTED_SUBMIT_METHOD = FormularioAjax::HTTP_POST;
    private const ON_SUCCESS_EVENT_NAME = 'created.asignacion';
    private const ON_SUCCESS_EVENT_TARGET = '#asignacion-ps-list';

    /**
     * Constructs the form object
     */
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
        // Formalización HATEOAS de profesor.
        $profesorLink = FormularioAjax::generateHateoasSelectLink(
            'profesor',
            'single',
            Usuario::dbGetAll()
        );
        
        // Formalización HATEOAS de asignatura.
        $asignaturaLink = FormularioAjax::generateHateoasSelectLink(
            'asignatura',
            'single',
            Asignatura::dbGetAll()
        );
        
        // Formalización HATEOAS de grupo.
        $grupoLink = FormularioAjax::generateHateoasSelectLink(
            'grupo',
            'single',
            Grupo::dbGetAll()
        );
        
        // Formalización HATEOAS de foro.
        $foroLink = FormularioAjax::generateHateoasSelectLink(
            'foroPrincipal',
            'single',
            Foro::dbGetAll()
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
        );
        
        return $responseData;
    }

    public function generateFormInputs() : string
    {
        $html = <<< HTML
        <div class="form-group">
            <label for="profesor">Profesor</label>
            <select class="form-control" id="profesor" name="profesor" required="required">
            </select>
        </div>
        <div class="form-group">
            <label for="asignatura">Asignatura</label>
            <select class="form-control" id="asignatura" name="asignatura" required="required">
            </select>
        </div>
        <div class="form-group">
            <label for="grupo">Grupo</label>
            <select class="form-control" id="grupo" name="grupo" required="required">
            </select>
        </div>
        <div class="form-group">
            <label for="horario">Horario</label>
            <input class="form-control" type="text" id="horario" name="horario" required="required">
            <small class="form-text text-muted">En formato <code>L 9:00 10:40; X 10:40 12:20;</code>.</small>
        </div>
        <div class="form-group">
            <label for="foroPrincipal">Foro principal</label>
            <select class="form-control" id="foroPrincipal" name="foroPrincipal" required="required">
            </select>
        </div>
        HTML;

        return $html;
    }

    public function processSubmit(array $data = array()) : void
    {
        $profesor = $data['profesor'] ?? null;
        $asignatura = $data['asignatura'] ?? null;
        $grupo = $data['grupo'] ?? null;
        $horario = $data['horario'] ?? null;
        $foroPrincipal = $data['foroPrincipal'] ?? null;

        if (! empty($asignatura) && ! empty($grupo) && Asignacion::dbExisteByAsignaturaGrupo($asignatura, $grupo)) {
            $errors[] = 'Ya existe una asignación para la asignatura y el grupo indicados.';

            $this->respondJsonError(409, $errors); // Conflict.
        }

        if (empty($profesor)) {
            $errors[] = 'El campo profesor no puede estar vacío.';
        } elseif (! Usuario::dbExisteId($profesor)) {
            $errors[] = 'El campo profesor no es válido. Comprueba que el profesor existe.';
        }

        if (empty($asignatura)) {
            $errors[] = 'El campo asignatura no puede estar vacío.';
        } elseif (! Asignatura::dbExisteId($asignatura)) {
            $errors[] = 'El campo asignatura no es válido. Comprueba que la asignatura existe.';
        }

        if (empty($grupo)) {
            $errors[] = 'El campo grupo no puede estar vacío.';
        } elseif (! Grupo::dbExisteId($grupo)) {
            $errors[] = 'El campo grupo no es válido. Comprueba que el grupo existe.';
        }

        if (empty($horario)) {
            $errors[] = 'El campo horario no puede estar vacío.';
        } elseif (! GesiScheduleSlot::validaGesiSchedule($horario)) {
            $errors[] = 'El campo horario no es válido. Comprueba que el formato.';
        }

        if (empty($foroPrincipal)) {
            $errors[] = 'El campo foro principal no puede estar vacío.';
        } elseif (! Foro::dbExisteId($foroPrincipal)) {
            $errors[] = 'El campo foro principal no es válido. Comprueba que el foro existe.';
        }

        // Comprobar si hay errores.
        if (! empty($errors)) {
            $this->respondJsonError(400, $errors); // Bad request.
        } else {
            $asignacion = new Asignacion(
                null,
                $asignatura,
                $grupo,
                $profesor,
                $horario,
                $foroPrincipal
            );

            $asignacion_id = $asignacion->dbInsertar();

            if ($asignacion_id) {
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

                $responseData = array(
                    'status' => 'ok',
                    'links' => array(
                        $profesorLink,
                        $asignaturaLink,
                        $grupoLink,
                        $foroLink
                    ),
                    'messages' => array('Asignación creada correctamente.'),
                    self::TARGET_OBJECT_NAME => $asignacion
                );
                
                $this->respondJsonOk($responseData);
            } else {
                $errors[] = 'Hubo un error al crear la asignación.';

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