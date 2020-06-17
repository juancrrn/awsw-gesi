<?php

namespace Awsw\Gesi\FormulariosAjax\MensajeForo;

use Awsw\Gesi\App;
use Awsw\Gesi\Datos\Foro;
use Awsw\Gesi\Datos\MensajeForo;
use Awsw\Gesi\FormulariosAjax\FormularioAjax;
use Awsw\Gesi\Sesion;
use SessionHandler;

/**
 * Formulario AJAX de creación de un mensaje de Foro por parte de un 
 * usuario con sesión iniciada, del rol que sea.
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

class MensajeForoCreate extends FormularioAjax
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
    private const FORM_ID = 'mensaje-foro-create';
    private const FORM_NAME = 'Crear mensaje principal de foro';
    private const TARGET_CLASS_NAME = 'MensajeForo';
    private const SUBMIT_URL = '/ses/mensajeforo/create/';
    private const EXPECTED_SUBMIT_METHOD = FormularioAjax::HTTP_POST;
    private const ON_SUCCESS_EVENT_NAME = 'created.ses.mensajesforo';
    private const ON_SUCCESS_EVENT_TARGET = '#mensaje-foro-ses-list';

    private $foroId;

    /**
     * Constructs the form object.
     */
    public function __construct($api = false, $foroId = null)
    {
        Sesion::requerirSesionIniciada($api);

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

        $this->foroId = $foroId;
    }

    protected function getDefaultData(array $requestData) : array
    {
        $responseData = array(
            'status' => 'ok'
        );

        return $responseData;
    }

    public function generateFormInputs(): string
    {
        $foroId = $this->foroId;
        
        $html = <<< HTML
        <input type="hidden" class="do-not-empty" name="foroId" value="$foroId">
        <div class="form-group">
            <label for="contenido">Contenido del mensaje</label>
            <textarea class="form-control" name="contenido" id="contenido" rows="3" placeholder="Contenido del mensaje"></textarea>
        </div>
        HTML;

        return $html;
    }

    public function processSubmit(array $data = array()): void
    {

        // Comprobar que el usuario tiene permisos para escribir en el foro
        $usuario = Sesion::getUsuarioEnSesion();

        $foroId = $data['foroId'] ?? null;

        if (($usuario->isEst() &&
            ! Foro::dbEstTienePermiso($usuario->getId(), $foroId)) ||
            ($usuario->isPd() &&
            ! Foro::dbPdTienePermiso($usuario->getId(), $foroId))) {

            $errors[] = 'No tienes permisos para publicar en este foro.';
        } elseif ($usuario->isPs()) {
            $errors[] = 'Para crear mensajes en el foro tienes que ser Estudiante o Personal Docente.';
        }


        $contenido = $data['contenido'] ?? null;
         
        if (empty($contenido)) {
            $errors[] = 'El campo contenido no puede estar vacío.';
        }

        // Comprobar si hay errores.
        if (! empty($errors)) {
            $this->respondJsonError(400, $errors); // Bad request.
        } else {
            $now = date('Y-m-d H:i:s');

            $mensaje = new MensajeForo(
                null,
                $foroId,
                null,
                Sesion::getUsuarioEnSesion()->getId(),
                $now,
                $contenido
            );

            if ($mensaje->dbInsertar()) {
                $responseData = array(
                    'status' => 'ok',
                    'messages' => array('Respuesta a menaje de foro creada correctamente.'),
                    self::TARGET_CLASS_NAME => $mensaje
                );
                
                $this->respondJsonOk($responseData);
            } else {
                $errors[] = 'Hubo un error al crear la respuesta al mensaje de foro.';

                $this->respondJsonError(400, $errors); // Bad request.
            }
        }
    }
}

?>