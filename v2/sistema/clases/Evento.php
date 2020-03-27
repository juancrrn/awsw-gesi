<?php

/**
 * Métodos relacionados con los eventos.
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

class Evento
{
	/**
	 * Constructor.
	 */
	private __construct()
	{
	}

	/**
	 * Trae todos los eventos de la base de datos.
	 *
	 * @requires Existe al menos un evento en la base de datos.
	 *
	 * @return array<Evento>
	 */
	public static dbGetAll()
	{
		return array();
	}
}