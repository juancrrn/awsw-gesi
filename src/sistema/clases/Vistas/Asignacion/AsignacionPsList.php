<?php 

/**
 * Vista de  de usuarios.
 *
 * - PAS: único permitido.
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
 * @version 0.0.2
 */

namespace Awsw\Gesi\Vistas\Asignacion;

use Awsw\Gesi\Sesion;
use Awsw\Gesi\Vistas\Modelo;
use Awsw\Gesi\Datos\Asignacion;
use Awsw\Gesi\Datos\Asignatura;
use Awsw\Gesi\Datos\Usuario;
use Awsw\Gesi\Datos\Grupo;
use Awsw\Gesi\Formularios\Valido;
use Awsw\Gesi\FormulariosAjax\Asignacion\AsignacionPsCreate;
use Awsw\Gesi\FormulariosAjax\Asignacion\AsignacionPsRead;
use Awsw\Gesi\FormulariosAjax\Asignacion\AsignacionPsUpdate;

class AsignacionPsList extends Modelo
{
    public const VISTA_NOMBRE = "Gestionar asignaciones";
    public const VISTA_ID = "asignacion-ps-list";

    private $listado;

    public function __construct()
    {
        Sesion::requerirSesionPs();

        $this->nombre = self::VISTA_NOMBRE;
        $this->id = self::VISTA_ID;

        $this->listado = Asignacion::dbGetAll();
    }

    public function procesaContent() : void
    {
        // Create asignación.
        $formCreate = new AsignacionPsCreate();
        $formCreateModal = $formCreate->generateModal();

        // Read asignación.
        $formRead = new AsignacionPsRead();
        $formReadModal = $formRead->generateModal();

        // Update asignación.
        $formUpdate = new AsignacionPsUpdate();
        $formUpdateModal = $formUpdate->generateModal();

        $listaAsignaciones = $this->generaListaAsignaciones($formRead, $formUpdate);

        $formCreateBtn = $formCreate->generateButton('Crear', null, true);
        
        $html = <<< HTML
        <h2 class="mb-4">$formCreateBtn $this->nombre</h2>
        <p>A continuación se muestra una lista con las asignaciones profesor-asignatura-grupo existentes.</p>
        <table id="asignacion-ps-list" class="table table-borderless table-striped">
            <thead>
                <tr>
                    <th scope="col">Profesor</th>
                    <th scope="col">Asignatura</th>
                    <th scope="col">Grupo</th>
                    <th scope="col" class="text-right">Acciones</th>
                </tr>
            </thead>
            <tbody>
                $listaAsignaciones
            </tbody>
        </table>
        $formCreateModal
        $formReadModal
        $formUpdateModal
        HTML;

        echo $html;

    }

    public function generaListaAsignaciones(AsignacionPsRead $formRead, AsignacionPsUpdate $formUpdate) : string
    {
        $buffer = '';

        if (! empty($this->listado)) {
            foreach ($this->listado as $asignacion) {
                $uniqueId = $asignacion->getId();

                $profesor = Usuario::dbGet($asignacion->getProfesor());
                $profesorNombre = $profesor->getNombreCompleto();

                $asignatura = Asignatura::dbGet($asignacion->getAsignatura());
                $asignaturaNombre = $asignatura->getNombreCompleto();
                
                $grupo = Grupo::dbGet($asignacion->getGrupo());
                $grupoNombre = $grupo->getNombreCompleto();

                $formReadBtn = $formRead
                    ->generateButton('Ver', $asignacion->getId(), true);
                $formUpdateBtn = $formUpdate
                    ->generateButton('Editar', $asignacion->getId(), true);
                
                $buffer .= <<< HTML
                <tr data-unique-id="$uniqueId">
                    <td data-col-name="profesorNombre">$profesorNombre</td>
                    <td data-col-name="asignaturaNombre">$asignaturaNombre</td>
                    <td data-col-name="grupoNombre">$grupoNombre</td>
                    <td class="text-right">$formReadBtn $formUpdateBtn</td>
                </tr>
                HTML;
            }
        } else {
            $buffer .= <<< HTML
            <tr>
                <td></td>
                <td>No se ha encontrado ninguna asignación.</td>
                <td></td>
                <td></td>
            </tr>
            HTML;
        }

        return $buffer;
    }
}

?>