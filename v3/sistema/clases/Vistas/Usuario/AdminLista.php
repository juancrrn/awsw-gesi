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

class AdminLista extends Modelo
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

	public function procesaContent() : void
	{

		$app = App::getSingleton();

		$html = <<< HTML
		<header class="page-header">
			<h1>Usuarios</h1>
		</header>
	
		<section class="page-content">
			<div id="usuarios-lista" class="grid-table">
				<div class="grid-table-header">
					<div class="grid-table-row">
						<div>NIF o NIE</div>
						<div>Nombre completo</div>
						<div></div>
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
							$url_ver = $app->getUrl() . '/admin/usuarios/' . $u->getId() . '/ver/';
							$url_editar = $app->getUrl() . '/admin/usuarios/' . $u->getId() . '/editar/';
							$url_eliminar = $app->getUrl() . '/admin/usuarios/' . $u->getId() . '/eliminar/';
							$nombre = $u->getNombreCompleto();

							$html .= <<< HTML
							<div class="grid-table-row">
								<div>$nif</div>
								<div><a href="$url_ver">$nombre</a></div>
								<div>
									<a href="$url_ver">Ver</a>
									<a href="$url_editar">Editar</a>
									<a href="$url_eliminar">Eliminar</a>
								</div>
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

HTML;

		echo $html;

	}

	public function procesaSide(): void
	{

		$app = App::getSingleton();
		$url_crear = $app->getUrl() . '/admin/usuarios/crear/';

		$html = <<< HTML
					<ul>
						<li><a href="$url_crear" class="btn">Nuevo usuario</a></li>
					</ul>

HTML;

		echo $html;

	}
}

?>