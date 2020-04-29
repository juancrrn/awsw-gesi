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

namespace Awsw\Gesi\Datos;

use Awsw\Gesi\App;

class MensajeSecretaria
{
	// Identificador único del mensaje
	private $id;

	//  Si lo ha enviado un usuario registrado, su identificador
	private $usuario;

	//  Si lo ha enviado un usuario invitado, su nombre
	private $from_nombre;

	// Si lo ha enviado un usuario invitado, su email
	private $from_email;

	//  Si lo ha enviado un usuario invitado, su teléfono
	private $from_telefono;

	// Contenido del mensaje
	private $contenido;

	// Fecha de envio del mensaje
	private $fecha;

	/**
	 * Constructor.
	 */
	public function __construct(
		$id,
		$usuario,
		$from_nombre,
		$from_email,
		$from_telefono,
		$fecha,
		$contenido
	)
	{
		$this->id = $id;
		$this->usuario = $usuario;
		$this->from_nombre = $from_nombre;
		$this->from_email = $from_email;
		$this->from_telefono = $from_telefono;
		$this->fecha = $fecha;
		$this->contenido = $contenido;
	}

	/*
	*
	* Getters.
	*
	*/

	public function getUsuario(){
		return $this->usuario;
	}

	public function getFromNombre(){
		return $this->from_nombre;
	}

	public function getFromEmail(){
		return $this->from_email;
	}

	public function getFromTelefono(){
		return $this->from_telefono;
	}

	public function getFecha(){
		return $this->fecha;
	}

	public function getContenido(){
		return $this->contenido;
	}

	/**
	 * Trae todos los mensajes de Secretaría de la base de datos.
	 *
	 * @requires Existe al menos un mensaje en la base de datos.
	 *
	 * @return array<MensajeSecretaria>
	 */
	public static function dbAny() : bool
	{	
		$bbdd = App::getSingleton()->bbddCon();

		$sentencia = $bbdd->prepare("
			SELECT 
				id
			FROM
				gesi_mensajes_secretaria
		");
		
		$sentencia->execute();
		
		$sentencia->store_result();

		if ($sentencia->num_rows > 0) {
			$existe = true;
		} else {
			$existe = false;
		}

		$sentencia->close();

		return $existe;
	}

	/**
	 * Trae todos los mensajes de Secretaría de la base de datos.
	 *
	 * @requires Existe al menos un mensaje en la base de datos.
	 *
	 * @return array<MensajeSecretaria>
	 */
	public static function dbGetAll() : array
	{	
		$bbdd = App::getSingleton()->bbddCon();

		$sentencia = $bbdd->prepare("
			SELECT 
				id,
				usuario,
				from_nombre,
				from_email,
				from_telefono,
				fecha,
				contenido
			FROM
				gesi_mensajes_secretaria
		");

		$sentencia->execute();
		$sentencia->store_result();

		$sentencia->bind_result(
			$result_id,
			$result_usuario,
			$result_from_nombre,
			$result_from_email,
			$result_from_telefono,
			$result_fecha,
			$result_contenido
		);
		
		$mensajes = null;

		while($sentencia->fetch()) {
			$mensajes[] = new MensajeSecretaria(
				$result_id,
				$result_usuario,
				$result_from_nombre,
				$result_from_email,
				$result_from_telefono,
				$result_fecha,
				$result_contenido
			);
		}
		
		$sentencia->close();

		return $mensajes;
	}

	/**
	 * Inserta un mensaje de Secretaria en la base de datos.
	 *
	 * @param MensajeSecretaria $this MensajeSecretaria a insertar.
	 * 
	 * @requires Restricciones de la Base de Datos.
	 * 
	 * @return int Identificador del MensajeSecretaria insertado.
	 */

	 public function dbInsertar() : bool  {
		$bbdd = App::getSingleton()->bbddCon();
		
		$sentencia = $bbdd->prepare("
			INSERT
			INTO
				gesi_mensajes_secretaria
				(
					usuario,
					from_nombre,
					from_email,
					from_telefono,
					fecha,
					contenido
				)
			VALUES
				(?, ?, ?, ?, ?, ?)
		");

		$usuario = $this->getUsuario();
		$from_nombre = $this->getFromNombre();
		$from_email = $this->getFromEmail();
		$from_telefono = $this->getFromTelefono();
		$fecha = $this->getFecha();
		$contenido = $this->getContenido();

		$sentencia->bind_param(
			"issiis",
			$usuario,
			$from_nombre,
			$from_email,
			$from_telefono,
			$fecha,
			$contenido
		);

		$sentencia->execute();
		
		$id_insertado = $bbdd->insert_id;

		$sentencia->close();

		$this->id = $id_insertado;

		return $id_insertado;
	 }
}