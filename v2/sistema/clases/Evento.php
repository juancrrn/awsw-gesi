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
	// Identificador único de evento
	private $id;

	// Fecha del evento
	private $fecha;

	// Nombre del evento
	private $nombre;

	// Lugar donde se va a producir el evento
	private $lugar;

	/**
	 * Constructor.
	 */
	private __construct($id, $fecha, $nombre, $lugar)
	{
		$this->id = $id;
		$this->fecha = $fecha;
		$this->nombre = $nombre;
		$this->lugar = $lugar;
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