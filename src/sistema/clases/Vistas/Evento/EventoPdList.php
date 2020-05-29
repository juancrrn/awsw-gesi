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



namespace Awsw\Gesi\Vistas\Evento;



use Awsw\Gesi\App;
use Awsw\Gesi\Vistas\Modelo;
use Awsw\Gesi\Datos\Usuario;
use Awsw\Gesi\Datos\Grupo;
use Awsw\Gesi\Datos\Evento;



use Awsw\Gesi\FormulariosAjax\Evento\EventoPdCreate as FormEventoPdCreate;
use Awsw\Gesi\FormulariosAjax\Evento\EventoPdUpdate as FormEventoPdUpdate;
use Awsw\Gesi\FormulariosAjax\Evento\EventoPsRead as FormGrupoPsRead;
use Awsw\Gesi\FormulariosAjax\Evento\EventoPsDelete as FormGrupoPsDelete;

use Awsw\Gesi\Sesion;


class GrupoPsList extends Modelo
{

    public const VISTA_NOMBRE = "Gestionar eventos";
        public const VISTA_ID = "eventos-list";

        private $listado;

        public function __construct()
        {
            Sesion::requerirSesionPd();

            $this->nombre = self::VISTA_NOMBRE;
            $this->id = self::VISTA_ID;

            $IdProfesor = Sesion::getUsuarioEnSesion()->getId();
             
            $this->listadoEvento= Evento::dbGetByProfesor($IdProfesor);
        }

        public function procesaContent() : void
        {
            $html = <<< HTML
            <h2 class="mb-4">$this->nombre</h2>
            HTML;

            $html .= $this->generarListaEventos();

            echo $html;
        }

        /**
         * Genera el listado de grupos.
         * 
         * @return string Listado de grupos.
         */
        public function generarListaEventos(): string
        {
            //Create Evento
            $formEventoPdCreate = new FormEventoPdCreate();
            $formEventoPdCreateModal = $formEventoPdCreate->generateModal();

            //Editar Evento

            $formEventoPdUpdate = new FormEventoPdUpdate();
            $formEventoPdUpdateModal = $formEventoPdUpdate->generateModal();
            //Read Evento

            $formEventoPdRead = new FormEventoPdRead();
            $formEventoPdReadModal = $formEventoPdRead->generateModal();


            //Delete Evento

            $formEventoPdDelete = new FormEventoPdDelete();
            $formEventoPdDeleteModal = $formEventoPdDelete->generateModal();

            $listaEventoBuffer = '';

            if(! empty($this->listadoEvento)){
                $eventos = array();
             
                foreach($this->listadoEvento as $u){
                    
                    $uniqueId = $u->getId();
                    $fecha = $u->getfecha();
                  //  $curso_escolar = $u->getCursoEscolarRaw();
                   // $nombre_corto = $u->getNombreCorto();
                    $nombre = $u->getNombre();
                  //  $tutor = $u->getTutor();
                    $lugar = $u->getLugar();

                    $asignatura = $u->getAsignatura();
                    $asignacion = $u->getAsignacion();

                    $formGrupoReadButton = $formEventoPdRead->generateButton('Ver',$uniqueId,true);
                    $formGrupoUpdateButton = $formEventoPdUpdate->generateButton('Editar',$uniqueId,true);
                    $formGrupoDeleteButton = $formEventoPdDelete->generateButton('Eliminar', $uniqueId,true);

                    $listaEventoBuffer .= <<< HTML
                    <tr data-unique-id="$uniqueId">
                        <td scope="row" data-col-name="nif">$fecha</td>
                        <td data-col-name="nombre-completo">$nombre</td>
                        <td data-col-name="lugar">$lugar</td>
                        <td data-col-name="asignatura">$asignatura</td>
                        <td data-col-name="asignacion">$asignacion</td>
                        <td class="text-right">$formGrupoReadButton $formGrupoUpdateButton $formGrupoDeleteButton</td>
                    </tr>
                    HTML;
                }


            } else{
                $listaEventoBuffer .= <<< HTML
                <tr>
                    <td></td>
                    <td>No se han encontrado grupos.</td>
                    <td></td>
                </tr>
                HTML;
                }
            

            $formEventoPdCreateButton = $formEventoPdCreate->generateButton('Crear',null,true);
            $html = <<< HTML
            <h3 class="mb-4">$formEventoPdCreateButton</h3>
            <table id="grupo-lista" class="table table-borderless table-striped">
            <thead>
                <tr>
                    <th scope="col">Fecha</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Lugar</th>
                    <th scope="col">Asignatura</th>
                    <th scope="col">Asignacion</th>
                    <th scope="col" class="text-right">Acciones</th>
                </tr>
            </thead>
            <tbody>
                $listaEventoBuffer
            </tbody>
            
            </table>
            $formEventoPdCreateModal
            $formEventoPdReadModal
            $formEventoPdUpdateModal
            $formEventoPdDeleteModal
            HTML;

            return $html;
        }
}
    















 ?>