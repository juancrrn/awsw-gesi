<?php 

/**
 * Vista de administración de asignaturas.
 *
 * - PS: puede editar todas las asignaturas.
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

namespace Awsw\Gesi\Vistas\Asignatura;

use Awsw\Gesi\App;
use Awsw\Gesi\Vistas\Modelo;
use Awsw\Gesi\Datos\Asignatura;
use Awsw\Gesi\Sesion;

class AdminLista extends Modelo
{
	private const VISTA_NOMBRE = "Administrar asignaturas";
	private const VISTA_ID = "asignatura-admin-lista";

	private $listado;

	public function __construct()
	{
		$this->nombre = self::VISTA_NOMBRE;
		$this->id = self::VISTA_ID;

		$this->listado = Asignatura::dbGetAll();
	}

	public function procesaAntesDeLaCabecera(): void
	{
		Sesion::requerirSesionPs();
	}

	public function procesaContent() : void 
	{
		$app = App::getSingleton();

		$html = <<< HTML
		<header class="page-header">
			<h1>$this->nombre</h1>
		</header>
	
		<section class="page-content">
			<div id="asignaturas-admin-lista" class="grid-table">
				<div class="grid-table-header">
					<div class="grid-table-row">
						<div></div>
						<div>Nivel</div>
						<div>Curso</div>
						<div>Nombre</div>
						<div></div>
					</div>
				</div>
				<div class="grid-table-body">

HTML;
					
					if (! empty($this->listado)) {
						foreach ($this->listado as $a) {

							$id = $a->getId();
							$corto = $a->getNombreCorto();
							$nivel = $a->getNivel();
							$curso = $a->getCursoEscolar();
							$largo = $a->getNombreCompleto();

							$url_ver = $app->getUrl() . '/admin/asignaturas/' . $id . '/ver/';
							$url_editar = $app->getUrl() . '/admin/asignaturas/' . $id . '/editar/';
							$url_eliminar = $app->getUrl() . '/admin/asignaturas/' . $id . '/eliminar/';

							$html .= <<< HTML
							<div class="grid-table-row">
								<div><a href="$url_ver">$corto</a></div>
								<div>$nivel</div>
								<div>$curso</div>
								<div><a href="$url_ver">$largo</a></div>
								<div>
									<a href="$url_ver">Ver</a>
									<a href="$url_editar">Editar</a>
									<a href="$url_eliminar">Eliminar</a>
								</div>
							</div>

HTML;

						}
					} else {
							
							$html .= <<< HTML
							<div class="grid-table-row-empty">
								No se han encontrado asignaturas.
							</div>

HTML;

					}

		$html .= <<< HTML
				</div>
			</div>
		</section>

HTML;

		echo $html;

	}

	public function procesaSide(): void
	{

		$app = App::getSingleton();
		$url_crear = $app->getUrl() . '/admin/asignaturas/crear/';

		$html = <<< HTML
		<ul>
			<li><a href="$url_crear" class="btn">Nueva asignatura</a></li>
		</ul>

		HTML;

		echo $html;

	}
}

?>