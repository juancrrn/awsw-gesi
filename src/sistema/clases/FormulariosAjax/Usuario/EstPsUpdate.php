<?php

namespace Awsw\Gesi\FormulariosAjax\Usuario;

use Awsw\Gesi\App;
use Awsw\Gesi\Datos\Grupo;
use Awsw\Gesi\FormulariosAjax\FormularioAjax;
use Awsw\Gesi\Datos\Usuario;
use Awsw\Gesi\Formularios\Valido;

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

class EstPsUpdate extends FormularioAjax
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
    private const FORM_ID = 'usuario-est-update';
    private const FORM_NAME = 'Editar estudiante';
    private const TARGET_OBJECT_NAME = 'Usuario';
    private const SUBMIT_URL = '/admin/usuarios/est/update/';
    private const EXPECTED_SUBMIT_METHOD = FormularioAjax::HTTP_PATCH;
    private const ON_SUCCESS_EVENT_NAME = 'updated.usuario.est';
    private const ON_SUCCESS_EVENT_TARGET = '#usuario-est-lista';

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
        if (! Usuario::dbExisteId($uniqueId)) {
            $responseData = array(
                'status' => 'error',
                'error' => 404, // Not found.
                'messages' => array(
                    'El usuario estudiante solicitado no existe.'
                )
            );

            return $responseData;
        }
        
        // Formalización HATEOAS de grupos.
        $grupoLink = FormularioAjax::generateHateoasSelectLink(
            'grupo',
            'single',
            Grupo::dbGetAll()
        );

        $usuario = Usuario::dbGet($uniqueId);

        $responseData = array(
            'status' => 'ok',
            'links' => array(
                $grupoLink
            ),
            self::TARGET_OBJECT_NAME => $usuario
        );

        return $responseData;
    }

    public function generateFormInputs() : string
    {
        $html = <<< HTML
        <input type="hidden" name="uniqueId">
        <div class="form-group">
            <label for="nif">NIF</label>
            <input class="form-control" type="text" name="nif" id="nif" placeholder="NIF" required="required">
        </div>
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input class="form-control" type="text" name="nombre" id="nombre" placeholder="Nombre" required="required">
        </div>
        <div class="form-group">
            <label for="apellidos">Apellidos</label>
            <input class="form-control" type="text" name="apellidos" id="apellidos" placeholder="Apellidos" required="required">
        </div>
        <div class="form-group">
            <label for="fechaNacimiento">Fecha de nacimiento</label>
            <input class="form-control" type="text" name="fechaNacimiento" id="fechaNacimiento" placeholder="Fecha de nacimiento" required="required">
        </div>
        <div class="form-group">
            <label for="numeroTelefono">Número de teléfono</label>
            <input class="form-control" type="text" name="numeroTelefono" id="numeroTelefono" placeholder="Número de teléfono" required="required">
        </div>
        <div class="form-group">
            <label for="email">Dirección de correo electrónico</label>
            <input class="form-control" type="text" name="email" id="email" placeholder="Dirección de correo electrónico" required="required">
        </div>
        <div class="form-group">
            <label for="grupo">Grupo</label>
            <select class="form-control" name="grupo" id="grupo" required="required">
            </select>
        </div>
        HTML;

        return $html;
    }

    public function processSubmit(array $data = array()) : void
    {
        $uniqueId = $data['uniqueId'] ?? null;
        
        // Check Record's uniqueId is valid
        if (! Usuario::dbExisteId($uniqueId)) {
            $errors[] = 'El usuario estudiante solicitado no existe.';

            $this->respondJsonError(404, $errors); // Not found.
        }

        $nif = $data['nif'] ?? null;
        $nombre = $data['nombre'] ?? null;
        $apellidos = $data['apellidos'] ?? null;
        $fechaNacimiento = $data['fechaNacimiento'] ?? null;
        $numeroTelefono = $data['numeroTelefono'] ?? null;
        $email = $data['email'] ?? null;

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

        if (empty($fechaNacimiento)) {
            $errors[] = 'El campo fecha de nacimiento no puede estar vacío.';
        } else {
            $fechaNacimiento = Valido::testDate($fechaNacimiento);
            
            if (! $fechaNacimiento) {
                $errors[] = 'El campo fecha de nacimiento no es válido. El formato debe ser dd/mm/yyyy.';
            }
        }

        if (empty($numeroTelefono)) {
            $errors[] = 'El campo número de teléfono no puede estar vacío.';
        } elseif (! Valido::testNumeroTelefono($numeroTelefono)) {
            $errors[] = 'El campo número de teléfono no es válido.';
        }

        if (empty($email)) {
            $errors[] = 'El campo dirección de correo electrónico no puede estar vacío.';
        } elseif (! Valido::testEmail($email)) {
            $errors[] = 'El campo dirección de correo electrónico no es válido.';
        }

        // Comprobar grupo.
        
        $grupo = $data['grupo'] ?? null;

        if (empty($grupo)) {
            $errors[] = 'El campo grupo no puede estar vacío.';
        } elseif (! Grupo::dbExisteId($grupo)) {
            $errors[] = 'El campo grupo no es válido. Comprueba que el grupo existe.';
        }
        
        // Comprobar si hay errores.
        if (! empty($errors)) {
            $this->respondJsonError(400, $errors); // Bad request.
        } else {
            // Obtener datos que no se habían modificado.
            $anteriores = Usuario::dbGet($uniqueId);

            $fechaUltimoAcceso = $anteriores->getFechaUltimoAcceso();
            $fechaUltimoAcceso = ($fechaUltimoAcceso && $fechaUltimoAcceso !== '') ? Valido::testDateTime($fechaUltimoAcceso) : null;

            $fechaRegistro = $anteriores->getFechaRegistro();
            
            $fechaRegistro = ($fechaRegistro && $fechaRegistro !== '') ?Valido::testDateTime($fechaRegistro) : null;

            $usuario = new Usuario(
                $uniqueId,
                $nif,
                1,
                $nombre,
                $apellidos,
                $fechaNacimiento,
                $numeroTelefono,
                $email,
                $fechaUltimoAcceso,
                $fechaRegistro,
                $grupo
            );

            $actualizar = $usuario->dbActualizar();

            if ($actualizar) {
                $responseData = array(
                    'status' => 'ok',
                    'messages' => array('Usuario estudiante actualizado correctamente.'),
                    self::TARGET_OBJECT_NAME => $usuario
                );
                
                $this->respondJsonOk($responseData);
            } else {
                $errors[] = 'Error al actualizar usuario estudiante.';

                $this->respondJsonError(400, $errors); // Bad request.
            }

        }
    
    }
}

?>