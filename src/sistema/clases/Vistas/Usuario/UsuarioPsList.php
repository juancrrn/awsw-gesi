<?php 

/**
 * Vista de gestión de usuarios.
 *
 * - PAS: único permitido.
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

namespace Awsw\Gesi\Vistas\Usuario;

use Awsw\Gesi\Vistas\Modelo;
use Awsw\Gesi\Datos\Usuario;
use Awsw\Gesi\Sesion;

use Awsw\Gesi\FormulariosAjax\Usuario\EstPsCreate;
use Awsw\Gesi\FormulariosAjax\Usuario\EstPsRead;
use Awsw\Gesi\FormulariosAjax\Usuario\EstPsUpdate;
use Awsw\Gesi\FormulariosAjax\Usuario\EstPsDelete;

use Awsw\Gesi\FormulariosAjax\Usuario\PdPsCreate;
use Awsw\Gesi\FormulariosAjax\Usuario\PdPsRead;
use Awsw\Gesi\FormulariosAjax\Usuario\PdPsUpdate;
use Awsw\Gesi\FormulariosAjax\Usuario\PdPsDelete;

use Awsw\Gesi\FormulariosAjax\Usuario\PsPsCreate;
use Awsw\Gesi\FormulariosAjax\Usuario\PsPsRead;
use Awsw\Gesi\FormulariosAjax\Usuario\PsPsUpdate;
use Awsw\Gesi\FormulariosAjax\Usuario\PsPsDelete;

class UsuarioPsList extends Modelo
{
    public const VISTA_NOMBRE = 'Gestionar usuarios';
    public const VISTA_ID = 'usuario-ps-list';

    private $listadoEst;
    private $listadoPd;
    private $listadoPs;

    public function __construct()
    {
        Sesion::requerirSesionPs();

        $this->nombre = self::VISTA_NOMBRE;
        $this->id = self::VISTA_ID;

        $this->listadoEst = Usuario::dbGetByRol(1);
        $this->listadoPd = Usuario::dbGetByRol(2);
        $this->listadoPs = Usuario::dbGetByRol(3);
    }

    public function procesaContent(): void
    {
        $html = <<< HTML
        <h2 class="mb-4">$this->nombre</h2>
        HTML;

        $html .= $this->generaListaPs();
        $html .= $this->generaListaPd();
        $html .= $this->generaListaEst();

        echo $html;
    }

    /**
     * Genera el listado de estudiantes.
     * 
     * @return string Listado de estudiantes.
     */
    public function generaListaEst(): string
    {
        // Create estudiante.
        $formEstPsCreate = new EstPsCreate();
        $formEstPsCreateModal = $formEstPsCreate->generateModal();
        
        // Read estudiante.
        $formEstPsRead = new EstPsRead();
        $formEstPsReadModal = $formEstPsRead->generateModal();

        // Update estudiante.
        $formEstPsUpdate = new EstPsUpdate();
        $formEstPsUpdateModal = $formEstPsUpdate->generateModal();
    
        // Delete estudiante.
        $formEstPsDelete = new EstPsDelete();
        $formEstPsDeleteModal = $formEstPsDelete->generateModal();

        $listaEstBuffer = '';

        if (! empty($this->listadoEst)) {
            foreach ($this->listadoEst as $u) {
                $uniqueId = $u->getId();
                $nif = $u->getNif();
                $nombreCompleto = $u->getNombreCompleto();

                $formEstPsReadButton = $formEstPsRead
                    ->generateButton('Ver', $uniqueId, true);
                $formEstPsUpdateButton = $formEstPsUpdate
                    ->generateButton('Editar', $uniqueId, true);
                $formEstPsDeleteButton = $formEstPsDelete
                    ->generateButton('Eliminar', $uniqueId, true);

                $listaEstBuffer .= <<< HTML
                <tr data-unique-id="$uniqueId">
                    <td scope="row" data-col-name="nif">$nif</td>
                    <td data-col-name="nombre-completo">$nombreCompleto</td>
                    <td class="text-right">$formEstPsReadButton $formEstPsUpdateButton $formEstPsDeleteButton</td>
                </tr>
                HTML;

            }
        } else {
            $listaEstBuffer .= <<< HTML
            <tr>
                <td></td>
                <td>No se han encontrado usuarios estudiantes.</td>
                <td></td>
            </tr>
            HTML;
        }

        $formEstPsCreateButton = $formEstPsCreate
            ->generateButton('Crear', null, true);

        $html = <<< HTML
        <h3 class="mb-4">$formEstPsCreateButton Estudiantes</h3>
        <table id="usuario-est-lista" class="table table-borderless table-striped">
            <thead>
                <tr>
                    <th scope="col">NIF o NIE</th>
                    <th scope="col">Nombre</th>
                    <th scope="col" class="text-right">Acciones</th>
                </tr>
            </thead>
            <tbody>
                $listaEstBuffer
            </tbody>
        </table>
        $formEstPsCreateModal
        $formEstPsReadModal
        $formEstPsUpdateModal
        $formEstPsDeleteModal
        HTML;

        return $html;
    }

    /**
     * Genera el listado de personal docente.
     * 
     * @return string Listado de personal docente.
     */
    public function generaListaPd(): string
    {
        // Create personal docente.
        $formPdPsCreate = new PdPsCreate();
        $formPdPsCreateModal = $formPdPsCreate->generateModal();

        // Read personal docente.
        $formPdPsRead = new PdPsRead();
        $formPdPsReadModal = $formPdPsRead->generateModal();

        // Update personal docente.
        $formPdPsUpdate = new PdPsUpdate();
        $formPdPsUpdateModal = $formPdPsUpdate->generateModal();

        // Delete personal docente.
        $formPdPsDelete = new PdPsDelete();
        $formPdPsDeleteModal = $formPdPsDelete->generateModal();

        $listaPdBuffer = '';

        if (! empty($this->listadoPd)) {
            foreach ($this->listadoPd as $u) {
                $uniqueId = $u->getId();
                $nif = $u->getNif();
                $nombre = $u->getNombreCompleto();
                
                $formPdPsReadButton = $formPdPsRead
                    ->generateButton('Ver', $uniqueId, true);
                $formPdPsUpdateButton = $formPdPsUpdate
                    ->generateButton('Editar', $uniqueId, true);
                $formPdPsDeleteButton = $formPdPsDelete
                    ->generateButton('Eliminar', $uniqueId, true);

                $listaPdBuffer .= <<< HTML
                <tr data-unique-id="$uniqueId">
                    <td scope="row"  data-col-name="nif">$nif</td>
                    <td data-col-name="nombre-completo">$nombre</td>
                    <td class="text-right">$formPdPsReadButton $formPdPsUpdateButton $formPdPsDeleteButton</td>
                </tr>
                HTML;
            }
        } else {
            $listaPdBuffer .= <<< HTML
            <tr>
                <td></td>
                <td>No se han encontrado usuarios de personal docente.</td>
                <td></td>
            </tr>
            HTML;
        }

        $formPdPsCreateButton = $formPdPsCreate
            ->generateButton('Crear', null, true);

        $html = <<< HTML
        <h3 class="mb-4 mt-5">$formPdPsCreateButton Personal docente</h3>
        <table id="usuario-pd-lista" class="table table-borderless table-striped">
            <thead>
                <tr>
                    <th scope="col">NIF o NIE</th>
                    <th scope="col">Nombre</th>
                    <th scope="col" class="text-right">Acciones</th>
                </tr>
            </thead>
            <tbody>
                $listaPdBuffer
            </tbody>
        </table>
        $formPdPsCreateModal
        $formPdPsReadModal
        $formPdPsUpdateModal
        $formPdPsDeleteModal
        HTML;

        return $html;
    }

    /**
     * Genera el listado de personal de secretaria.
     * 
     * @return string Listado de personal de secretaria.
     */
    public function generaListaPs(): string
    {
        // Formulario de creación de personal de Secretaría.
        $formPsPsCreate = new PsPsCreate();
        $formPsPsCreateModal = $formPsPsCreate->generateModal();

        // Formulario de visualización de personal de Secretaría.
        $formPsPsRead = new PsPsRead();
        $formPsPsReadModal = $formPsPsRead->generateModal();

        // Formulario de modificación de personal de Secretaría.
        $formPsPsUpdate = new PsPsUpdate();
        $formPsPsUpdateModal = $formPsPsUpdate->generateModal();

         // Formulario de eliminación de personal de Secretaría.
        $formPsPsDelete = new PsPsDelete();
        $formPsPsDeleteModal = $formPsPsDelete->generateModal();

        $listaPsBuffer = '';

        if (! empty($this->listadoPs)) {
            foreach ($this->listadoPs as $u) {
                $uniqueId = $u->getId();
                $nif = $u->getNif();
                $nombre = $u->getNombreCompleto();
                
                $formPsPsReadButton = $formPsPsRead
                    ->generateButton('Ver', $uniqueId, true);
                $formPsPsUpdateButton = $formPsPsUpdate
                    ->generateButton('Editar', $uniqueId, true);
                $formPsPsDeleteButton = $formPsPsDelete
                    ->generateButton('Eliminar', $uniqueId, true);

                $listaPsBuffer .= <<< HTML
                <tr data-unique-id="$uniqueId">
                    <td scope="row">$nif</td>
                    <td>$nombre</td>
                    <td class="text-right">$formPsPsReadButton $formPsPsUpdateButton $formPsPsDeleteButton</td>
                </tr>
                HTML;
            }
        } else {
            $listaPsBuffer .= <<< HTML
            <tr>
                <td></td>
                <td>No se han encontrado usuarios de personal de Secretaría.</td>
                <td></td>
            </tr>
            HTML;
        }

        $formPsPsCreateButton = $formPsPsCreate
            ->generateButton('Crear', null, true);

        $html = <<< HTML
        <h3 class="mb-4 mt-5">$formPsPsCreateButton Personal de Secretaría</h3>
        <table id="usuario-ps-lista" class="table table-borderless table-striped">
            <thead>
                <tr>
                    <th scope="col">NIF o NIE</th>
                    <th scope="col">Nombre</th>
                    <th scope="col" class="text-right">Acciones</th>
                </tr>
            </thead>
            <tbody>
                $listaPsBuffer
            </tbody>
        </table>
        $formPsPsCreateModal
        $formPsPsReadModal
        $formPsPsUpdateModal
        $formPsPsDeleteModal
        HTML;

        return $html;
    }
}

?>