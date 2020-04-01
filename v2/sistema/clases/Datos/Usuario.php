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

namespace Awsw\Gesi\Datos;

use Awsw\Gesi\App;

class Usuario
{
	
	private $id;
	private $nif;
	private $rol;
	private $nombre;
	private $apellidos;
	private $password;
	private $fecha_nacimiento;
	private $numero_telefono;
	private $email;
	private $fecha_ultimo_acceso; // Al principio se inicializa como fecha de registro
	private $fecha_registro;
	private $grupo;

	/**
	 * Constructor.
	 */
	private function __construct(
		$id,
		$nif,
		$rol,
		$nombre,
		$apellidos,
		$password,
		$fecha_nacimiento,
		$numero_telefono,
		$email,
		$fecha_ultimo_acceso,
		$fecha_registro,
		$grupo
	)
	{
		$this->id = $id;
		$this->nif = $nif;
		$this->rol = $rol;
		$this->nombre = $nombre;
		$this->apellidos = $apellidos;
		$this->password = $password;
		$this->fecha_nacimiento = $fecha_nacimiento;
		$this->numero_telefono = $numero_telefono;
		$this->email = $email;
		$this->fecha_ultimo_acceso = $fecha_registro;
		$this->fecha_registro = $fecha_registro;
		$this->grupo = $grupo;
	}

	/*
	 *
	 * Getters.
	 *  
	 */

	public function getId() : int
	{
		return $this->id;
	}
	
	public function getNif() : string
	{
		return $this->nif;
	}	
	
	public function getRol() : int
	{
		return $this->rol;
	}	
	
	public function getNombre() : string
	{
		return $this->nombre;
	}

	public function getApellidos() : string
	{
		return $this->apellidos;
	}

	public function getPassword() : string
	{
		return $this->password;
	}

	public function getFechaNacimiento() : int
	{
		return $this->fecha_nacimiento;
	}
	
	public function getNumeroTelefono() : int
	{
		return $this->numero_telefono;
	}

	public function getEmail() : string
	{
		return $this->email;
	}

	public function getFechaUltimoAcceso() : int
	{
		return $this->fecha_ultimo_acceso;
	}

	public function getFechaRegistro() : int
	{
		return $this->fecha_registro;	
	}
	
	public function getGrupo() : int
	{
		return $this->grupo;
	}

	/*
	 *
	 * 
	 * Funciones de acceso a la base de datos (patrón de acceso a datos).
	 * 
	 * 
	 */

	/*
	 *
	 * Operaciones INSERT.
	 *  
	 */
	
	/**
	 * Inserta un nuevo usuario en la base de datos.
	 * 
	 * @param Usuario $this Usuario a insertar.
	 * 
	 * @requires Restricciones de la base de datos.
	 * 
	 * @return int Identificador del usuario insertado.
	 */
	public function dbInsertar() : int
	{
		$bbdd = App::getSingleton()->bbddCon();
		
		$sentencia = $bbdd->prepare("
			INSERT
			INTO
				gesi_usuarios
				(
					nif,
					rol,
					nombre,
					apellidos,
					password,
					fecha_nacimiento,
					numero_telefono,
					email,
					fecha_ultimo_acceso,
					fecha_registro,
					grupo
				)
			VALUES
				(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
		");

		$nif = $this->getNif();
		$rol = $this->getRol();
		$nombre = $this->getNombre();
		$apellidos = $this->getApellidos();
		$password = $this->getPassword();
		$fecha_nacimiento = $this->getFechaNacimiento();
		$numero_telefono = $this->getNumero();
		$email = $this->getEmail();
		$fecha_ultimo_acceso = $this->getFechaUltimo();
		$fecha_registro = $this->getFechaRegistro();
		$grupo = $this->getGrupo();
		
		$sentencia->bind_param(
			"sisssiisiii", 
			$nif,
			$rol,
			$nombre,
			$apellidos,
			$password,
			$fecha_nacimiento,
			$numero_telefono,
			$email,
			$fecha_ultimo_acceso,
			$fecha_registro,
			$grupo
		);

		$sentencia->execute();
		
		$id_insertado = $bbdd->insert_id;

		$sentencia->close();

		$this->id = $id_insertado;

		return $this->id;
	}

	/*
	 *
	 * Operaciones SELECT.
	 *  
	 */

	/**
	 * Trae un usuario de la base de datos.
	 *
	 * @param int $id
	 *
	 * @requires Existe un usuario con el id especificado.
	 *
	 * @return Usuario
	 */
	public static function dbGet(int $id) : Usuario
	{
		$bbdd = App::getSingleton()->bbddCon();

		$sentencia = $bbdd->prepare("
			SELECT 
				id,
				nif,
				rol,
				nombre,
				apellidos,
				password,
				fecha_nacimiento,
				numero_telefono,
				email,
				fecha_ultimo_acceso,
				fecha_registro,
				grupo
			FROM
				gesi_usuarios
			WHERE
				id = ?
			LIMIT 1
		");
		$sentencia->bind_param(
			"i",
			$id
		);
		
		$sentencia->execute();
		$sentencia->store_result();

		$sentencia->bind_result(
			$result_id,
			$result_nif,
			$result_rol,
			$result_nombre,
			$result_apellidos,
			$result_password,
			$result_fecha_nacimiento,
			$result_numero_telefono,
			$result_email,
			$result_fecha_ultimo_acceso,
			$result_fecha_registro,
			$result_grupo
		);
		
		$usuario = null;

		while($sentencia->fetch()) {
			$usuario = new Usuario(
				$result_id,
				$result_nif,
				$result_rol,
				$result_nombre,
				$result_apellidos,
				$result_password,
				$result_fecha_nacimiento,
				$result_numero_telefono,
				$result_email,
				$result_fecha_ultimo_acceso,
				$result_fecha_registro,
				$result_grupo
			);
		}
		
		$sentencia->close();

		return $usuario;
	}

	/**
	 * Busca el identificador de un usuario en base a su NIF o NIE.
	 *
	 * @param string $nif
	 *
	 * @requires Existe un usuario con el NIF o NIE especificado.
	 *
	 * @return int
	 */
	public static function dbGetIdDesdeNif(string $nif) : int
	{
		$bbdd = App::getSingleton()->bbddCon();

		$sentencia = $bbdd->prepare("
			SELECT id
			FROM gesi_usuarios
			WHERE nif = ?
			LIMIT 1
		");
		$sentencia->bind_param(
			"s",
			$nif
		);
		
		$sentencia->execute();
		$sentencia->store_result();

		$sentencia->bind_result(
			$result_id
		);
		
		$id = null;

		while($sentencia->fetch()) {
			$id = $result_id;
		}
		
		$sentencia->close();

		return $id;
	}

	/**
	 * Comprueba si un usuario existe en la base de datos en base a su
	 * identificador.
	 *
	 * @param int
	 *
	 * @return bool
	 */

	public static function dbExisteId(int $id) : bool
	{		
		$bbdd = App::getSingleton()->bbddCon();

		$sentencia = $bbdd->prepare("
			SELECT id
			FROM gesi_usuarios
			WHERE id = ?
			LIMIT 1
		");
		$sentencia->bind_param(
			"i",
			$id
		);
		
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
	 * Comprueba si un usuario existe en la base de datos en base a su
	 * NIF o NIE.
	 *
	 * @param string $nif
	 *
	 * @return bool
	 */

	public static function dbExisteNif(string $nif) : bool
	{		
		$bbdd = App::getSingleton()->bbddCon();

		$sentencia = $bbdd->prepare("
			SELECT id
			FROM gesi_usuarios
			WHERE nif = ?
			LIMIT 1
		");

		$sentencia->bind_param(
			"s",
			$nif
		);
		
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

	/*
	 *
	 * Operaciones UPDATE.
	 *  
	 */

	/**
	 * Actualiza la información de un usuario en la base de datos.
	 * 
	 * @param Usuario $this El usuario cuya información se va a actualizar.
	 * 
	 * @return bool Resultado de la ejecución de la sentencia.
	 */
	public static function dbActualizar() : bool
	{
		$bbdd = App::getSingleton()->bbddCon();

		$sentencia = $bbdd->prepare("
			UPDATE
				gesi_usuarios
			SET
				nif = ?,
				rol = ?,
				nombre = ?,
				apellidos = ?,
				password = ?,
				fecha_nacimiento = ?,
				numero_telefono = ?,
				email = ?,
				fecha_ultimo_acceso = ?,
				fecha_registro = ?,
				grupo = ?
			WHERE
				id = ?
		");

		$id = $this->getId();
		$nif = $this->getNif();
		$rol = $this->getRol();
		$nombre = $this->getNombre();
		$apellidos = $this->getApellidos();
		$password = $this->getPassword();
		$fecha_nacimiento = $this->getFechaNacimiento();
		$numero_telefono = $this->getNumero();
		$email = $this->getEmail();
		$fecha_ultimo_acceso = $this->getFechaUltimo();
		$fecha_registro = $this->getFechaRegistro();
		$grupo = $this->getGrupo();

		$sentencia->bind_param(
			"sisssiisiiii", 
			$nif,
			$rol,
			$nombre,
			$apellidos,
			$password,
			$fecha_nacimiento,
			$numero_telefono,
			$email,
			$fecha_ultimo_acceso,
			$fecha_registro,
			$grupo,
			$id
		);

		$resultado = $sentencia->execute();

		$sentencia->close();

		return $resultado;
	}
	
}