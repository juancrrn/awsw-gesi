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
use Awsw\Gesi\Validacion\GesiScheduleSlot;

/**
 * Formulario AJAX de actualización una asignación profesor-asignatura-grupo 
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

class AsignacionPsUpdate extends FormularioAjax
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
    private const FORM_ID = 'asignacion-ps-update';
    private const FORM_NAME = 'Editar asignación profesor-grupo-asignatura';
    private const TARGET_CLASS_NAME = 'Asignacion';
    private const SUBMIT_URL = '/ps/asignacion/update/';
    private const EXPECTED_SUBMIT_METHOD = FormularioAjax::HTTP_PATCH;
    private const ON_SUCCESS_EVENT_NAME = 'updated.asignacion';
    private const ON_SUCCESS_EVENT_TARGET = '#asignacion-ps-list';

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
        if (! Asignacion::dbExisteId($uniqueId)) {
            $responseData = array(
                'status' => 'error',
                'error' => 404, // Not found.
                'messages' => array(
                    'La asignación solicitada no existe.'
                )
            );

            return $responseData;
        }

        $asignacion = Asignacion::dbGet($uniqueId);

        // Formalización HATEOAS de profesor.
        $profesorLink = FormularioAjax::generateHateoasSelectLink(
            'profesor',
            'single',
            Usuario::dbGetByRol(2)
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
            self::TARGET_CLASS_NAME => $asignacion
        );

        return $responseData;
    }

    public function generateFormInputs(): string
    {
        $html = <<< HTML
        <input type="hidden" name="uniqueId">
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

    public function processSubmit(array $data = array()): void
    {
        $uniqueId = $data['uniqueId'] ?? null;

        // Mapear los datos para que coincidan con los nombres de los inputs.
        if (! $uniqueId) {
            $errors[] = 'Falta el parámetro "uniqueId".';

            $this->respondJsonError(400, $errors); // Bad request.
        } elseif (! Asignacion::dbExisteId($uniqueId)) {
            $errors[] = 'La asignación solicitada no existe.';

            $this->respondJsonError(404, $errors); // Not found.
        }
        
        $profesorId = $data['profesor'] ?? null;
        $asignaturaId = $data['asignatura'] ?? null;
        $grupoId = $data['grupo'] ?? null;
        $horario = $data['horario'] ?? null;
        $foroPrincipalId = $data['foroPrincipal'] ?? null;

        $datosAnteriores = Asignacion::dbGet($uniqueId);

        // Comprobar si se han modificado la asignatura o el grupo.
        if (! empty($asignaturaId) && ! empty($grupoId) &&
            ($asignaturaId != $datosAnteriores->getAsignatura() ||
            $grupoId != $datosAnteriores->getGrupo()) &&
            Asignacion::dbExisteByAsignaturaGrupo($asignaturaId, $grupoId)) {
            $errors[] = 'Ya existe una asignación para la asignatura y el grupo indicados.';

            $this->respondJsonError(409, $errors); // Conflict.
        }

        if (empty($profesorId)) {
            $errors[] = 'El campo profesor no puede estar vacío.';
        } elseif (! Usuario::dbExisteId($profesorId)) {
            $errors[] = 'El campo profesor no es válido. Comprueba que el profesor existe.';
        } else {
            $profesor = Usuario::dbGet($profesorId);

            if (! $profesor->isPd()) {
                $errors[] = 'El campo profesor no es válido. Comprueba que el usuario seleccionado tiene el rol de personal docente.';
            }
        }

        if (empty($asignaturaId)) {
            $errors[] = 'El campo asignatura no puede estar vacío.';
        } elseif (! Asignatura::dbExisteId($asignaturaId)) {
            $errors[] = 'El campo asignatura no es válido. Comprueba que la asignatura existe.';
        }

        if (empty($grupoId)) {
            $errors[] = 'El campo grupo no puede estar vacío.';
        } elseif (! Grupo::dbExisteId($grupoId)) {
            $errors[] = 'El campo grupo no es válido. Comprueba que el grupo existe.';
        }

        if (empty($horario)) {
            $errors[] = 'El campo horario no puede estar vacío.';
        } elseif (! GesiScheduleSlot::validaGesiSchedule($horario)) {
            $errors[] = 'El campo horario no es válido. Comprueba que el formato es correcto.';
        }

        if (empty($foroPrincipalId)) {
            $errors[] = 'El campo foro principal no puede estar vacío.';
        } elseif (! Foro::dbExisteId($foroPrincipalId)) {
            $errors[] = 'El campo foro principal no es válido. Comprueba que el foro existe.';
        }

        // Comprobar si hay errores.
        if (! empty($errors)) {
            $this->respondJsonError(400, $errors); // Bad request.
        } else {
            $asignacion = new Asignacion(
                $uniqueId,
                $asignaturaId,
                $grupoId,
                $profesorId,
                $horario,
                $foroPrincipalId
            );

            if ($asignacion->dbActualizar()) {
                // Formalización HATEOAS de profesor.
                $profesorLink = FormularioAjax::generateHateoasSelectLink(
                    'profesor',
                    'single',
                    $profesor
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
                    'messages' => array('Asignación actualizada correctamente.'),
                    self::TARGET_CLASS_NAME => $asignacion
                );
                
                $this->respondJsonOk($responseData);
            } else {
                $errors[] = 'Hubo un error al crear la asignación.';

                $this->respondJsonError(400, $errors); // Bad request.
            }
        }
    }
}

?>