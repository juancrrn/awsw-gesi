<?php

namespace Awsw\Gesi\FormulariosAjax\Usuario\PD;

use Awsw\Gesi\App;
use Awsw\Gesi\FormulariosAjax\FormularioAjax;
use Awsw\Gesi\Datos\Usuario;

/**
 * Formulario AJAX para eliminar un usuario de personal docente por parte de 
 * un administrador (personal de Secretaría).
 *
 * @package awsw-gesi
 * Gesi
 * Aplicación de gestión de institutos de educación secundaria
 *
 * @author Andrés Ramiro Ramiro
 * @author Cintia María Herrera Arenas
 * @author Nicolás Pardina Popp
 * @author Pablo Román Morer Olmos
 * @author Juan Francisco Carrión Molina
 *
 * @version 0.0.4
 */

 class PDAdminDelete extends FormularioAjax
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
    private const FORM_ID = 'personaldocente-delete';
    private const FORM_NAME = 'Eliminar personal docente';
    private const TARGET_OBJECT_NAME = 'Usuario';
    private const SUBMIT_URL = '/admin/usuarios/pd/delete/';
    private const EXPECTED_SUBMIT_METHOD = FormularioAjax::HTTP_DELETE;
    private const ON_SUCCESS_EVENT_NAME = 'deleted.personaldocente';
    private const ON_SUCCESS_EVENT_TARGET = '#personaldocente-lista'; // TODO

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
    /*
    protected function getDefaultData(array $requestData) : array
    {  
        // Mapear los datos para que coincidan con los nombres de los inputs.
        $responseData = array(
            'status' => 'ok',
        );

        return $responseData;

    }
    */

    /*
    public function generateFormInputs() : string
    {
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
        HTML;

        return $html;
    }
    */
    /*
    public function processSubmit(array $data = array()) : void
    {
        $nif = $data['nif'] ?? null;
        $nombre = $data['nombre'] ?? null;
        $apellidos = $data['apellidos'] ?? null;
        $fecha_nacimiento = $data['fecha_nacimiento'] ?? null;
        $numero_telefono = $data['numero_telefono'] ?? null;
        $email = $data['email'] ?? null;
        $rol = $data['rol'] ?? null;

        if (empty($nif)) {
            $errors[] = 'El campo NIF no puede estar vacío.';
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
        } elseif (! Valido::testDate($fecha_nacimiento)) {
            $errors[] = 'El campo fecha de nacimiento no es válido. El formato debe ser dd/mm/yyyy.';
        } else {
            $format = 'd/m/Y';
            $d = \DateTime::createFromFormat($format, $fecha_nacimiento);
            $fecha_nacimiento = $d->getTimestamp();
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

        // Data create

        // Si no hay mensajes de error
        if (empty($errors)) {
            
            $now = time();

            $usuario = new Usuario(
                null,
                $nif,
                $rol,
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
                    self::TARGET_OBJECT_NAME => $usuario
                );
                
                $this->respondJsonOk($responseData);
            } else {
                $errors[] = 'Hubo un error al crear el usuario.';

                $this->respondJsonError(400, $errors); // Bad request
            }

        } else {
            $this->respondJsonError(400, $errors); // Bad request
        }
    }
    */
    
 /*     COPIA DE ADMIN ELIMINAR (FORMULARIO EN VEZ DE FORMULARIOAJAX)


class AdminEliminar extends Formulario
{   
    private $nombre;
    private $id;

    public function __construct(string $action, string $nombre, int $id) {
        parent::__construct('form-usuario-eliminar', array('action' => $action));
        $this->nombre = $nombre;
        $this->id = $id;
    }
    
    protected function generaCampos(array & $datos_iniciales = array()) : void
    {
        $this->html .= <<< HTML
<div class="form-group">
    <input type="checkbox" name="eliminar" id="eliminar" value="$this->id" required="required">
    <label for="eliminar">Eliminar al usuario $this->nombre y todos sus datos de Gesi.</label>
</div>
<div class="form-actions">
    <button type="submit" class="btn">Eliminar</button>
</div>

HTML;
    }
    

    protected function procesa(array & $datos) : void
    {
        $eliminar = isset($datos['eliminar']) ? $datos['eliminar'] : null;

        if (empty($eliminar) || $eliminar != $this->id) {
            Vista::encolaMensajeError('Debes marcar la casilla de verificación para eliminar el usuario.');
        }

        if (! Vista::hayMensajesError()) {
            $resultado = Usuario::dbEliminar($this->id);
            
            if (! $resultado) {
                Vista::encolaMensajeError("No se ha podido eliminar el Usuario correctamente.", "/admin/usuarios/");
            } else {
                Vista::encolaMensajeExito("Se ha eliminado el usuario correctamente.", "/admin/usuarios/");
            }
        }

        $this->genera();
    }
}

?>
 */
 }
 ?>
