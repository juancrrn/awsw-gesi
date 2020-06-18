<?php

namespace Awsw\Gesi\FormulariosAjax\Usuario;

use Awsw\Gesi\App;
use Awsw\Gesi\Datos\Usuario;
use Awsw\Gesi\Validacion\Valido;
use Awsw\Gesi\FormulariosAjax\FormularioAjax;
use Awsw\Gesi\Sesion;

/**
 * Formulario AJAX de creación de un usuario de personal docente por 
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

class PdPsCreate extends FormularioAjax
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
    private const FORM_ID = 'usuario-pd-ps-create';
    private const FORM_NAME = 'Crear personal docente';
    private const TARGET_CLASS_NAME = 'Usuario';
    private const SUBMIT_URL = '/ps/usuarios/pd/create/';
    private const EXPECTED_SUBMIT_METHOD = FormularioAjax::HTTP_POST;
    private const ON_SUCCESS_EVENT_NAME = 'created.usuario.pd';
    private const ON_SUCCESS_EVENT_TARGET = '#usuario-pd-lista';

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
        $responseData = array(
            'status' => 'ok',
        );

        return $responseData;

    }

    public function generateFormInputs(): string
    {
        $defaultUserPassword = GESI_DEFAULT_PASSWORD;

        $html = <<< HTML
        <div class="form-group">
            <label for="nif">NIF</label>
            <input class="form-control" type="text" name="nif" id="nif" placeholder="NIF" required="required" />
        </div>
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input class="form-control" type="text" name="nombre" id="nombre" placeholder="Nombre" required="required" />
        </div>
        <div class="form-group">
            <label for="apellidos">Apellidos</label>
            <input class="form-control" type="text" name="apellidos" id="apellidos" placeholder="Apellidos" required="required" />
        </div>
        <div class="form-group">
            <label for="fecha_nacimiento">Fecha de nacimiento</label>
            <input class="form-control" type="text" name="fecha_nacimiento" id="fecha_nacimiento" placeholder="Fecha de nacimiento" required="required" />
        </div>
        <div class="form-group">
            <label for="numero_telefono">Número de teléfono</label>
            <input class="form-control" type="text" name="numero_telefono" id="numero_telefono" placeholder="Número de teléfono" required="required" />
        </div>
        <div class="form-group">
            <label for="email">Dirección de correo electrónico</label>
            <input class="form-control" type="text" name="email" id="email" placeholder="Dirección de correo electrónico" required="required" />
        </div>
        <div class="mt-4">
            La contraseña por defecto es <code>$defaultUserPassword</code>.
        </div>
        HTML;

        return $html;
    }

    public function processSubmit(array $data = array()): void
    {
        $nif = $data['nif'] ?? null;
        $nombre = $data['nombre'] ?? null;
        $apellidos = $data['apellidos'] ?? null;
        $fecha_nacimiento = $data['fecha_nacimiento'] ?? null;
        $numero_telefono = $data['numero_telefono'] ?? null;
        $email = $data['email'] ?? null;

        if (empty($nif)) {
            $errors[] = 'El campo NIF o NIE no puede estar vacío.';
        } elseif (! Valido::testNif($nif)) {
            $errors[] = 'El campo NIF o NIE no es válido.';
        }

        if (empty($nombre)) {
            $errors[] = 'El campo nombre no puede estar vacío.';
        } elseif (! Valido::testStdString($nombre)) {
            $errors[] = 'El campo nombre no es válido. Solo puede contener letras, espacios y guiones; y debe tener entre 3 y 128 caracteres.';
        }

        if (empty($apellidos)) {
            $errors[] = 'El campo apellidos no puede estar vacío.';
        } elseif (! Valido::testStdString($apellidos)) {
            $errors[] = 'El campo apellidos no es válido. Solo puede contener letras, espacios y guiones; y debe tener entre 3 y 128 caracteres.';
        }

        if (empty($fecha_nacimiento)) {
            $errors[] = 'El campo fecha de nacimiento no puede estar vacío.';
        } else {
            $fecha_nacimiento = Valido::testDate($fecha_nacimiento);
            
            if (! $fecha_nacimiento) {
                $errors[] = 'El campo fecha de nacimiento no es válido. El formato debe ser dd/mm/yyyy.';
            }
        }

        if (empty($numero_telefono)) {
            $errors[] = 'El campo número de teléfono no puede estar vacío.';
        } elseif (! Valido::testNumeroTelefono($numero_telefono)) {
            $errors[] = 'El campo número de teléfono no es válido.';
        }

        if (empty($email)) {
            $errors[] = 'El campo dirección de correo electrónico no puede estar vacío.';
        } elseif (! Valido::testEmail($email)) {
            $errors[] = 'El campo dirección de correo electrónico no es válido.';
        }

        // Comprobar si hay errores.
        if (! empty($errors)) {
            $this->respondJsonError(400, $errors); // Bad request.
        } else {
            $now = date('Y-m-d H:i:s');

            $usuario = new Usuario(
                null,
                $nif,
                2,
                $nombre,
                $apellidos,
                $fecha_nacimiento,
                $numero_telefono,
                $email,
                null,
                $now,
                null
            );

            $usuario_id = $usuario->dbInsertar();

            if ($usuario_id) {
                $responseData = array(
                    'status' => 'ok',
                    'messages' => array('El usuario de personal docente fue creado correctamente.'),
                    self::TARGET_CLASS_NAME => $usuario
                );
                
                $this->respondJsonOk($responseData);
            } else {
                $errors[] = 'Hubo un error al crear el usuario de personal docente.';

                $this->respondJsonError(400, $errors); // Bad request.
            }
        }
    }
}

?>