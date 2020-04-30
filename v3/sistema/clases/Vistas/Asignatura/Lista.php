<?php 

/**
 * Vista de asignaturas.
 *
 * - PAS: puede editar todas las asignaturas.
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

use Awsw\Gesi\Vistas\Modelo;
use Awsw\Gesi\Datos\Asignatura;
use Awsw\Gesi\Sesion;

class Lista extends Modelo
{
	private const VISTA_NOMBRE = "Asignaturas";
	private const VISTA_ID = "asignaturas-lista";

	private $listado;
	private $curso;

	public function __construct()
	{
		$this->nombre = self::VISTA_NOMBRE;
		$this->id = self::VISTA_ID;

	
		$usuario_rol = Sesion::getUsuarioEnSesion()->getRol();
		
		
		if($usuario_rol == 3){
			$this->curso = "Todas las Asignaturas";
			$this->listado = Asignatura::dbGetAll();
			
		}else if($usuario_rol == 1){

			$usuario_curso = Sesion::getUsuarioEnSesion()->getGrupo();
			$this->curso = $usuario_curso;
			$this->listado = Asignatura::dbGetAsigCurso($usuario_curso);
		}else{
			$this->listado = null;
		}
		
	}

	public function procesaAntesDeLaCabecera(): void
	{
		Sesion::requerirSesionPs();
	}

	public function procesaContent() : void 
	{

		// Comprobar si hay alguna asignatura.
		if (! empty($this->listado)) {

			$lista = <<< HTML
						<div id="asignatura-lista">

HTML;

			foreach($this->listado as $m){
				$nombre_largo = $m->getNombreLargo();
				
			
				$lista .= <<< HTML
							<div class="asignatura-curso">
								<header>
									<p class="from">
										<strong>$this->curso</strong>
									</p>
								
								</header>

								<section class="content">
									$nombre_largo;
								</section>
							</div>

HTML;

			}

			$lista .= <<< HTML
						</div>

HTML;

		// Si no eres ni estudiante ni personal de secretaria
		} else {

			$lista = <<< HTML
						<p>Inicia sesion para ver las asignaturas.</p>

HTML;

		}

		$html = <<< HTML
					<header class="page-header">
						<h1>Asignaturas </h1>
					</header>
			
					<section class="page-content">
						<p>A continuación se muestra una lista con las asignaturas.</p>

						$lista
					</section>

HTML;

		echo $html;

	}
}

?>