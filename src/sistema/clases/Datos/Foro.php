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

namespace Awsw\Gesi\Datos;

use Awsw\Gesi\App;
use JsonSerializable;

class Foro
    implements JsonSerializable
{

    /**
     * @var int $id Identificador interno del foro.
     */
    private $id;

    /**
     * @var string $nombre Nombre del foro.
     */
    private $nombre;

    /**
     * Constructor.
     */
    private function __construct(
        int $id,
        string $nombre
    )
    {
        $this->id = $id;
        $this->nombre = $nombre;
    }

    private static function fromMysqliFetch($o) : self
    {
        return new self(
            $o->id,
            $o->nombre
        );
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function getNombre() : string
    {
        return $this->nombre;
    }

    public function jsonSerialize() 
    {
        $selectName = '(' . $this->getId() . ') ' . $this->getNombre();

        return [
            'uniqueId' => $this->getId(),
            'selectName' => $selectName,
            'id' => $this->getId(),
            'nombre' => $this->getNombre()
        ];
    }

    /*
     *
     * Operaciones INSERT.
     *  
     */

    public function dbInsertar() : int
    {
        $bbdd = App::getSingleton()->bbddCon();

        $query = <<< SQL
        INSERT
        INTO 
            gesi_foros
            (    
                id,
                tema,
                profesor_grupo_asignatura
            )
        VALUES
            (?,?,?)
        SQL;

        $sentencia = $bbdd->prepare($query);
        $id = $this->getId();
        $nombre = $this->getNombre();
        $sentencia->bind_param('is', $id, $nombre);
        $sentencia->execute();
        $id_insertado = $bbdd->insert_id;
        $sentencia->close();

        return $id_insertado;        
    }

    /*
     *
     * Operaciones SELECT.
     *  
     */

    /**
     * Trae todos los foros de la base de datos.
     *
     * @requires Existe algún foro.
     *
     * @return Foro
     */
    public static function dbGetAll() : array
    {
        $bbdd = App::getSingleton()->bbddCon();

        $query = <<< SQL
        SELECT 
            id,
            nombre
        FROM
            gesi_foros
        SQL;

        $sentencia = $bbdd->prepare($query);
        $sentencia->execute();
        $resultado = $sentencia->get_result();
        $foros = array();

        while ($foro = $resultado->fetch_object()) {
            $foros[] = self::fromMysqliFetch($foro);
        }

        $sentencia->close();

        return $foros;
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
    public static function dbGet(int $id) : self
    {

        $bbdd = App::getSingleton()->bbddCon();

        $query = <<< SQL
        SELECT 
            id,
            nombre
        FROM
            gesi_foros
        WHERE
            id = ?
        LIMIT 1
        SQL;

        $sentencia = $bbdd->prepare($query);
        $sentencia->bind_param('i', $id);
        $sentencia->execute();
        $resultado = $sentencia->get_result();
        $foro = self::fromMysqliFetch($resultado->fetch_object());
        $sentencia->close();

        return $foro;
    }

    public static function dbExisteId($id) : bool
    {
        $bbdd = App::getSingleton()->bbddCon();

        $sentencia = $bbdd->prepare("
            SELECT id
            FROM gesi_foros
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

    /*
     *
     * Operaciones UPDATE.
     *  
     */

    public static function dbActualizar() : bool
    {
    
        $bbdd = App::getSingleton()->bbddCon();
    
        $sentencia = $bbdd->prepare("
            UPDATE
                gesi_eventos
            SET
                tema = ?,
                profesor_grupo_asignatura = ?
                FROM
                gesi_foros
            WHERE
                id = ?
        ");
    
        $id= $this->getId();
        $tema = $this->getTema();
        $profesor_grupo_asignatura= $this->getProfesor_grupo_asignatura();
    
        $sentencia->blind_param(
            "isi", 
            $id,
            $tema,
            $profesor_grupo_asignatura
            );
    
        $resultado = $sentencia->execute();
    
        $sentencia->close();
    
        return $resultado;
    }
}

?>