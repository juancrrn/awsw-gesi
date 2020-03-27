<?php

/**
 * Métodos relacionados con los libros.
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

class Libro
{
	/**
	 * Constructor.
	 */
	private __construct()
	{
	}

	/**
	 * Trae todos los ejemplares de un libro de la base de datos.
	 *
	 * @param int $id
	 *
	 * @requires Existe un ejemplar del libro especificado.
	 *
	 * @return array<EjemplarLibro>
	 */
	public static dbGetEjemplares(int $id)
	{
		return array();
	}
}