<?php

namespace Awsw\Gesi\FormulariosAjax\Foro;

use Awsw\Gesi\App;
use Awsw\Gesi\Datos\Foro;
use Awsw\Gesi\Validacion\Valido;
use Awsw\Gesi\FormulariosAjax\FormularioAjax;

/**
 * Formulario AJAX de creación de un foro por parte de un 
 * administrador (personal de Secretaría).
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

class ForoPsCreate extends FormularioAjax
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
    private const FORM_ID = 'foro-ps-create';
    private const FORM_NAME = 'Crear foro';
    private const TARGET_CLASS_NAME = 'Foro';
    private const SUBMIT_URL = '/ps/foros/create/';
    private const EXPECTED_SUBMIT_METHOD = FormularioAjax::HTTP_POST;
    private const ON_SUCCESS_EVENT_NAME = 'created.foro';
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
        // Mapear datos para que coincidan con los nombres de los inputs.
        $responseData = array(
            'status' => 'ok'
        );

        return $responseData;
    }

    public function generateFormInputs(): string
    {

        $html = <<< HTML
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input class="form-control" type="text" name="nombre" id="nombre" placeholder="Nombre" required="required" />
        </div>
        HTML;

        return $html;
    }

    public function processSubmit(array $data = array()): void
    {
        $nombre = $data['nombre'] ?? null;

        if (empty($nombre)) {
            $errors[] = 'El campo nombre no puede estar vacío.';
        } 

        // Comprobar si hay errores.
        if (! empty($errors)) {
            $this->respondJsonError(400, $errors); // Bad request.
        } else {

            $foro = new Foro(
                null,
                $nombre
            );

            $foro_id = $foro->dbInsertar();

            if ($foro_id) {
                $responseData = array(
                    'status' => 'ok',
                    'messages' => array('El foro fue creado correctamente.'),
                    self::TARGET_CLASS_NAME => $foro
                );
                
                $this->respondJsonOk($responseData);
            } else {
                $errors[] = 'Hubo un error al crear el foro.';

                $this->respondJsonError(400, $errors); // Bad request.
            }
        }
    }

    public static function autoHandle(): void
    {
        $form = new self();
        $form->manage();
    }
}

?>