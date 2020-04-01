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
	// Identificador único del foro
	private $id;

	// Tema a tratar en el foro
	private $tema;

	// Identificador de la relación profesor-grupo-asignatura del foro. Si es NULL, el foro es público
	private $profesor_grupo_asignatura;


	/**
	 * Constructor.
	 */
	private function __construct($id, $tema, $profesor_grupo_asignatura)
	{
		$this->id = $id;
		$this->tema = $tema;
		$this->profesor_grupo_asignatura = $profesor_grupo_asignatura;
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
	public static function dbGet(int $id)
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
	public static function dbGetMessages()
	{
		return array();
	}
}