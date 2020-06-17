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

    /**
     * Constructor.
     */
    private function __construct($id, $fecha, $nombre, $descripcion, $lugar)
    {
        $this->id = $id;
        $this->fecha = $fecha;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->lugar = $lugar;
    }

    private static function fromMysqlFetch(Object $o) :Evento
    {
        return new self(
            $o->id,
            $o->fecha,
            $o->nombre,
            $o->descripcion,
            $o->lugar
        );
        
    }

    /**
     * GETTERS
     */
    
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

    /**
     * Inserta un nuevo evento en la base de datos
     * 
     * @param Evento $this Evento a insertar
     * 
     * @requires Restricciones de la base de datos
     * 
     * @return int Identificador del evento insertado en la base de datos
     */
    public function dbInsertar(): int {
        
        $bbdd = App::getSingleton()->bbddCon();
        
        $query = <<<SQL
        INSERT
        INTO
            gesi_eventos
            (
                fecha,
                nombre,
                descripcion,
                lugar
            )
        VALUES
            (?, ?, ?, ?)
        SQL;

        $sentencia = $bbdd->prepare($query);

        $fecha = $this->getFecha();
        $nombre = $this->getNombre();
        $descripcion = $this->getDescripcion();
        $lugar = $this->getLugar();
        
        $sentencia->bind_param(
            "isss", 
            $fecha,
            $nombre,
            $descripcion,
            $lugar
        );

        $sentencia->execute();
        
        $id_insertado = $bbdd->insert_id;

        $this->id = $id_insertado;

        $sentencia->close();

        return $id_insertado;
    }

    public function dbActualizar(): bool{
    
        $bbdd = App::getSingleton()->bbddCon();

        $query = <<<SQL
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
        SQL;

        $sentencia = $bbdd->prepare($query);

        $id= $this->getId();
        $fecha= $this->getFecha();
        $nombre= $this->getNombre();
        $descripcion = $this->getDescripcion();
        $lugar= $this->getLugar();

        $sentencia->bind_param(
            "iisss", 
            $id,
            $fecha,
            $nombre,
            $descripcion,
            $lugar
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
    
        $query = <<< SQL
            SELECT 
                id,
                fecha,
                nombre,
                descripcion,
                lugar
            FROM
                gesi_eventos
        SQL;

        $sentencia = $bbdd->prepare($query);
        $sentencia->execute();
        $resultado = $sentencia->get_result();
        $eventos = array();

        while($a = $resultado->fetch_object()){
            $eventos[] = Evento::fromMysqlFetch($a);
        }

        $sentencia->close();
    
        return $eventos;

    }
    
    /**
     * Trae un evento de la base de datos.
     *
     * @param int $id
     * 
     * @requires existe un evento con el id especificado en la base de datos
     *
     * @return array<Evento>
     */
     public static function dbGet(int $id) : self
    {

        $bbdd = App::getSingleton()->bbddCon();

        $query = <<<SQL
        SELECT 
            id,
            fecha,
            nombre,
            descripcion,
            lugar
        FROM
            gesi_eventos
        WHERE
            id = ?
        LIMIT 1
        SQL;

        $sentencia = $bbdd->prepare($query);
        $sentencia->bind_param("i", $id );
        $sentencia->execute();
        $resultado = $sentencia->get_result();
        $evento = self::fromMysqlFetch($resultado->fetch_object());
        $sentencia->close();

        return $evento;
    }
    
    /**
     * Comprueba si existe el evento id en el la base de datos
     */
    public static function dbExisteId(int $id): bool
    {        
        $bbdd = App::getSingleton()->bbddCon();

        $query = <<<SQL
        SELECT
            id
        FROM
            gesi_eventos
        WHERE
            id = ?
        LIMIT 1
        SQL;

        $sentencia = $bbdd->prepare($query);
        $sentencia->execute($query);
        $sentencia->bind_param(
            "i",
            $id
        );
        
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
     * Elimina un evento de la base de datos.
     *
     * @requires El evento id existe en la base de datos.
     *
     * @return array<Evento>
     */
    public static function dbEliminar(int $id): bool
    {
        $bbdd = App::getSingleton()->bbddCon();

        $query = <<<SQL
        DELETE
        FROM
            gesi_eventos
        WHERE
            id = ?
        SQL;

        $sentencia = $bbdd->prepare($query);
        $sentencia->bind_param( "i", $id);
        $resultado = $sentencia->execute();

        $sentencia->close();

        return $resultado;
    }
}