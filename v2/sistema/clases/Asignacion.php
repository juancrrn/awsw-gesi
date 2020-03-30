<?php

/**
 * Métodos relacionados con la relación asignatura-profesor-grupo.
 * Para abreviar, esta relación se denomina "asignación".
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

namespace Awsw\Gesi;

class Asignacion
{
	// Identificador único de la relación.
	private $id;

	// Asignatura de la asignación.
	private $asignatura_id;

	// Grupo de la asignación.
	private $grupo_id;

	// Profesor de la asignación.
	private $profesor_id;

	// Horario en que el profesor imparte la asignatura al grupo.
	private $horario;

	// Foro de recursos de la asignatura para el grupo.
	private $foro_principal;

	/**
	 * Constructor.
	 */
	private function __construct($id, $asignatura_id, $grupo_id, $profesor_id, $horario, $foro_principal)
	{
		$this->id = $id;
		$this->asignatura_id = $asignatura_id;
		$this->grupo_id = $grupo_id;
		$this->profesor_id = $profesor_id;
		$this->hoario = $horario;
		$this->foro_principal = $foro_principal;
	}
}