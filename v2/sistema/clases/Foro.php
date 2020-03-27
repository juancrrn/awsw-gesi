<?php

/**
 * Métodos relacionados con los foros.
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

class Foro
{
	/**
	 * Constructor.
	 */
	private __construct()
	{
	}

	/**
	 * Trae un foro de la base de datos.
	 *
	 * @param int $id
	 *
	 * @requires Existe un foro con el id especificado.
	 *
	 * @return Foro
	 */
	public static dbGet(int $id)
	{
		return new Foro();
	}

	/**
	 * Trae todos los mensajes de un foro de la base de datos.
	 *
	 * @param int $this->id
	 *
	 * @requires Existe algun mensaje en el foro especificado.
	 *
	 * @return array<MensajeForo>
	 */
	public dbGetMessages()
	{
		return array();
	}
}