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
 * @author Cintia María Herrera Arenas
 * @author Nicolás Pardina Popp
 * @author Pablo Román Morer Olmos
 * @author Juan Francisco Carrión Molina
 *
 * @version 0.0.2
 */

namespace Awsw\Gesi\Vistas\Usuario;

use Awsw\Gesi\App;
use Awsw\Gesi\Vistas\Modelo;
use Awsw\Gesi\Datos\Usuario;
use Awsw\Gesi\FormulariosAjax\Usuario\Est\EstAdminCreate as FormEstAdminCreate;
use Awsw\Gesi\FormulariosAjax\Usuario\Est\EstAdminRead as FormEstAdminRead;
use Awsw\Gesi\FormulariosAjax\Usuario\Est\EstAdminUpdate as FormEstAdminUpdate;
use Awsw\Gesi\FormulariosAjax\Usuario\Est\EstAdminDelete as FormEstAdminDelete;
use Awsw\Gesi\FormulariosAjax\Usuario\PD\PDAdminCreate as FormPDAdminCreate;
use Awsw\Gesi\FormulariosAjax\Usuario\PD\PDAdminRead as FormPDAdminRead;
use Awsw\Gesi\FormulariosAjax\Usuario\PS\PSAdminCreate as FormPSAdminCreate; 

use Awsw\Gesi\Sesion;

class UsuarioAdminList extends Modelo
{
    private const VISTA_NOMBRE = "Gestionar usuarios";
    private const VISTA_ID = "usuario-admin-lista";

    private $listado;

    public function __construct()
    {
        Sesion::requerirSesionPs();

        $this->nombre = self::VISTA_NOMBRE;
        $this->id = self::VISTA_ID;

        $this->listadoEst = Usuario::dbGetByRol(1);
        $this->listadoPd = Usuario::dbGetByRol(2);
        $this->listadoPs = Usuario::dbGetByRol(3);
    }

    public function procesaContent() : void
    {
        $app = App::getSingleton();

        $html = <<< HTML
        <h2 class="mb-4">$this->nombre</h2>
        HTML;

        $html .= $this->generaListaEst();
        $html .= $this->generaListaPd();
        $html .= $this->generaListaPs();

        echo $html;

    }
    
    public function generaListaEst() : string
    {
        // Listado de estudiantes.
        
        // Formulario de creación de un estudiante.
        $formEstAdminCreate = new FormEstAdminCreate();
        $formEstAdminCreateModal = $formEstAdminCreate->generateModal();
        $formEstAdminCreateButton = $formEstAdminCreate->generateButton('Crear', null, true);
        
        // Formulario de visualización de un estudiante.
        $formEstAdminRead = new FormEstAdminRead();
        $formEstAdminReadModal = $formEstAdminRead->generateModal();

        // Formulario de modificación de un estudiante
        $formEstAdminUpdate = new FormEstAdminUpdate();
        $formEstAdminUpdateModal = $formEstAdminUpdate->generateModal();
    
        // Formulario de eliminacion de un estudiante
        $formEstAdminDelete = new FormEstAdminDelete();
        $formEstAdminDeleteModal = $formEstAdminDelete->generateModal();

        $listaEstBuffer = '';

        if (! empty($this->listadoEst)) {
            foreach ($this->listadoEst as $u) {
                $uniqueId = $u->getId();
                $nif = $u->getNif();
                $nombreCompleto = $u->getNombreCompleto();

                // TODO botón ver en el nombre
                $formEstAdminReadButton = $formEstAdminRead->generateButton('Ver', $uniqueId, true);
                $formEstAdminUpdateButton = $formEstAdminUpdate->generateButton('Editar', $uniqueId, true);
                $formEstAdminDeleteButton = $formEstAdminDelete->generateButton('Eliminar', $uniqueId, true);

                $listaEstBuffer .= <<< HTML
                <tr data-unique-id="$uniqueId">
                    <td scope="row" data-col-name="nif">$nif</td>
                    <td data-col-name="nombre-completo">$nombreCompleto</td>
                    <td>$formEstAdminReadButton $formEstAdminUpdateButton $formEstAdminDeleteButton</td>
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

        $html = <<< HTML
        <h3 class="mb-4">$formEstAdminCreateButton Estudiantes</h3>
        <table id="usuario-est-lista" class="table table-borderless table-striped">
            <thead>
                <tr>
                    <th scope="col">NIF o NIE</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                $listaEstBuffer
            </tbody>
        </table>
        $formEstAdminCreateModal
        $formEstAdminReadModal
        $formEstAdminUpdateModal
        $formEstAdminDeleteModal
        HTML;

        return $html;
    }

    public function generaListaPd() : string
    {
        // Listado de personal docente.

        // Formulario de creación de personal docente.
        $formPDAdminCreate = new FormPDAdminCreate();
        $formPDAdminCreateModal = $formPDAdminCreate->generateModal();
        $formPDAdminCreateButton = $formPDAdminCreate->generateButton('Crear', null, true);

        // Formulario de visualización de un estudiante.
        $formPDAdminRead = new FormPDAdminRead();
        $formPDAdminReadModal = $formPDAdminRead->generateModal();

        //Formulario de modificación de un estudiante
        //$formPDAdminUpdate = new FormPDAdminUpdate();
        //$formPDAdminUpdateModal = $formPdAdminUpdate->generateModal();

        $listaPdBuffer = '';

        if (! empty($this->listadoPd)) {
            foreach ($this->listadoPd as $u) {
                $uniqueId = $u->getId();
                $nif = $u->getNif();
                $nombre = $u->getNombreCompleto();

                // TODO botón ver en el nombre
                // TODO botones ver, editar y eliminar
                //$viewButton = $formEstAdminView->generateButton(null, $u->getId(), true);
                
                $formPDAdminReadButton = $formPDAdminRead->generateButton('Ver', $uniqueId, true);

                $listaPdBuffer .= <<< HTML
                <tr data-unique-id="$uniqueId">
                    <td scope="row"  data-col-name="nif">$nif</td>
                    <td data-col-name="nombre-completo">$nombre</td>
                    <td>$formPDAdminReadButton</td>
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

        $html = <<< HTML
        <h3 class="mb-4 mt-5">$formPDAdminCreateButton Personal docente</h3>
        <table id="usuario-pd-lista" class="table table-borderless table-striped">
            <thead>
                <tr>
                    <th scope="col">NIF o NIE</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                $listaPdBuffer
            </tbody>
        </table>
        $formPDAdminCreateModal
        $formPDAdminReadModal
        HTML;

        return $html;
    }

    public function generaListaPs() : string
    {
        // Listado de personal docente.

        // Formulario de creación de personal docente.
        $formPSAdminCreate = new FormPSAdminCreate();
        $formPSAdminCreateModal = $formPSAdminCreate->generateModal();
        $formPSAdminCreateButton = $formPSAdminCreate->generateButton('Crear', null, true);

        $listaPsBuffer = '';

        if (! empty($this->listadoPs)) {
            foreach ($this->listadoPs as $u) {
                $nif = $u->getNif();
                $nombre = $u->getNombreCompleto();

                // TODO botón ver en el nombre
                // TODO botones ver, editar y eliminar
                //$viewButton = $formEstAdminView->generateButton(null, $u->getId(), true);

                $listaPsBuffer .= <<< HTML
                <tr>
                    <td scope="row">$nif</td>
                    <td>$nombre</td>
                    <td>...</td>
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

        $html = <<< HTML
        <h3 class="mb-4 mt-5">$formPSAdminCreateButton Personal de Secretaría</h3>
        <table id="usuario-ps-lista" class="table table-borderless table-striped">
            <thead>
                <tr>
                    <th scope="col">NIF o NIE</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                $listaPsBuffer
            </tbody>
        </table>
        $formPSAdminCreateModal
        HTML;

        return $html;
    }
}

?>