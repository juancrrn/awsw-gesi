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



namespace Awsw\Gesi\Vistas\Grupo;



use Awsw\Gesi\App;
use Awsw\Gesi\Vistas\Modelo;
use Awsw\Gesi\Datos\Usuario;
use Awsw\Gesi\Datos\Grupo;

use Awsw\Gesi\FormulariosAjax\Grupo\GrupoAdminCreate as FormGrupoAdminCreate;

use Awsw\Gesi\Sesion;


class GrupoAdminList extends Modelo{

        private const VISTA_NOMBRE = "Gestionar grupos";
        private const VISTA_ID = "grupo-admin-lista";

        private $listado;

        public function __construct()
        {
            Sesion::requerirSesionPs();

            $this->nombre = self::VISTA_NOMBRE;
            $this->id = self::VISTA_ID;

            $this->listado = Grupo::dbGetAll();
        }

        public function procesaContent() : void
        {
            $html = <<< HTML
            <h2 class="mb-4">$this->nombre</h2>
            HTML;

            $html .= $this->generarListaGrupos();

            echo $html;
        }

        /**
         * Genera el listado de grupos.
         * 
         * @return string Listado de grupos.
         */
        public function generarListaGrupos(): string
        {
            //Formulario de creacion de Grupo
            $formGrupoAdminCreate = new FormGrupoAdminCreate();
            $formGrupoAdminCreateModal = $formGrupoAdminCreate->generateModal();
            $formGrupoAdminCreateButton = $formGrupoAdminCreate->generateButton('Crear', null, true);

            $listaGruposBuffer = '';

            if (! empty($this->listado)) {
                foreach ($this->listado as $g) {

                    $uniqueId = $g->getId();
                    $nombreCorto = $g->getNombreCorto();
                    $nivel = $g->getNivel();
                    $curso = $g->getCursoEscolar();
                    $nombreCompleto = $g->getNombreCompleto();

                    // Botones de editar, etc

                    $listaGruposBuffer .= <<< HTML
                    <tr data-unique-id="$uniqueId">
                        <td scope="row" data-col-name="nombre-corto">$nombreCorto</td>
                        <td data-col-name="nivel">$nivel</td>
                        <td data-col-name="curso">$curso</td>
                        <td data-col-name="nombre-completo">$nombreCompleto</td>
                        <td class="text-right"></td>
                    </tr>
                    HTML;

                }
            } else {
                $listaGruposBuffer .= <<< HTML
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>No se han encontrado grupos.</td>
                    <td></td>
                </tr>
                HTML;
            }

            $html = <<< HTML
            <h3 class="mb-4">$formGrupoAdminCreateButton Grupos</h3>
            <table id="usuario-est-lista" class="table table-borderless table-striped">
                <thead>
                    <tr>
                        <th scope="col">Nombre corto</th>
                        <th scope="col">Nivel</th>
                        <th scope="col">Curso</th>
                        <th scope="col">Nombre completo</th>
                        <th scope="col" class="text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    $listaGruposBuffer
                </tbody>
            </table>
            $formGrupoAdminCreateModal
            HTML;

            return $html;
        }
}
    















 ?>