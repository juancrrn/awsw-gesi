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
 * @version 0.0.4
 */

namespace Awsw\Gesi\Datos;

use Awsw\Gesi\App;
use Awsw\Gesi\Validacion\Valido;
use JsonSerializable;
use stdClass;

class Evento
    implements DAO, JsonSerializable
{
    /**
     * @var $id          Identificador único de evento
     * @var $fecha       Fecha del evento
     * @var $nombre      Nombre del evento
     * @var $descripcion Descripcion del evento
     * @var $lugar       Lugar donde se va a producir el evento
     */
    private $id;
    private $fecha;
    private $nombre;
    private $descripcion;
    private $lugar;

    /**
     * Constructor.
     */
    public function __construct($id, $fecha, $nombre, $descripcion, $lugar)
    {   
        var_dump($fecha);

        $this->id = $id;
        $this->fecha = $fecha;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->lugar = $lugar;
    }

    /**
     * Construye un nuevo objeto de la clase a partir de un objeto resultado
     * de una consulta de MySQL.
     * 
     * @param stdClass $o Objeto resultado de la consulta MySQL.
     * 
     * @return self Objeto de la clase construido.
     */
    public static function fromMysqlFetch(stdClass $o): self
    {
        $fecha = \DateTime::createFromFormat(
            Valido::MYSQL_DATETIME_FORMAT, $o->fecha)
                ->format(Valido::ESP_DATE_FORMAT);
                
        return new self(
            $o->id,
            $fecha,
            $o->nombre,
            $o->descripcion,
            $o->lugar
        );
        
    }

    /*
     *
     * Getters.
     * 
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
            'ssss', 
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

    /*
     *
     * Operaciones SELECT.
     *  
     */

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

        $query = <<< SQL
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
        $sentencia->bind_param('i', $id);
        $sentencia->execute();
        $resultado = $sentencia->get_result();
        $evento = self::fromMysqlFetch($resultado->fetch_object());
        $sentencia->close();

        return $evento;
    }
    
    /**
     * Comprueba si existe el evento id en la base de datos.
     * 
     * @param int $id
     * 
     * @return bool
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
        $sentencia->bind_param('i', $id);
        $sentencia->execute();
        $sentencia->store_result();
        $existe = $sentencia->num_rows > 0;
        $sentencia->close();

        return $existe;
    }

    /**
     * Comprueba si un evento se puede eliminar, es decir, que no está 
     * referenciado como clave ajena en otra tabla.
     * 
     * @requires      El evento existe.
     * 
     * @param int $id Identificador del evento.
     * 
     * @return array  En caso de haberlas, devuelve un array con los nombres de 
     *                las tablas donde hay referencias al evento. Si no 
     *                   las hay, devuelve un array vacío.
     */
    public static function dbCompruebaRestricciones(int $id): array
    {
        return array();
    }

    /*
     *
     * Operaciones UPDATE.
     *  
     */

    /**
     * Actualiza un evento en la base de datos.
     * 
     * @param self $this
     * 
     * @return bool
     */
    public function dbActualizar(): bool
    {
    
        $bbdd = App::getSingleton()->bbddCon();

        $query = <<<SQL
        UPDATE
            gesi_eventos
        SET
            fecha = ?,
            nombre = ?,
            descripcion = ?,
            lugar = ?
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
            'issss', 
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

    /*
     *
     * Operaciones DELETE.
     *  
     */
    
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

    public function jsonSerialize()
    {
        return [
            'uniqueId' => $this->getId(),
            'fecha' => $this->getFecha(),
            'nombre' => $this->getNombre(),
            'descripcion' => $this->getDescripcion(),
            'lugar' => $this->getLugar(),
            'checkbox' => $this->getId()
        ];
    }
}