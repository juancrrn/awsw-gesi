<?php

namespace Awsw\Gesi\FormulariosAjax\Usuario;

use Awsw\Gesi\App;
use Awsw\Gesi\Datos\Usuario;
use Awsw\Gesi\FormulariosAjax\FormularioAjax;

/**
 * Formulario AJAX de visualizacion de un usuario de personal 
 * de Secretaría por parte de un administrador (Personal de secretaria)
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

class PsPsRead extends FormularioAjax
{

    /**
     * Initialize specific form constants.
     *
     * @var string FORM_ID
     * @var string FORM_NAME
     * @var string TARGET_CLASS_NAME
     * @var string SUBMIT_URL
     */
    private const FORM_ID = 'usuario-ps-read';
    private const FORM_NAME = 'Ver personal de Secretaría';
    private const TARGET_CLASS_NAME = 'Usuario';
    private const SUBMIT_URL = '/admin/usuarios/ps/read/';

    /**
     * Constructs the form object
     */
    public function __construct()
    {
        $app = App::getSingleton();

        parent::__construct(
            self::FORM_ID,
            self::FORM_NAME,
            self::TARGET_CLASS_NAME,
            self::SUBMIT_URL,
            null
        );

        $this->setReadOnlyTrue();
    }

    protected function getDefaultData(array $requestData) : array
    {  
        // Check that uniqueId was provided
        if (! isset($requestData['uniqueId'])) {
            $responseData = array(
                'status' => 'error',
                'error' => 400, // Bad request
                'messages' => array(
                    'Falta el parámetro "uniqueId".'
                )
            );
    
            return $responseData;
        }

        $uniqueId = $requestData['uniqueId'];

        // Comprobar que el uniqueId es válido.
        if (! Usuario::dbExisteId($uniqueId)) {
            $responseData = array(
                'status' => 'error',
                'error' => 404, // Not found.
                'messages' => array(
                    'El usuario de personal docente solicitado no existe.'
                )
            );

            return $responseData;
        }

        $usuario = Usuario::dbGet($uniqueId);

        // Map data to match placeholder inputs' names
        $responseData = array(
            'status' => 'ok',
            self::TARGET_CLASS_NAME => $usuario
        );

        return $responseData;

    }

    public function generateFormInputs() : string
    {
        $html = <<< HTML
        <div class="form-group">
            <label>NIF</label>
            <input class="form-control" type="text" name="nif" placeholder="NIF" disabled="disabled" />
        </div>
        <div class="form-group">
            <label>Nombre</label>
            <input class="form-control" type="text" name="nombre" placeholder="Nombre" disabled="disabled" />
        </div>
        <div class="form-group">
            <label>Apellidos</label>
            <input class="form-control" type="text" name="apellidos" placeholder="Apellidos" disabled="disabled" />
        </div>
        <div class="form-group">
            <label>Fecha de nacimiento</label>
            <input class="form-control" type="text" name="fechaNacimiento" placeholder="Fecha de nacimiento" disabled="disabled" />
        </div>
        <div class="form-group">
            <label>Fecha de último acceso</label>
            <input class="form-control" type="text" name="fechaUltimoAcceso" placeholder="Fecha de último acceso" disabled="disabled" />
        </div>
        <div class="form-group">
            <label>Número de teléfono</label>
            <input class="form-control" type="text" name="numeroTelefono" placeholder="Número de teléfono" disabled="disabled" />
        </div>
        <div class="form-group">
            <label>Dirección de correo electrónico</label>
            <input class="form-control" type="text" name="email" placeholder="Dirección de correo electrónico" disabled="disabled" />
        </div>
        HTML;

        return $html;
    }

    public function processSubmit(array $data = array()) : void
    {
    }
}

?>