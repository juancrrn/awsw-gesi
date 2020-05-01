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

namespace Awsw\Gesi\Vistas\Asignacion;

use Awsw\Gesi\App;
use Awsw\Gesi\Vistas\Modelo;
use Awsw\Gesi\Datos\Asignacion;
use Awsw\Gesi\Datos\Asignatura;
use Awsw\Gesi\Sesion;
use Awsw\Gesi\Datos\Usuario;
use Awsw\Gesi\Datos\Grupo;

class AdminLista extends Modelo
{
	private const VISTA_NOMBRE = "Gestionar Asignaciones";
	private const VISTA_ID = "usuario-admin-lista";

	private $listado;

	public function __construct()
	{
		Sesion::requerirSesionPs();

		$this->nombre = self::VISTA_NOMBRE;
		$this->id = self::VISTA_ID;

		$this->listado = Asignacion::dbGetAll();
	}

	public function procesaContent() : void
	{

		$app = App::getSingleton();
		

		$html = <<< HTML
		<header class="page-header">
			<h1>$this->nombre</h1>
		</header>
	
		<section class="page-content">
			<div id="asignacion-lista" class="grid-table">
				<div class="grid-table-header">
					<div class="grid-table-row">
						<div>Profesor</div>
						<div>Asignatura</div>
						<div></div>
						<div>Grupo</div>
					</div>
				</div>
				<div class="grid-table-body">

HTML;
					
					
					if (! empty($this->listado)) {
						foreach ($this->listado as $u) {
							
							
                            $profesor_id = $u->getProfesor();
						//	$profesor = Usuario::dbGet($profesor_id);
						//	$pr_nombre =$profesor->getNombreCompleto();

							$asignatura_id = $u->getAsignatura();
						//	$asignatura =Asignatura::dbGet($asignatura_id);
						//	$asignatura_nombre = $asignatura->getNombreCompleto();
							
							$url_ver = $app->getUrl() . '/admin/asignaciones/' . $u->getId() . '/ver/';
							$url_editar = $app->getUrl() . '/admin/asignaciones/' . $u->getId() . '/editar/';
							$url_eliminar = $app->getUrl() . '/admin/asignaciones/' . $u->getId() . '/eliminar/';
                            $asignatura = $u->getAsignatura();
							$grupo = Grupo::dbGet($u->getGrupo())->getNombreCompleto();

							$html .= <<< HTML
							<div class="grid-table-row">
								<div>$asignatura_id</div>
								<div>$profesor_id</div>
								<div>
									<a href="$url_ver">Ver</a>
									<a href="$url_editar">Editar</a>
									<a href="$url_eliminar">Eliminar</a>
								</div>
								<div>$grupo</div>
							</div>

HTML;

						
					}
					} else {
							
							$html .= <<< HTML
							<div class="grid-table-row-empty">
								No se han encontrado asignaciones.
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
		$url_crear = $app->getUrl() . '/admin/asignaciones/crear/';

		$html = <<< HTML
					<ul>
						<li><a href="$url_crear" class="btn">Nueva Asignación</a></li>
					</ul>

HTML;

		echo $html;

	}
}

?>