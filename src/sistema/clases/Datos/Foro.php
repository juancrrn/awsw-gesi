<?php

/**
 * Métodos relacionados con los foros.
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

class Foro
    implements JsonSerializable
{

    /**
     * @var int $id Identificador interno del foro.
     * @var string $nombre Nombre del foro.
     */
    private $id;
    private $nombre;

    /**
     * Constructor.
     */
    public function __construct(
        $id,
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

    public function getId(): int
    {
        return $this->id;
    }

    public function getNombre(): string
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
            'nombre' => $this->getNombre(),
            'checkbox' => $this->getId()
        ];
    }

    /*
     *
     * Operaciones INSERT.
     *  
     */

    public function dbInsertar(): int
    {
        $bbdd = App::getSingleton()->bbddCon();

        $query = <<< SQL
        INSERT
        INTO 
            gesi_foros
            (   
                nombre
            )
        VALUES
            (?)
        SQL;

        $sentencia = $bbdd->prepare($query);
        $nombre = $this->getNombre();
        $sentencia->bind_param('s', $nombre);
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

    public static function dbExisteId($id): bool
    {
        $bbdd = App::getSingleton()->bbddCon();

        $query = <<< SQL
        SELECT id FROM gesi_foros WHERE id = ? LIMIT 1
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
     * Elimina un foro de la base de datos.
     *
     * @param int $id
     *
     */
    public static function dbEliminar($id){

        $bbdd = App::getSingleton()->bbddCon();

        $sentencia = $bbdd->prepare("
            DELETE
            FROM 
                gesi_foros
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

    /**
     * Comprueba si un estudiante tiene permiso para acceder a un foro, es 
     * decir, si pertenece al grupo de la asignación de la que el foro es 
     * principal.
     * 
     * @requires $foroId existe en la base de datos.
     * 
     * @param int $usuarioId
     * @param int $foroId
     * 
     * @return bool
     */
    public static function dbEstTienePermiso(int $usuarioId, int $foroId): bool
    {
        $bbdd = App::getSingleton()->bbddCon();

        $query = <<< SQL
        SELECT
            id
        FROM
            gesi_usuarios as usuario
        INNER JOIN (
                SELECT
                    grupo
                FROM
                    gesi_asignaciones
                WHERE
                    foro_principal = ?
                LIMIT 1
            ) AS asignacion
        ON
            usuario.grupo = asignacion.grupo
        WHERE
            id = ?
        LIMIT 1;
        SQL;

        $sentencia = $bbdd->prepare($query);
        $sentencia->bind_param('ii', $foroId, $usuarioId);
        $sentencia->execute();
        $sentencia->store_result();
        $result = $sentencia->num_rows > 0;
        $sentencia->close();

        return $result;
    }

    /**
     * Comprueba si un profesor tiene permiso para acceder a un foro, es 
     * decir, si existe alguna asignación para él que tiene el foro como 
     * principal.
     * 
     * @requires $foroId existe en la base de datos.
     * 
     * @param int $usuarioId
     * @param int $foroId
     * 
     * @return bool
     */
    public static function dbPdTienePermiso(int $usuarioId, int $foroId): bool
    {
        $bbdd = App::getSingleton()->bbddCon();

        $query = <<< SQL
        SELECT
            id
        FROM
            gesi_asignaciones
        WHERE
            profesor = ?
        AND
            foro_principal = ?
        SQL;

        $sentencia = $bbdd->prepare($query);
        $sentencia->bind_param('ii', $usuarioId, $foroId);
        $sentencia->execute();
        $sentencia->store_result();
        $result = $sentencia->num_rows > 0;
        $sentencia->close();

        return $result;
    }

    /*
     *
     * Operaciones UPDATE.
     *  
     */

    public function dbActualizar(): bool
    {
        $bbdd = App::getSingleton()->bbddCon();

        $sentencia = $bbdd->prepare("
            UPDATE 
                gesi_foros
            SET
                nombre = ?
            WHERE
                id = ?
        ");

        $id = $this->getId();
        $nombre = $this->getNombre();

        $sentencia->bind_param(
            "si",
            $nombre,
            $id
        );

        $resultado = $sentencia->execute();

        $sentencia->close();

        return $resultado;
    }
}

?>