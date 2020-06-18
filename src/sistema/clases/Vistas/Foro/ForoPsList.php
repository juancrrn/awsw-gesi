<?php

namespace Awsw\Gesi\Vistas\Foro;

use Awsw\Gesi\Sesion;
use Awsw\Gesi\Vistas\Modelo;
use Awsw\Gesi\Datos\Foro;
use Awsw\Gesi\FormulariosAjax\Foro\ForoPsCreate;
use Awsw\Gesi\FormulariosAjax\Foro\ForoPsRead;
use Awsw\Gesi\FormulariosAjax\Foro\ForoPsUpdate;
use Awsw\Gesi\FormulariosAjax\Foro\ForoPsDelete;

/**
 * Vista de gestión de foros.
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

class ForoPsList extends Modelo
{
    public const VISTA_NOMBRE = "Gestionar foros";
    public const VISTA_ID = "foro-ps-list";

    private $listado;

    public function __construct()
    {
        Sesion::requerirSesionPs();

        $this->nombre = self::VISTA_NOMBRE;
        $this->id = self::VISTA_ID;

        $this->listado = Foro::dbGetAll();
    }

    public function procesaContent(): void
    {   
        // Create foro.
        $formCreate = new ForoPsCreate();
        $formCreateModal = $formCreate->generateModal();

        // Read foro.
        $formRead = new ForoPsRead();
        $formReadModal = $formRead->generateModal();

        //Update foro.
        $formUpdate = new ForoPsUpdate();
        $formUpdateModal = $formUpdate->generateModal();

        // Delete foro.
        $formDelete = new ForoPsDelete();
        $formDeleteModal = $formDelete->generateModal();

        $listaForos = $this->generaListaForos($formRead, $formUpdate, $formDelete);

        $formCreateBtn = $formCreate->generateButton('Crear', null, true);
        
        $html = <<< HTML
        <h2 class="mb-4">$formCreateBtn $this->nombre</h2>
        <p>A continuación se muestra una lista con los foros disponibles.</p>
        <table id="foro-ps-list" class="table table-borderless table-striped">
            <thead>
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col" class="text-right">Acciones</th>
                </tr>
            </thead>
            <tbody>
                $listaForos
            </tbody>
        </table>
        $formCreateModal
        $formReadModal
        $formUpdateModal
        $formDeleteModal
        HTML;

        echo $html;

    }

    public function generaListaForos(ForoPsRead $formRead, ForoPsUpdate $formUpdate, ForoPsDelete $formDelete): string
    {
        $buffer = '';

        if (! empty($this->listado)) {
            foreach ($this->listado as $foro) {
                $uniqueId = $foro->getId();

                $nombre = $foro->getNombre();

                $formReadBtn = $formRead
                    ->generateButton('Ver', $foro->getId(), true);
                $formUpdateBtn = $formUpdate
                    ->generateButton('Editar', $foro->getId(), true);
                $formDeleteBtn = $formDelete
                    ->generateButton('Eliminar', $foro->getId(), true);
                
                $buffer .= <<< HTML
                <tr data-unique-id="$uniqueId">
                    <td data-col-name="foroNombre">$nombre</td>
                    <td class="text-right">$formReadBtn $formUpdateBtn $formDeleteBtn</td>
                </tr>
                HTML;
            }
        } else {
            $buffer .= <<< HTML
            <tr>
                <td></td>
                <td>No se ha encontrado ningun foro.</td>
                <td></td>
                <td></td>
            </tr>
            HTML;
        }

        return $buffer;
    }
}

?>