<?php

namespace Awsw\Gesi\FormulariosAjax\EventoInvCreate;

use Awsw\Gesi\App;
use Awsw\Gesi\Datos\Evento;
use Awsw\Gesi\Formularios\Valido;
use Awsw\Gesi\FormulariosAjax\FormularioAjax;
use Awsw\Gesi\Sesion;

/**
 * Formulario AJAX de creación de un Evento por parte de un 
 * usuario invitado (sin sesión iniciada).
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

class MensajeSecretariaInvCreate extends FormularioAjax
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
    private const FORM_ID = 'evento-inv-create';
    private const FORM_NAME = 'Crear Evento';
    private const TARGET_CLASS_NAME = 'Evento';
    private const SUBMIT_URL = '/inv/evento/create/';
    private const EXPECTED_SUBMIT_METHOD = FormularioAjax::HTTP_POST;

    /**
     * Constructs the form object.
     */
    public function __construct()
    {
        Sesion::requerirSesionNoIniciada();

        $app = App::getSingleton();

        parent::__construct(
            self::FORM_ID,
            self::FORM_NAME,
            self::TARGET_CLASS_NAME,
            $app->getUrl() . self::SUBMIT_URL,
            self::EXPECTED_SUBMIT_METHOD
        );
    }

    protected function getDefaultData(array $requestData) : array
    {
        $responseData = array(
            'status' => 'ok',
        );

        return $responseData;
    }

    public function generateFormInputs(): string
    {
        $html = <<< HTML
        <div class="form-group">
            <label for="fecha">Fecha</label>
            <input class="form-control" type="text" name="fecha" id="fecha" placeholder="fecha" required="required" />
        </div>
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input class="form-control" type="text" name="nombre" id="nombre" placeholder="nombre" required="required" />
        </div>
        <div class="form-group">
            <label for="descripcion">Descripcion</label>
            <input class="form-control" type="text" name="descripcion" id="descripcion" placeholder="descripcion" required="required" />
        </div>
        <div class="form-group">
            <label for="lugar">Lugar</label>
            <input class="form-control" type="text" name="lugar" id="lugar" placeholder="lugar" required="required" />
        </div>
        
        HTML;

        return $html;
    }

    public function processSubmit(array $data = array()): void
    {
        $fecha = $data['fecha'] ?? null;
        $nombre = $data['nombre'] ?? null;
        $descripcion = $data['descripcion'] ?? null;
        $lugar = $data['lugar'] ?? null;

        if (empty($nombre)) {
            $errors[] = 'El campo nombre no puede estar vacío.';
        } elseif (! Valido::testStdString($nombre)) {
            $errors[] = 'El campo nombre no es válido. Solo puede contener letras, espacios y guiones; y debe tener entre 3 y 128 caracteres.';
        }

        if (empty($fecha)) {
            $errors[] = 'El fecha no puede estar vacío.';
        } elseif (! Valido::testDate($fecha)) {
            $errors[] = 'El campo fecha no es válido.';
        }

        if (empty($descripcion)) {
            $errors[] = 'El campo contenido no puede estar vacío.';
        }

        if (empty($lugar)) {
            $errors[] = 'El campo nombre no puede estar vacío.';
        } elseif (! Valido::testStdString($lugar)) {
            $errors[] = 'El campo nombre no es válido. Solo puede contener letras, espacios y guiones; y debe tener entre 3 y 128 caracteres.';
        }

        // Comprobar si hay errores.
        if (! empty($errors)) {
            $this->respondJsonError(400, $errors); // Bad request.
        } else {
          
            $mensaje = new Evento(
              null,
              $fecha,
              $nombre,
              $descripcion,
              $lugar,
              null,
              null
            );

            if ($mensaje->dbInsertar()) {
                $responseData = array(
                    'status' => 'ok',
                    'messages' => array('Mensaje de Secretaría enviado correctamente.')
                );
                
                $this->respondJsonOk($responseData);
            } else {
                $errors[] = 'Hubo un error al enviar el mensaje de Secretaría.';

                $this->respondJsonError(400, $errors); // Bad request.
            }
        }
    }
}

?>