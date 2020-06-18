<?php 

namespace Awsw\Gesi\Vistas\Evento;

use Awsw\Gesi\Vistas\Modelo;
use Awsw\Gesi\Datos\Evento;

use Awsw\Gesi\FormulariosAjax\Evento\EventoPsCreate as FormEventoPsCreate;
use Awsw\Gesi\FormulariosAjax\Evento\EventoPsUpdate as FormEventoPsUpdate;
use Awsw\Gesi\FormulariosAjax\Evento\EventoPsRead as FormEventoPsRead;
use Awsw\Gesi\FormulariosAjax\Evento\EventoPsDelete as FormEventoPsDelete;

use Awsw\Gesi\Sesion;

/**
 * Vista de gestión de eventos.
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

class EventoPsList extends Modelo
{

    public const VISTA_NOMBRE = "Gestionar eventos";
        public const VISTA_ID = "evento-ps-list";

        private $listadoEvento;

        public function __construct($api = false)
        {
            Sesion::requerirSesionPs($api);

            $this->nombre = self::VISTA_NOMBRE;
            $this->id = self::VISTA_ID;

            $this->listadoEvento= Evento::dbGetAll();
        }

        public function procesaContent(): void
        {
            $html = <<< HTML
            <h2 class="mb-4">$this->nombre</h2>
            HTML;

            $html .= $this->generarListaEventos();

            echo $html;
        }

        /**
         * Genera el listado de Eventos.
         * 
         * @return string Listado de Eventos.
         */
        public function generarListaEventos(): string
        {
            //Create Evento
            $formEventoPsCreate = new FormEventoPsCreate();
            $formEventoPsCreateModal = $formEventoPsCreate->generateModal();

            //Editar Evento

            $formEventoPsUpdate = new FormEventoPsUpdate();
            $formEventoPsUpdateModal = $formEventoPsUpdate->generateModal();
            //Read Evento

            $formEventoPsRead = new FormEventoPsRead();
            $formEventoPsReadModal = $formEventoPsRead->generateModal();


            //Delete Evento

            $formEventoPsDelete = new FormEventoPsDelete();
            $formEventoPsDeleteModal = $formEventoPsDelete->generateModal();

            $listaEventoBuffer = '';

            if(! empty($this->listadoEvento)){
             
                foreach($this->listadoEvento as $u){
                    
                    $uniqueId = $u->getId();
                    $fecha = $u->getfecha();
                    $nombre = $u->getNombre();
                    $lugar = $u->getLugar();

                    $descripcion = $u->getDescripcion();

                    $formEventoReadButton = $formEventoPsRead->generateButton('Ver',$uniqueId,true);
                    $formEventoUpdateButton = $formEventoPsUpdate->generateButton('Editar',$uniqueId,true);
                    $formEventoDeleteButton = $formEventoPsDelete->generateButton('Eliminar', $uniqueId,true);

                    $listaEventoBuffer .= <<< HTML
                    <tr data-unique-id="$uniqueId">
                        <td scope="row" data-col-name="nif">$fecha</td>
                        <td data-col-name="nombre-completo">$nombre</td>
                        <td data-col-name="lugar">$lugar</td>
                        <td data-col-name="descripcion">$descripcion</td>
                        <td class="text-right">$formEventoReadButton $formEventoUpdateButton $formEventoDeleteButton</td>
                    </tr>
                    HTML;
                }


            } else{
                $listaEventoBuffer .= <<< HTML
                <tr>
                    <td></td>
                    <td>No se han encontrado Eventos.</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                HTML;
                }
            

            $formEventoPsCreateButton = $formEventoPsCreate->generateButton('Crear',null,true);
            $html = <<< HTML
            <h3 class="mb-4">$formEventoPsCreateButton</h3>
            <table id="evento-ps-lista" class="table table-borderless table-striped">
            <thead>
                <tr>
                    <th scope="col">Fecha</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Lugar</th>
                    <th scope="col">Descripcion</th>
                    <th scope="col" class="text-right">Acciones</th>
                </tr>
            </thead>
            <tbody>
                $listaEventoBuffer
            </tbody>
            
            </table>
            $formEventoPsCreateModal
            $formEventoPsReadModal
            $formEventoPsUpdateModal
            $formEventoPsDeleteModal
            HTML;

            return $html;
        }
}
    















 ?>