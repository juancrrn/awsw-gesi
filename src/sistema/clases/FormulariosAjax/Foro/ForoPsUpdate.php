<?php

namespace Awsw\Gesi\FormulariosAjax\Foro;

use Awsw\Gesi\App;
use Awsw\Gesi\Datos\Foro;
use Awsw\Gesi\FormulariosAjax\FormularioAjax;
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
 * @version 0.0.4-beta.01
 */

class ForoPsUpdate extends FormularioAjax
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
    private const FORM_ID = 'foro-ps-update';
    private const FORM_NAME = 'Editar Foro';
    private const TARGET_CLASS_NAME = 'Foro';
    private const SUBMIT_URL = '/ps/foros/update/';
    private const EXPECTED_SUBMIT_METHOD = FormularioAjax::HTTP_PATCH;
    private const ON_SUCCESS_EVENT_NAME = 'updated.foro';
    private const ON_SUCCESS_EVENT_TARGET = '#foro-ps-list';

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
        if (! Foro::dbExisteId($uniqueId)) {
            $responseData = array(
                'status' => 'error',
                'error' => 404, // Not found.
                'messages' => array(
                    'El foro solicitado no existe.'
                )
            );

            return $responseData;
        }

        $foro = Foro::dbGet($uniqueId);

        $responseData = array(
            'status' => 'ok',
            self::TARGET_CLASS_NAME => $foro
        );

        return $responseData;
    }

    public function generateFormInputs(): string
    {
        $html = <<< HTML
        <input type="hidden" name="uniqueId">
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input class="form-control" type="text" name="nombre" id="nombre" placeholder="Nombre" required="required" />
        </div>
        HTML;

        return $html;
    }

    public function processSubmit(array $data = array()): void
    {
        $uniqueId = $data['uniqueId'] ?? null;
        
        // Check Record's uniqueId is valid
        if (! Foro::dbExisteId($uniqueId)) {
            $errors[] = 'El foro solicitado no existe.';

            $this->respondJsonError(404, $errors); // Not found.
        }

        $nombre = $data['nombre'] ?? null;

        if (empty($nombre)) {
            $errors[] = 'El campo nombre no puede estar vacío.';
        }
        
        // Comprobar si hay errores.
        if (! empty($errors)) {
            $this->respondJsonError(400, $errors); // Bad request.
        } else {

            $foro = new Foro(
                $uniqueId,
                $nombre
            );

            $actualizar = $foro->dbActualizar();

            if ($actualizar) {
                $responseData = array(
                    'status' => 'ok',
                    'messages' => array('Foro actualizado correctamente.'),
                    self::TARGET_CLASS_NAME => $foro
                );
                
                $this->respondJsonOk($responseData);
            } else {
                $errors[] = 'Error al actualizar el foro.';

                $this->respondJsonError(400, $errors); // Bad request.
            }

        }
    
    }
}

?>