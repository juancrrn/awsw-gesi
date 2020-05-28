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

use Awsw\Gesi\FormulariosAjax\Asignatura\AsignaturaPsCreate as FormAsignaturaCreate;

class AsignaturaPsList extends Modelo
{
	private const VISTA_NOMBRE = "Administrar asignaturas";
	private const VISTA_ID = "asignatura-admin-lista";

	private $listado;

	public function __construct()
	{	
		Sesion::requerirSesionPs();

		$this->nombre = self::VISTA_NOMBRE;
		$this->id = self::VISTA_ID;

		$this->listado = Asignatura::dbGetAll();
	}

	public function procesaContent() : void 
	{
		$app = App::getSingleton();

		$formAsignaturaCreate = new FormAsignaturaCreate();
		$formAsignaturaCreateModal = $formAsignaturaCreate->generateModal();

		$html = <<< HTML
		<h2 class="mb-4">$this->nombre</h2>
		HTML;

		$listaAsignaturaBuffer = '';

		if (! empty($this->listado)) {
			foreach ($this->listado as $a) {
				$uniqueId= $a->getId();
				$corto = $a->getNombreCorto();
				$nivel = $a->getNivel();
				$curso = $a->getCursoEscolar();
				$largo = $a->getNombreCompleto();

				//TODO boton ver en el nombre

				$listaAsignaturaBuffer .= <<< HTML
					<tr data-unique-id="$uniqueId">
						<td scope="row" data-col-name="nombre-corto">$corto</td>
						<td data-col-name="nivel">$nivel</td>
						<td data-col-name="curso">$curso</td>
						<td data-col-name="nombre-completo">$largo</td>
					</tr>
				HTML;
			}

		}else{
			$listaAsignaturaBuffer .= <<< HTML
            <tr>
                <td></td>
                <td>No se han encontrado Asignaturas.</td>
                <td></td>
            </tr>
            HTML;
		}

		$formAsignaturaCreateButton = $formAsignaturaCreate->generateButton('Crear', null, true);

		$html = <<< HTML
			<h3 class="mb-4">$formAsignaturaCreateButton Asignaturas</h3>
			<table id="asignaturas-lista" class="table table-borderless table-striped">
				<thead>
					<tr>
						<th scope="col"></th>
						<th scope="col">Nivel</th>
						<th scope="col">Curso</th>
						<th scope="col">Nombre</th>
						<th scope="col" class="text-right">Acciones</th>
					</tr>
				</thead>
				<tbody>
					$listaAsignaturaBuffer
				</tbody>
			</table>
			$formAsignaturaCreateModal
		HTML;

		echo $html;
	}
}

?>