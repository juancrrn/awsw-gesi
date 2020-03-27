<?php

/**
 * Métodos relacionados con los grupos.
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

class Grupo
{
	/**
	 * Constructor.
	 */
	private __construct()
	{
	}

	/**
	 * Trae todos los estudiantes de un grupo.
	 *
	 * @param int $id
	 *
	 * @requires Existe un grupo con el id especificado.
	 *
	 * @return array<Usuario>
	 */
	public static dbGetEstudiantes(int $id)
	{
		return array();
	}
}