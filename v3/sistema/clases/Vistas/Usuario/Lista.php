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

namespace Awsw\Gesi\Vistas\Usuario;

use Awsw\Gesi\App;
use Awsw\Gesi\Vistas\Modelo;
use Awsw\Gesi\Datos\Usuario;
use \Awsw\Gesi\Sesion;

class Lista extends Modelo
{
	private const VISTA_NOMBRE = "Usuarios";
	private const VISTA_ID = "usuario-lista";

	private $listado;

	public function __construct()
	{
		$this->nombre = self::VISTA_NOMBRE;
		$this->id = self::VISTA_ID;

		$this->listado = Usuario::dbGetAll();
	}

	public function procesaAntesDeLaCabecera() : void
	{
		Sesion::requerirSesionPs();
	}

	public function procesa() : void
	{

		$app = App::getSingleton();
		$url_crear = $app->getUrl() . '/usuarios/crear/';

		$html = <<< HTML
		<div class="wrapper">
			<div class="container">
				<header class="page-header">
					<h1>Usuarios</h1>
				</header>
				
				<section class="page-content">
					<a href="url_crear" class="btn">Nuevo usuario</a>
					<p>A continuación se muestra una lista con los Usuarios de la Base de Datos.</p>
		
					<div id="usuarios-lista" class="grid-table">
						<div class="grid-table-header">
							<div class="grid-table-row">
								<div>NIF o NIE</div>
								<div>Nombre completo</div>
								<div>Roles</div>
							</div>
						</div>
						<div class="grid-table-body">

HTML;
					
					if (! empty($this->listado)) {
						foreach ($this->listado as $u) {

							$badges = '';
							$badges .= $u->isEst() ? '<span class="badge">Estudiante</span>' : '';
							$badges .= $u->isPd() ? '<span class="badge">Personal docente</span>' : '';
							$badges .= $u->isPs() ? '<span class="badge">Personal de Secretaría</span>' : '';

							$nif = $u->getNif();
							$url_editar = $app->getUrl() . '/usuarios/' . $u->getId() . '/editar/';
							$nombre = $u->getNombreCompleto();

							$html .= <<< HTML
							<div class="grid-table-row">
								<div>$nif</div>
								<div><a href="$url_editar">$nombre</a></div>
								<div>$badges</div>
							</div>

HTML;

						}
					} else {
							
							$html .= <<< HTML
							<div class="grid-table-row-empty">
								No se han encontrado usuarios.
							</div>

HTML;

					}

		$html .= <<< HTML
						</div>
					</div>
				</section>
			</div>
		</div>

HTML;

		echo $html;

	}
}

?>