<?php 

/**
 * Vista de asignaturas.
 *
 * - PD: puede ver las asignaturas que tiene asignadas.
 * - Estudiante: puede ver las asignaturas en las que está matriculado.
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
use Awsw\Gesi\Datos\Asignacion;
use Awsw\Gesi\Datos\Asignatura;
use Awsw\Gesi\Vistas\Modelo;
use Awsw\Gesi\Datos\Grupo;
use Awsw\Gesi\Datos\Usuario;
use Awsw\Gesi\Sesion;

class MiLista extends Modelo
{
	private const VISTA_NOMBRE = "Mis asignaturas";
	private const VISTA_ID = "asignatura-mi-lista";

	public function __construct()
	{
		Sesion::requerirSesionNoPs();

		$this->nombre = self::VISTA_NOMBRE;
		$this->id = self::VISTA_ID;
	}

	public function procesaContent() : void 
	{
		$usuario = Sesion::getUsuarioEnSesion();
		
		if ($usuario->isEst()) {
			$html = $this->generaParaEst();
		} elseif ($usuario->isPd()) {
			$html = $this->generaParaPd();
		}

		echo $html;
	}

	public function generaParaEst() : string
	{
		$app = App::getSingleton();

		$usuario = Sesion::getUsuarioEnSesion();

		if ($usuario->getGrupo()) {
			$grupo = Grupo::dbGet($usuario->getGrupo());
			$texto_grupo = 'Estás matriculado en el grupo ' . $grupo->getNombreCompleto() . '. Este grupo tiene asignadas las siguientes asignaturas:';
			$listado = Asignacion::dbGetByGrupo($grupo->getId());
		} else {
			$texto_grupo = 'No tienes ningún grupo asignado.';
			$listado = array();
		}

		$contenido = '';

		if (! empty($listado)) {
			foreach ($listado as $a) {

				$asignatura = Asignatura::dbGet($a->getAsignatura());
				$corto_asignatura = $asignatura->getNombreCorto();
				$completo_asignatura = $asignatura->getNombreCompleto();
				$profesor = Usuario::dbGet($a->getProfesor());
				$nombre_profesor = $profesor->getNombreCompleto();
				$url_ver = $app->getUrl() . '/mi/asignaturas/' . $a->getId() .  '/ver/';

				/**
				 * Próxima versión: funcionalidad de foros
				 * $url_foro_principal = $app->getUrl() . '/mi/foros/' . $a->getForoPrincipal() .  '/ver/';
				 * <div><a href="$url_foro_principal">Ir al foro</a></div>
				 */

				$contenido .= <<< HTML
				<div class="grid-table-row">
					<div><a href="$url_ver">$corto_asignatura</a></div>
					<div><a href="$url_ver">$completo_asignatura</a></div>
					<div>$nombre_profesor</div>
					<div><a href="$url_ver">Ver</a></div>
				</div>

				HTML;
			}
		} else {			
				$contenido .= <<< HTML
				<div class="grid-table-row-empty">
					No se han encontrado asignaturas.
				</div>

				HTML;
		}

		$html = <<< HTML
		<header class="page-header">
			<h1>$this->nombre</h1>
			<p>$texto_grupo</p>
		</header>
		
		<section class="page-content">
			<div id="asignaturas-mi-lista-est" class="grid-table">
				<div class="grid-table-header">
					<div class="grid-table-row">
						<div></div>
						<div>Nombre</div>
						<div>Profesor</div>
						<div></div>
					</div>
				</div>
				<div class="grid-table-body">
					$contenido
				</div>
			</div>
		</section>

		HTML;

		return $html;
	}

	public function generaParaPd() : string
	{
		$app = App::getSingleton();

		$usuario = Sesion::getUsuarioEnSesion();

		$listado = Asignacion::dbGetByProfesor($usuario->getId());

		$contenido = '';

		if (! empty($listado)) {
			foreach ($listado as $a) {

				$asignatura = Asignatura::dbGet($a->getAsignatura());
				$corto_asignatura = $asignatura->getNombreCorto();
				$completo_asignatura = $asignatura->getNombreCompleto();
				$grupo = Grupo::dbGet($a->getGrupo());
				$corto_grupo = $grupo->getNombreCorto();
				$url_ver = $app->getUrl() . '/mi/asignaturas/' . $a->getId() .  '/ver/';

				/**
				 * Próxima versión: funcionalidad de foros
				 * $url_foro_principal = $app->getUrl() . '/mi/foros/' . $a->getForoPrincipal() .  '/ver/';
				 * <div><a href="$url_foro_principal">Ir al foro</a></div>
				 */

				$contenido .= <<< HTML
				<div class="grid-table-row">
					<div><a href="$url_ver">$corto_asignatura</a></div>
					<div><a href="$url_ver">$completo_asignatura</a></div>
					<div>$corto_grupo</div>
					<div><a href="$url_ver">Ver</a></div>
				</div>

				HTML;
			}
		} else {			
				$contenido .= <<< HTML
				<div class="grid-table-row-empty">
					No se han encontrado asignaturas.
				</div>

				HTML;
		}

		$html = <<< HTML
		<header class="page-header">
			<h1>$this->nombre</h1>
			<p>A continuación se muestran las asignaturas que tiene asignadas:</p>
		</header>
		
		<section class="page-content">
			<div id="asignaturas-mi-lista-est" class="grid-table">
				<div class="grid-table-header">
					<div class="grid-table-row">
						<div></div>
						<div>Nombre</div>
						<div>Grupo</div>
						<div></div>
					</div>
				</div>
				<div class="grid-table-body">
					$contenido
				</div>
			</div>
		</section>

		HTML;

		return $html;
	}
}

?>