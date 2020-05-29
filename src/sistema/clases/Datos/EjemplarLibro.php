<?php

/**
 * Métodos relacionados con los ejemplares de libros.
 *
 * @package awsw-gesi
 * Gesi
 * Aplicación de gestión de institutos de educación secundaria
 *
 * @author Andrés Ramiro Ramiro
 * @author Nicolás Pardina Popp
 * @author Pablo Román Morer Olmos
 * @author Juan Francisco Carrión Molina
 *
 * @version 0.0.4-beta.01
 */

namespace Awsw\Gesi\Datos;

use Awsw\Gesi\App;
use JsonSerializable;

class EjemplarLibro
	implements JsonSerializable
{

	//Identificador del ejemplar en la base de datos
	private $id;

	//Numero de ejemplar en la base de datos
	private $numero;

	//Identificador del libro
	private $libro;

	//Indica si el ejemplar del libro esta prestado o no; Por defecto NULL
	private $prestado;

	//Fecha de alta del prestamo del ejemplar
	private $fecha_alta_prestamo;
	
	//Fecha de expiracion del prestamo del ejemplar
	private $fecha_expiracion_prestamo;
	
	//Indica si el ejemplar del libro esta reservado o no;
	private $reserva;

	//Fecha de alta de la reserva del ejemplar;
	private $fecha_alta_reserva;

	//Fecha de expiracion de la reserva del ejemplar.
	private $fecha_expiracion_reserva;
	
	/**
	 * Constructor.
	 */
	private function __construct(
		$id,
		$numero,
		$libro,
		$prestado,
		$fecha_alta_prestamo,
		$fecha_expiracion_prestamo,
		$reserva,
		$fecha_alta_reserva,
		$fecha_expiracion_reserva
	)
	{
		$this->id = $id;
		$this->numero = $numero;
		$this->libro = $libro;
		$this->prestado = $prestado; //inicialmente a false
		$this->$fecha_alta_prestamo = $fecha_alta_prestamo; //inicialmente a null
		$this->fecha_expiracion_prestamo = $fecha_expiracion_prestamo; //inicialmente a null
		$this->reserva = $reserva;
		$this->fecha_alta_reserva = $fecha_alta_reserva; //inicialmente a null
		$this->fecha_expiracion_reserva = $fecha_expiracion_reserva;
	}

	/**
	 * Inserta un ejemplar usuario en la base de datos.
	 * 
	 * @param EjemplarLibro $this Usuario a insertar.
	 * 
	 * @requires Restricciones de la base de datos.
	 * 
	 * @return int Identificador del ejemplar insertado.
	 */
	public static function dbInsertar(): int {
		
		$bbdd = App::getSingleton()->bbddCon();
		
		$sentencia = $bbdd->prepare("
			INSERT
			INTO
			gesi_ejemplar_libro
				(
					libro,
					numero,
					prestado,
					fecha_alta_prestamo,
					fecha_expiracion_prestamo,
					reserva,
					fecha_alta_reserva,
					fecha_expiracion_reserva
				)
			VALUES
				(?, ?, ?, ?, ?, ?, ?, ?)
		");

		$libro_id = $this->getLibro_id();
		$numero = $this->getNumero();
		$prestado = $this->getPrestado();
		$fecha_alta_prestamo = $this->getFecha_alta_prestado();
		$fecha_expiracion_prestamo = $this->getFecha_expiracion_prestado();
		$reserva = $this->getReserva();
		$fecha_alta_reserva = $this->getFecha_alta_reserva();
		$fecha_expiracion_reserva = $this->getFecha_expiracion_reserva();

		$sentencia->bind_param(
			"iiiiii", 
			$libro_id,
			$numero,
			$prestado,
			$fecha_alta_prestamo,
			$fecha_expiracion_prestamo,
			$fecha_alta_reserva
		);

		$sentencia->execute();
		
		$id_insertado = $bbdd->insert_id;

		$this->id = $id_insertado;

		$sentencia->close();

		return $id_insertado;
	}


	/**
	 * Trae un ejemplar de la base de datos.
	 *
	 * @param int $id
	 *
	 * @requires Existe un ejempalr con el id especificado.
	 *
	 * @return Ejemplar
	 */
	public static function dbGet(int $id) : EjemplarLibro {
		$bbdd = App::getSingleton()->bbddCon();

		$sentencia = $bbdd->prepare("
			SELECT 
				id,
				numero,
				libro_id,
				prestado,
				fecha_alta_prestamo,
				fecha_expiracion_prestamo,
				reserva,
				fecha_alta_reserva,
				fecha_expiracion_reserva
			FROM
			gesi_ejemplar_libro
			WHERE
				id = ?
			LIMIT 1
		");
		
		$sentencia->bind_param(
			"i",
			$id,
		);

		$sentencia->execute();
		$resultado = $sentencia->get_result()->fetch_object();


		$ejemplar = new EjemplarLibro(
			$resultado->id,
			$resultado->numero,
			$resultado->libro_id,
			$resultado->prestado,
			$resultado->fecha_alta_prestamo,
			$resultado->fecha_expiracion_prestamo,
			$resultado->reserva,
			$resultado->fecha_alta_reserva,
			$resultado->fecha_expiracion_reserva
		);
	
		$sentencia->close();

		return $ejemplar;
	}

	public function dbActualizar(): bool{

		$bbdd = App::getSingleton()->bbddCon();

		$sentencia = $bbdd->prepare("
			UPDATE
				gesi_ejemplar_libro
			SET 
				numero = ?,
				libro_id = ?,
				prestado = ?,
				fecha_alta_prestamo = ?,
				fecha_expiracion_prestamo = ?,
				reserva = ?,
				fecha_alta_reserva = ?,
				fecha_expiracion_reserva = ?			
			WHERE
				id = ?
		");

		$id = $this->id;
		$libro_id = $this->getLibro_id();
		$numero = $this->getNumero();
		$prestado = $this->getPrestado();
		$fecha_alta_prestamo = $this->getFecha_alta_prestado();
		$fecha_expiracion_prestamo = $this->getFecha_expiracion_prestado();
		$fecha_alta_reserva = $this->getFecha_alta_reserva();

		$sentencia->bind_param(
			"iiiiii", 
			$id,
			$libro_id,
			$numero,
			$prestado,
			$fecha_alta_prestamo,
			$fecha_expiracion_prestamo,
			$fecha_alta_reserva
		);

		$resultado = $sentencia->execute();

		$sentencia->close();

		return $resultado;
	}

	public function dbGetAll(): array {

		$bbdd = App::getSingleton()->bbddCon();

		$sentencia = $bbdd->prepare(" 
			SELECT 
				id,
				numero,
				libro_id,
				prestado,
				fecha_alta_prestamo,
				fecha_expiracion_prestamo,
				reserva,
				fecha_alta_reserva,
				fecha_expiracion_reserva
			FROM
				gesi_ejemplar_libro
		");
	
		$sentencia->execute();
		$sentencia->store_result();

		$sentencia->bind_result(
			$result_id,
			$result_numero,
			$result_libro_id,
			$result_prestado,
			$result_fecha_alta_prestamo,
			$result_fecha_expiracion_prestamo,
			$result_reserva,
			$result_fecha_alta_reserva,
			$result_fecha_expiracion_reserva
		);

		$ejemplares = array();

		while($sentencia->fetch()) {
			$ejemplares[] = new EjemplarLibro(
				$result_id,
				$result_numero,
				$result_libro_id,
				$result_prestado,
				$result_fecha_alta_prestamo,
				$result_fecha_expiracion_prestamo,
				$result_reserva,
				$result_fecha_alta_reserva,
				$result_fecha_expiracion_reserva
			);	
		}

		$sentencia->close();

		return $ejemplares;	
	}
	
	public function getId(): int{
		return $this->id;
	}
	public function getLibro_id(): int{
		return $this->libro_id;
	}

	public function getNumero(): int{
		return $this->numero;
	}

	public function getPrestado(): int{
		return $this->prestado;
	}

	public function getReserva(): int{
		return $this->reserva;
	}

	public function getFecha_alta_prestado(): int{
		return $this->fecha_alta_prestado;
	}
	public function getFecha_expiracion_prestado(): int{
		return $this->fecha_expiracion_prestado;
	}

	public function getFecha_alta_reserva(): int{
		return $this->fecha_alta_reserva;
	}

	public function getFecha_expiracion_reserva(): int{
		return $this->fecha_expiracion_reserva;
	}

	public function jsonSerialize()
	{
		return [
			'id' => $this->getId(),
			'numero' => $this->getNumero(),
			'libro' => $this->getLibro_id(),
			'prestado' => $this->getPrestado(),
			'fecha_alta_prestamo' => $this->getFecha_alta_prestado(),
			'fecha_expiracion_prestamo' => $this->getFecha_expiracion_prestado(),
			'reserva' => $this->getReserva(),
			'fecha_alta_reserva' => $this->getFecha_alta_reserva(),
			'fecha_expiracion_reserva' => $this->getFecha_expiracion_reserva()
		];
	}

}