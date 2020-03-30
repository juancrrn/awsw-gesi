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
	// Identificador único del mensaje
	private $id;

	//  Si lo ha enviado un usuario registrado, su identificador
	private $usuario;

	//  Si lo ha enviado un usuario invitado, su nombre
	private $de_nombre;

	// Si lo ha enviado un usuario invitado, su email
	private $de_email;

	//  Si lo ha enviado un usuario invitado, su teléfono
	private $de_telefono;

	// Contenido del mensaje
	private $contenido;

	// Fecha de envio del mensaje
	private $fecha;
	/**
	 * Constructor.
	 */
	private function __construct($id, $usuario, $de_email, $de_nombre, $de_telefono, $contenido, $fecha)
	{
		$this->id = $id;
		$this->usuario = $usuario;
		$this->de_email = $de_email;
		$this->de_nombre = $de_nombre;
		$this->de_telefono = $de_telefono;
	}

	/**
	 * Trae todos los mensajes de Secretaría de la base de datos.
	 *
	 * @requires Existe al menos un mensaje en la base de datos.
	 *
	 * @return array<MensajeSecretaria>
	 */
	public static function dbGetAll()
	{
		return array();
	}
}