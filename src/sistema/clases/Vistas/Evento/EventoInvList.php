<?php 

namespace Awsw\Gesi\Vistas\Evento;

use Awsw\Gesi\Vistas\Modelo;
use Awsw\Gesi\Datos\Evento;
use Awsw\Gesi\Sesion;


class EventoInvList extends Modelo
{
	public const VISTA_NOMBRE = "Ver Eventos";
	public const VISTA_ID = "evento-inv-list";

	private $listado;

	public function __construct($api = false)
	{
       //Sesion::requerirNoPs($api);
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
            $listaEventoBuffer = '';

            if(! empty($this->listado)){
             
                foreach($this->listado as $u){
                    
                    $uniqueId = $u->getId();
                    $fecha = $u->getfecha();
                  //  $curso_escolar = $u->getCursoEscolarRaw();
                   // $nombre_corto = $u->getNombreCorto();
                    $nombre = $u->getNombre();
                    $descripcion = $u->getDescripcion();
                  //  $tutor = $u->getTutor();
                    $lugar = $u->getLugar();

                    $listaEventoBuffer .= <<< HTML
                    <tr data-unique-id="$uniqueId">
                        <td scope="row" data-col-name="nif">$fecha</td>
                        <td data-col-name="nombre-completo">$nombre</td>
                        <td data-col-name="descripcion">$descripcion</td>
                        <td data-col-name="lugar">$lugar</td>
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
            
            $html = <<< HTML
            <h3 class="mb-4"></h3>
            <table id="evento-lista" class="table table-borderless table-striped">
            <thead>
                <tr>
                    <th scope="col">Fecha</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Descripcion</th>
                    <th scope="col">Lugar</th>
                </tr>
            </thead>
            <tbody>
                $listaEventoBuffer
            </tbody>
            
            </table>
            HTML;

            return $html;
        }
}

?>