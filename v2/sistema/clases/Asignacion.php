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
	// Asignatura de la asignación.
	private $asignatura_id;

	// Grupo de la asignación.
	private $grupo_id;

	// Profesor de la asignación.
	private $profesor_id;

	/**
	 * Constructor.
	 */
	private __construct()
	{
	}
}