<?php

namespace Awsw\Gesi\FormulariosAjax\Usuario;

use Awsw\Gesi\App;
use Awsw\Gesi\Datos\Grupo;
use Awsw\Gesi\FormulariosAjax\FormularioAjax;

use PhpAjaxFormDemo\Data\MultiForeignRecord;
use PhpAjaxFormDemo\Data\SingleForeignRecord;
use PhpAjaxFormDemo\Forms\AjaxForm;
use PhpAjaxFormDemo\Data\Record;
use stdClass;

/**
 * Formulario AJAX de creación de un usuario por parte de un administrador 
 * (personal de Secretaría).
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

class EstudianteAdminCreate extends FormularioAjax
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
    private const FORM_ID = 'estudiante-create';
    private const FORM_NAME = 'Crear estudiante';
    private const TARGET_OBJECT_NAME = 'Usuario';
    private const SUBMIT_URL = '/admin/estudiantes/create/';
    private const EXPECTED_SUBMIT_METHOD = FormularioAjax::HTTP_POST;
    private const ON_SUCCESS_EVENT_NAME = 'created.estudiante';
    private const ON_SUCCESS_EVENT_TARGET = '#estudiante-lista'; // TODO

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
		$rolEst = new stdClass;
		$rolEst->id = 1;
		$rolEst->selectName = 'Estudiante';
        $rolEst->name = 'Estudiante';
        
        // Formalización HATEOAS de roles.
        $rolLink = FormularioAjax::generateHateoasSelectLink(
            'rol',
            'single',
            $rolEst
        );

        // Formalización HATEOAS de grupos.
        $grupoLink = FormularioAjax::generateHateoasSelectLink(
            'grupo',
            'single',
            Grupo::dbGetAll()
        );

        // Mapear datos para que coincidan con los nombres de los inputs.
        $responseData = array(
            'status' => 'ok',
            'links' => array(
                $rolLink,
                $grupoLink
            )
        );

        return $responseData;
    }

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
        <div class="form-group">
            <label for="rol">Rol</label>
            <select class="form-control" name="rol" id="rol" required="required" disabled="disabled">
            </select>
        </div>
        <div class="form-group">
            <label for="grupo">Grupo</label>
            <select class="form-control" name="grupo" id="grupo" required="required" disabled="disabled">
            </select>
        </div>
        HTML;

        return $html;
    }

    public function processSubmit(array $data = array()) : void
    {
        $name = $data['name'] ?? null;
        $surname = $data['surname'] ?? null;
        $nationality = $data['nationality'] ?? null;
        $hobbies = $data['hobbies'] ?? null;
        
        // Check all required fields were sent
        if (empty($name) || empty($surname) || empty($nationality)) {
            if (empty($name)) {
                $errors[] = 'Missing param "name".';
            }

            if (empty($surname)) {
                $errors[] = 'Missing param "surname".';
            }

            if (empty($nationality)) {
                $errors[] = 'Missing param "nationality".';
            }

            // Hobbies are optional

            $this->respondJsonError(400, $errors); // Bad request
        }

        // Check SingleForeignRecord (nationality)'s uniqueId is valid
        if (! SingleForeignRecord::existsById($nationality)) {
            $errors[] = 'Nationality not found.'; // with "uniqueId" "' . $uniqueId . '"

            $this->respondJsonError(404, $errors); // Not found
        }

        $nationalityObject = SingleForeignRecord::getById($nationality);

        $hobbiesArray = array();

        // Chech if any hobbies were sent
        if ($hobbies) {
            // Check if only one hobby was sent, and convert it
            if (! is_array($hobbies)) {
                $hobbies = array($hobbies);
            }

            // Check MultiForeignRecords (hobbies)' uniqueIds are valid
            foreach ($hobbies as $hobbie) {
                if (! MultiForeignRecord::existsById($hobbie)) {
                    $errors[] = 'Hobbie not found.'; // with "uniqueId" "' . $hobbie . '"

                    $this->respondJsonError(404, $errors); // Not found
                }

                $hobbiesArray[] = MultiForeignRecord::getById($hobbie);
            }
        }
        
        // In real projects, data creation would be here.

        // Generate inserted id.
        do {
            $uniqueId = rand();
        } while (Record::existsById($uniqueId));
        
        $record = new Record(
            $uniqueId,
            $name,
            $surname,
            $nationalityObject,
            $hobbiesArray
        );

        // Nationality HATEOAS formalization
        $nationalityLink = AjaxForm::generateHateoasSelectLink(
            'nationality',
            'single',
            $record->getNationality()
        );

        // Hobbies HATEOAS formalization
        $hobbiesLink = AjaxForm::generateHateoasSelectLink(
            'hobbies',
            'multi',
            $record->getHobbies()
        );

        // Map data to match placeholder inputs' names
        $responseData = array(
            'status' => 'ok',
            'links' => array(
                $nationalityLink,
                $hobbiesLink
            ),
            self::TARGET_OBJECT_NAME => $record
        );

        $this->respondJsonOk($responseData);
    }
}

?>