<?php

/**
 * Métodos relacionados con los eventos.
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

class Evento
{
	// Identificador único de evento
	private $id;

	// Fecha del evento
	private $fecha;

	// Nombre del evento
	private $nombre;

	//Descripcion del evento
	private $descripcion;

	// Lugar donde se va a producir el evento
	private $lugar;

	//Si el evento pertenece a un grupo, su id. NULL en otro caso.
	private $asignatura;

	// Si el evento pertenece a un profesor, a un grupo y a una asignatura a la vez, el id de la relación. NULL en otro caso.
	private $asignacion; 

	/**
	 * Constructor.
	 */
	private function __construct($id, $fecha, $nombre, $descripcion, $lugar, $asignatura, $asignacion)
	{
		$this->id = $id;
		$this->fecha = $fecha;
		$this->nombre = $nombre;
		$this->descripcion = $descripcion;
		$this->lugar = $lugar;
		$this->asigatura = $asignatura;
		$this->asignacion = $asignacion;
	}

	private static function fromMysqlFetch(Object $o) :Evento
    {
        return new self(
			$o->id,
			$o->fecha,
			$o->nombree,
			$o->descripcion,
			$o->lugar,
			$o->asigatura,
			$o->asignacion
		);
		
    }

	public static function dbInsertar(): int {
		
		$bbdd = App::getSingleton()->bbddCon();
		
		$sentencia = $bbdd->prepare("
			INSERT
			INTO
				gesi_eventos
				(
					fecha,
					nombre,
					descripcion,
					lugar,
					asignatura,
					asignacion
				)
			VALUES
				(?, ?, ?, ?, ?, ?)
		");

		$fecha = $this->getFecha();
		$nombre = $this->getNombre();
		$descripcion = $this->getDescripcion();
		$lugar = $this->getLugar();
		$asignatura = $this->getAsignatura();
		$asignacion = $this->getAsignacion();
		
		$sentencia->bind_param(
			"isssii", 
			$fecha,
			$nombre,
			$descripcion,
			$lugar,
			$asignatura,
			$asignacion
		);

		$sentencia->execute();
		
		$id_insertado = $bbdd->insert_id;

		$this->id = $id_insertado;

		$sentencia->close();

		return $id_insertado;
	}

	public function getId(){
		return $this->id;
	}

	public function getFecha(){
		return $this->fecha;
	}
	
	public function getNombre(){
		return $this->nombre;
	}
	
	public function getLugar(){
		return $this->lugar;
	}
	
	public function getAsignatura(){
		return $this->asignatura;
	}
	
	public function getAsignacion(){
		return $this->asignacion;
	}

	public function getDescripcion(){
		return $this->descripcion;
	}

	public static function dbActualizar(): bool{
	
		$bbdd = App::getSingleton()->bbddCon();

		$sentencia = $bbdd->prepare("
			UPDATE
				gesi_eventos
			SET
				fecha = ?,
				nombre = ?,
				descripcion = ?,
				lugar = ?,
				asignatura, = ?
				asignacion = ?
			WHERE
				id = ?
		");

		$id= $this->getId();
		$fecha= $this->getFecha();
		$nombre= $this->getNombre();
		$descripcion = $this->getDescripcion();
		$lugar= $this->getLugar();
		$asignatura= $this->getAsignatura();
		$asignacion= $this->getAsignacion();

		$sentencia->bind_param(
			"iisssii", 
			$id,
			$fecha,
			$nombre,
			$descripcion,
			$lugar,
			$asignatura,
			$asignacion
		);

		$resultado = $sentencia->execute();

		$sentencia->close();

		return $resultado;
	}

	/**
	 * Trae todos los eventos de la base de datos.
	 *
	 * @requires Existe al menos un evento en la base de datos.
	 *
	 * @return array<Evento>
	 */
	public static function dbGetAll() : array
	{
		$bbdd = App::getSingleton()->bbddCon();
	
		$sentencia = $bbdd->prepare("
			SELECT 
				id,
				fecha,
				nombre,
				descripcion,
				lugar,
				asignatura,
				asignacion
			FROM
				gesi_eventos
		");

		$sentencia->execute();
		$sentencia->store_result();

		$sentencia->bind_result(
			$result_id,
			$result_fecha,
			$result_nombre,
			$result_descripcion,
			$result_lugar,
			$result_asignatura,
			$result_asignacion
		);
		
		$eventos = null;

		while($sentencia->fetch()) {
			$eventos[] = new Evento(
				$result_id,
				$result_fecha,
				$result_nombre,
				$result_descripcion,
				$result_lugar,
				$result_asignatura,
				$result_asignacion
			);
		}
		
		$sentencia->close();
	
		return $eventos;
	

	}
	






	 public static function dbGet(int $id) : self
    {

        $bbdd = App::getSingleton()->bbddCon();

        $sentencia = $bbdd->prepare("
            SELECT 
				id,
				fecha,
				nombre,
				descripcion,
				lugar,
				asignatura,
				asignacion
            FROM
                gesi_eventos
            WHERE
                id = ?
            LIMIT 1
        ");

        $sentencia->bind_param(
            "i",
            $id
        );

        $sentencia->execute();

        $resultado = $sentencia->get_result();

        $evento = self::fromMysqlFetch($resultado->fetch_object());

        $sentencia->close();

        return $evento;
	}
	
	public static function dbExisteId(int $id): bool
    {        
        $bbdd = App::getSingleton()->bbddCon();

        $sentencia = $bbdd->prepare("
            SELECT
                id
            FROM
                gesi_eventos
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

        if ($sentencia->num_rows > 0) {
            $existe = true;
        } else {
            $existe = false;
        }

        $sentencia->close();

        return $existe;
	}
	

	public static function dbEliminar(int $id): bool
    {
        $bbdd = App::getSingleton()->bbddCon();

        $sentencia = $bbdd->prepare("
            DELETE
            FROM
                gesi_eventos
            WHERE
                id = ?
        ");

        $sentencia->bind_param(
            "i",
            $id
        );

        $resultado = $sentencia->execute();

        $sentencia->close();

        return $resultado;
    }
}