<?php

namespace Awsw\Gesi\Datos;

use Awsw\Gesi\App;
use JsonSerializable;

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
 * @version 0.0.4
 */

class Foro
    implements DAO, JsonSerializable
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
    
    /**
     * Construye un nuevo objeto de la clase a partir de un objeto resultado
     * de una consulta de MySQL.
     * 
     * @param stdClass $o Objeto resultado de la consulta MySQL.
     * 
     * @return self Objeto de la clase construido.
     */
    private static function fromMysqliFetch($o): self
    {
        return new self(
            $o->id,
            $o->nombre
        );
    }

    /*
     *
     * Getters.
     * 
     */

    public function getId(): int
    {
        return $this->id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
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
     * Inserta un foro en la base de datos.
     * 
     * @param self $this Foro a insertar.
     * 
     * @return int Id del foro insertado.
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

    /**
     * Comprueba si un foro existe por su id.
     * 
     * @param int $id
     * 
     * @return bool
     */
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

    /**
     * Comprueba si un foro se puede eliminar, es decir, que no está 
     * referenciado como clave ajena en otra tabla.
     * 
     * @requires      El foro existe.
     * 
     * @param int $id Identificador del foro.
     * 
     * @return array  En caso de haberlas, devuelve un array con los nombres de 
     *                las tablas donde hay referencias al foro. Si no 
     *                   las hay, devuelve un array vacío.
     */
    public static function dbCompruebaRestricciones(int $id): array
    {
        $bbdd = App::getSingleton()->bbddCon();

        $restricciones = array();

        $query = <<< SQL
        SELECT id FROM gesi_asignaciones WHERE foro_principal = ? LIMIT 1
        SQL;

        $sentencia = $bbdd->prepare($query);
        $sentencia->bind_param('i', $id);
        $sentencia->execute();
        $sentencia->store_result();
        if ($sentencia->num_rows > 0)
            $restricciones[] = 'asignacion (foro principal)';
        $sentencia->close();

        $query = <<< SQL
        SELECT id FROM gesi_mensajes_foros WHERE foro = ? LIMIT 1
        SQL;

        $sentencia = $bbdd->prepare($query);
        $sentencia->bind_param('i', $id);
        $sentencia->execute();
        $sentencia->store_result();
        if ($sentencia->num_rows > 0)
            $restricciones[] = 'mensajes de foros (foro)';
        $sentencia->close();
        
        return $restricciones;
    }

    /*
     *
     * Operaciones UPDATE.
     *  
     */

    /**
     * Actualiza un foro en la base de datos.
     * 
     * @param self $this
     * 
     * @return bool
     */
    public function dbActualizar(): bool
    {
        $bbdd = App::getSingleton()->bbddCon();

        $query = <<< SQL
        UPDATE 
            gesi_foros
        SET
            nombre = ?
        WHERE
            id = ?
        SQL;

        $sentencia = $bbdd->prepare($query);
        $id = $this->getId();
        $nombre = $this->getNombre();
        $sentencia->bind_param('si', $nombre, $id);
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
     * Elimina un foro de la base de datos.
     *
     * @param int $id
     */
    public static function dbEliminar(int $id): bool
    {

        $bbdd = App::getSingleton()->bbddCon();

        $query = <<< SQL
        DELETE
        FROM 
            gesi_foros
        WHERE
            id = ?
        SQL;

        $sentencia = $bbdd->prepare($query);
        $sentencia->bind_param('i', $id);
        $resultado = $sentencia->execute();
        $sentencia->close();

        return $resultado;
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
}

?>