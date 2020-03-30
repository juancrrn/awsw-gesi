<?php

/**
 * Métodos relacionados con los mensajes de foros.
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

class MensajeForo
{
	// Identificador único de un mensaje en el foro
	private $id;

	// Foro al que pertenece el mensaje
	private $foro;

	// Mensaje al que responde, NULL si es el original
	private $padre;

	/**
	 * Constructor.
	 */
	private function __construct($id, $foro, $padre)
	{
		$this->id = $id;
		$this->foro = $foro;
		$this->padre = $padre;
	}
}