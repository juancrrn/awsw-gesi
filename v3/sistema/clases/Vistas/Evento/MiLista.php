<?php 

/**
 * Vistas de calendario.
 *
 * - PDI: puede editar todos los calendarios.
 * - PD: puede editar los calendarios de sus asignaturas.
 * - Estudiantes: pueden ver el calendario de sus asignaturas.
 * - Resto: pueden ver el calendario público.
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

use Awsw\Gesi\Vistas\Modelo;

class MiLista extends Modelo
{
	private const VISTA_NOMBRE = "Eventos";
	private const VISTA_ID = "evento-lista";

	private $listado;

	public function __construct()
	{
		$this->nombre = self::VISTA_NOMBRE;
		$this->id = self::VISTA_ID;

		$this->listado = array(); // TODO: recuperar el listado de eventos (calendario)
	}

	public function procesaContent() : void
	{

		?>
		<header class="page-header">
			<h1>Eventos</h1>
		</header>

		<section class="page-content">
			Esta vista aún no está implementada.
					<?php
// var_dump($this->listado);

					?>
		</section>
		<?php

	}
}

?>