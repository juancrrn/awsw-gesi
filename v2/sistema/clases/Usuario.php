<?php

/**
 * Métodos relacionados con los usuarios.
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

class Usuario
{
	/**
	 * Constructor.
	 */
	private __construct()
	{
	}

	/**
	 * Trae un usuario de la base de datos.
	 *
	 * @param int $id
	 *
	 * @requires Existe un usuario con el id especificado.
	 *
	 * @return Usuario
	 */
	public static dbGet(int $id)
	{
		return new Usuario();
	}
}