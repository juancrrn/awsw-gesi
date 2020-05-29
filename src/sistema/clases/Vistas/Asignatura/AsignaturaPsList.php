<?php 

/**
 * Vista de administración de asignaturas.
 *
 * - PS: puede editar todas las asignaturas.
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

namespace Awsw\Gesi\Vistas\Asignatura;

use Awsw\Gesi\App;
use Awsw\Gesi\Vistas\Modelo;
use Awsw\Gesi\Datos\Asignatura;
use Awsw\Gesi\Sesion;

use Awsw\Gesi\FormulariosAjax\Asignatura\AsignaturaPsCreate;
use Awsw\Gesi\FormulariosAjax\Asignatura\AsignaturaPsRead;
use Awsw\Gesi\FormulariosAjax\Asignatura\AsignaturaPsUpdate;
use Awsw\Gesi\FormulariosAjax\Asignatura\AsignaturaPsDelete;

class AsignaturaPsList extends Modelo
{
    public const VISTA_NOMBRE = "Gestionar asignaturas";
    public const VISTA_ID = "asignatura-ps-list";

    private $listado;

    public function __construct()
    {    
        Sesion::requerirSesionPs();

        $this->nombre = self::VISTA_NOMBRE;
        $this->id = self::VISTA_ID;

        $this->listado = Asignatura::dbGetAll();
    }

    public function procesaContent(): void 
    {
        $app = App::getSingleton();

        $createForm = new AsignaturaPsCreate();
        $createModal = $createForm->generateModal();

        $readForm = new AsignaturaPsRead();
        $readModal = $readForm->generateModal();

        $updateForm = new AsignaturaPsUpdate();
        $updateModal = $updateForm->generateModal();

        $deleteForm = new AsignaturaPsDelete();
        $deleteModal = $deleteForm->generateModal();

        $formCreateButton = $createForm->generateButton('Crear', null, true);

        $lista = $this->generaLista($readForm, $updateForm, $deleteForm);

        $html = <<< HTML
            <h3 class="mb-4">$formCreateButton Asignaturas</h3>
            <table id="asignatura-ps-list" class="table table-borderless table-striped">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">Nivel</th>
                        <th scope="col">Curso</th>
                        <th scope="col">Nombre</th>
                        <th scope="col" class="text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    $lista
                </tbody>
            </table>
            $createModal
            $readModal
            $updateModal
            $deleteModal
        HTML;

        echo $html;
    }

    private function generaLista(
        AsignaturaPsRead $readForm,
        AsignaturaPsUpdate $updateForm,
        AsignaturaPsDelete $deleteForm
    ): string
    {
        $buffer = '';

        if (! empty($this->listado)) {
            foreach ($this->listado as $a) {
                $uniqueId= $a->getId();
                $corto = $a->getNombreCorto();
                $nivel = $a->getNivel();
                $curso = $a->getCursoEscolar();
                $largo = $a->getNombreCompleto();

                $buttons =
                    $readForm->generateButton('Ver', $uniqueId, true) .
                    $updateForm->generateButton('Editar', $uniqueId, true) .
                    $deleteForm->generateButton('Eliminar', $uniqueId, true);

                $buffer .= <<< HTML
                    <tr data-unique-id="$uniqueId">
                        <td scope="row" data-col-name="nombreCorto">$corto</td>
                        <td data-col-name="nivel">$nivel</td>
                        <td data-col-name="curso">$curso</td>
                        <td data-col-name="nombreCompleto">$largo</td>
                        <td class="text-right">$buttons</td>
                    </tr>
                HTML;
            }

        }else{
            $buffer .= <<< HTML
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>No se han encontrado Asignaturas.</td>
                <td></td>
            </tr>
            HTML;
        }

        return $buffer;
    }
}

?>