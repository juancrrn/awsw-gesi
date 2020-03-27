<?php

/**
 * Métodos relacionados con los mensajes de Secretaría.
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

class MensajeSecretaria
{
	/**
	 * Constructor.
	 */
	private __construct()
	{
	}

	/**
	 * Trae todos los mensajes de Secretaría de la base de datos.
	 *
	 * @requires Existe al menos un mensaje en la base de datos.
	 *
	 * @return array<MensajeSecretaria>
	 */
	public static dbGetAll()
	{
		return array();
	}
}