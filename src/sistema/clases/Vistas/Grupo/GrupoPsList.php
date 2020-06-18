<?php 

namespace Awsw\Gesi\Vistas\Grupo;

use Awsw\Gesi\Vistas\Modelo;
use Awsw\Gesi\Datos\Grupo;

use Awsw\Gesi\FormulariosAjax\Grupo\GrupoPsCreate as FormGrupoPsCreate;
use Awsw\Gesi\FormulariosAjax\Grupo\GrupoPsUpdate as FormGrupoPsUpdate;
use Awsw\Gesi\FormulariosAjax\Grupo\GrupoPsRead as FormGrupoPsRead;
use Awsw\Gesi\FormulariosAjax\Grupo\GrupoPsDelete as FormGrupoPsDelete;

use Awsw\Gesi\Sesion;

/**
 * Vista de gestión de grupos.
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

class GrupoPsList extends Modelo
{

    public const VISTA_NOMBRE = "Gestionar grupos";
        public const VISTA_ID = "grupo-list";

        private $listado;

        public function __construct()
        {
            Sesion::requerirSesionPs();

            $this->nombre = self::VISTA_NOMBRE;
            $this->id = self::VISTA_ID;

            $this->listadoGrupo = Grupo::dbGetAll();
        }

        public function procesaContent(): void
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
            //Create grupo
            $formGrupoPsCreate = new FormGrupoPsCreate();
            $formGrupoPsCreateModal = $formGrupoPsCreate->generateModal();

            //Editar grupo

            $formGrupoPsUpdate = new FormGrupoPsUpdate();
            $formGrupoPsUpdateModal = $formGrupoPsUpdate->generateModal();
            //Read grupo

            $formGrupoPsRead = new FormGrupoPsRead();
            $formGrupoPsReadModal = $formGrupoPsRead->generateModal();


            //Delete grupo

            $formGrupoPsDelete = new FormGrupoPsDelete();
            $formGrupoPsDeleteModal = $formGrupoPsDelete->generateModal();

            $listaGrupoBuffer = '';

            if(! empty($this->listadoGrupo)){
                foreach($this->listadoGrupo as $u){
                    $uniqueId = $u->getId();
                    $nivel = $u->getNivel();
                  //  $curso_escolar = $u->getCursoEscolarRaw();
                   // $nombre_corto = $u->getNombreCorto();
                    $nombre_completo = $u->getNombreCompleto();
                  //  $tutor = $u->getTutor();

                    $formGrupoReadButton = $formGrupoPsRead->generateButton('Ver',$uniqueId,true);
                    $formGrupoUpdateButton = $formGrupoPsUpdate->generateButton('Editar',$uniqueId,true);
                    $formGrupoDeleteButton = $formGrupoPsDelete->generateButton('Eliminar', $uniqueId,true);

                    $listaGrupoBuffer .= <<< HTML
                    <tr data-unique-id="$uniqueId">
                        <td scope="row" data-col-name="nif">$nivel</td>
                        <td data-col-name="nombre-completo">$nombre_completo</td>
                        <td class="text-right">$formGrupoReadButton $formGrupoUpdateButton $formGrupoDeleteButton</td>
                    </tr>
                    HTML;
                }


            } else{
                $listaGrupoBuffer .= <<< HTML
                <tr>
                    <td></td>
                    <td>No se han encontrado grupos.</td>
                    <td></td>
                </tr>
                HTML;
                }
            

            $formGrupoPsCreateButton = $formGrupoPsCreate->generateButton('Crear',null,true);
            $html = <<< HTML
            <h3 class="mb-4">$formGrupoPsCreateButton</h3>
            <table id="grupo-lista" class="table table-borderless table-striped">
            <thead>
                <tr>
                    <th scope="col">Nivel</th>
                    <th scope="col">Nombre Curso</th>
                    <th scope="col" class="text-right">Acciones</th>
                </tr>
            </thead>
            <tbody>
                $listaGrupoBuffer
            </tbody>
            
            </table>
            $formGrupoPsCreateModal
            $formGrupoPsReadModal
            $formGrupoPsUpdateModal
            $formGrupoPsDeleteModal
            HTML;

            return $html;
        }
}
    















 ?>