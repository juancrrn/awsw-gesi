<?php 

/**
 * TODO: NOMBRE DE LA CLASE
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
 * @version 0.0.4-beta.01
 */

namespace Awsw\Gesi\Vistas\Grupo;

use Awsw\Gesi\Vistas\Modelo;
use Awsw\Gesi\Sesion;
use Awsw\Gesi\App;
use Awsw\Gesi\Datos\Grupo;
use Awsw\Gesi\Datos\Asignatura;
use Awsw\Gesi\Datos\Usuario;
use Awsw\Gesi\Datos\Asignacion;

class MiLista extends Modelo
{
	private const VISTA_NOMBRE = "Grupos asignados";
	private const VISTA_ID = "grupo-mi-lista";

	public function __construct()
	{	
		Sesion::requerirSesionNoPs();

		$this->nombre = self::VISTA_NOMBRE;
		$this->id = self::VISTA_ID;

		$this->listado = Grupo::dbGetAll();
	}

	public function procesaContent(): void 
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

							$url_ver = $app->getUrl() . '/mi/grupos/' . $id . '/ver/';

							$html .= <<< HTML
							<div class="grid-table-row">
								<div><a href="$url_ver">$corto</a></div>
								<div>$nivel</div>
								<div>$curso</div>
								<div><a href="$url_ver">$completo</a></div>
								<div>
									<a href="$url_ver">Ver</a>
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

}

?>