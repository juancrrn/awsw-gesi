<?php 

/**
 * Vista de grupos.
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
use Awsw\Gesi\Datos\Grupo;
use Awsw\Gesi\Sesion;

class AdminLista extends Modelo
{
	private const VISTA_NOMBRE = "Administrar grupos";
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

		$app = App::getSingleton();

		$html = <<< HTML
		<header class="page-header">
			<h1>$this->nombre</h1>
		</header>
	
		<section class="page-content">
			<div id="grupos-lista" class="grid-table">
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
						foreach ($this->listado as $g) {

							$id = $g->getId();
							$corto = $g->getNombreCorto();
							$nivel = $g->getNivel();
							$curso = $g->getCursoEscolar();
							$completo = $g->getNombreCompleto();

							$url_ver = $app->getUrl() . '/admin/grupos/' . $id . '/ver/';
							$url_editar = $app->getUrl() . '/admin/grupos/' . $id . '/editar/';
							$url_eliminar = $app->getUrl() . '/admin/grupos/' . $id . '/eliminar/';

							$html .= <<< HTML
							<div class="grid-table-row">
								<div><a href="$url_ver">$corto</a></div>
								<div>$nivel</div>
								<div>$curso</div>
								<div><a href="$url_ver">$completo</a></div>
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
								No se han encontrado grupos.
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
		$url_crear = $app->getUrl() . '/admin/grupos/crear/';

		$html = <<< HTML
		<ul>
			<li><a href="$url_crear" class="btn">Nuevo grupo</a></li>
		</ul>

HTML;

		echo $html;

	}
}

?>