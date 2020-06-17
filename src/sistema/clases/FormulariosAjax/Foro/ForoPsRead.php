<?php

namespace Awsw\Gesi\FormulariosAjax\Foro;

use Awsw\Gesi\FormulariosAjax\FormularioAjax;
use Awsw\Gesi\Datos\Foro;

/**
 * Formulario AJAX de visualización de un usuario de personal docente por parte 
 * de un administrador (personal de Secretaría).
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

class ForoPsRead extends FormularioAjax
{

    /**
     * Initialize specific form constants.
     *
     * @var string FORM_ID
     * @var string FORM_NAME
     * @var string TARGET_CLASS_NAME
     * @var string SUBMIT_URL
     */
    private const FORM_ID = 'foro-ps-read';
    private const FORM_NAME = 'Ver Foro';
    private const TARGET_CLASS_NAME = 'Foro';
    private const SUBMIT_URL = '/ps/foros/read/';

    /**
     * Constructs the form object
     */
    public function __construct()
    {
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

        // Map data to match placeholder inputs' names
        $responseData = array(
            'status' => 'ok',
            self::TARGET_CLASS_NAME => $foro
        );

        return $responseData;
    }

    public function generateFormInputs(): string
    {
        $html = <<< HTML
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input class="form-control" type="text" name="nombre" id="nombre" placeholder="Nombre" disabled="disabled">
        </div>
        HTML;

        return $html;
    }

    public function processSubmit(array $data = array()): void
    {
    }
}

?>