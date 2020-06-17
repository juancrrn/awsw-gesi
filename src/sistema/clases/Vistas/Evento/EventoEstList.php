<?php 

namespace Awsw\Gesi\Vistas\Evento;

use Awsw\Gesi\Vistas\Modelo;
use Awsw\Gesi\Datos\Evento;
use Awsw\Gesi\Sesion;

use Awsw\Gesi\FormulariosAjax\Evento\EventoRead;



class EventoEstList extends Modelo
{
	public const VISTA_NOMBRE = "Eventos";
	public const VISTA_ID = "evento-lista";

	private $listado;

	public function __construct()
	{	
		Sesion::requerirSesionNoIniciada();
		$this->nombre = self::VISTA_NOMBRE;
		$this->id = self::VISTA_ID;

		$this->listado = Evento::dbGetAll();
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
           
            //Read Evento

		   
			$formEventoRead = new EventoRead();
            $formEventoReadModal = $formEventoRead->generateModal();

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

                    $formEventoReadButton = $formEventoRead->generateButton('Ver',$uniqueId,true);

                    $listaEventoBuffer .= <<< HTML
                    <tr data-unique-id="$uniqueId">
                        <td scope="row" data-col-name="nif">$fecha</td>
                        <td data-col-name="nombre-completo">$nombre</td>
                        <td data-col-name="lugar">$lugar</td>
                        <td class="text-right">$formEventoReadButton</td>
                    </tr>
                    HTML;
                }


            } else{
                $listaEventoBuffer .= <<< HTML
                <tr>
                    <td></td>
                    <td>No se han encontrado Eventos.</td>
                    <td></td>
                </tr>
                HTML;
                }
            

            $formEventoPsCreateButton = $formEventoPsCreate->generateButton('Crear',null,true);
            $html = <<< HTML
            <h3 class="mb-4">$formEventoPsCreateButton</h3>
            <table id="evento-lista" class="table table-borderless table-striped">
            <thead>
                <tr>
                    <th scope="col">Fecha</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Lugar</th>
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