<?php

/**
 * Métodos relacionados con los grupos.
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

use \Awsw\Gesi\App;
use Awsw\Gesi\Formularios\Valido;
use JsonSerializable;
use stdClass;

class Grupo
    implements JsonSerializable
{

    /**
     * @var $id              Identificador único de grupo
     * @var $nivel           Tipo 1 - 6 (desde ESO 1 hasta Bach. 2)
     * @var $curso_escolar   Tipo 2019 (para el curso 2019 - 2020)
     * @var $nombre_corto    Tipo “B1A”
     * @var $nombre_completo Tipo “Primer curso de Bachillerato A”
     * @var $tutor           Profesor responsable del grupo
     */
    private $id;
    private $nivel;
    private $curso_escolar;
    private $nombre_corto;
    private $nombre_completo;
    private $tutor;
    
    /**
     * Constructor.
     */
    public function __construct(
        $id,
        $nivel,
        $curso_escolar,
        $nombre_corto,
        $nombre_completo,
        $tutor
    )
    {
        $this->id = $id;
        $this->nivel = $nivel;
        $this->curso_escolar = $curso_escolar; 
        $this->nombre_corto = $nombre_corto; 
        $this->nombre_completo = $nombre_completo; 
        $this->tutor = $tutor; 
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
        return new self(
            $o->id,
            $o->nivel,
            $o->curso_escolar,
            $o->nombre_corto,
            $o->nombre_completo,
            $o->tutor
        );
    }

    /*
     *
     * Getters.
     * 
     */

    public function getId()
    {
        return $this->id;
    }

    public function getNivel()
    {
        return Valido::rawToNivel($this->nivel);
    }

    public function getNivelRaw()
    {
        return $this->nivel;
    }

    public function getCursoEscolar()
    {
        return Valido::rawToCursoEscolar($this->curso_escolar);
    }

    public function getCursoEscolarRaw()
    {
        return $this->curso_escolar;
    }

    public function getNombreCorto()
    {
        return $this->nombre_corto;
    }

    public function getNombreCompleto()
    {
        return $this->nombre_completo;
    }

    public function getTutor()
    {
        return $this->tutor;
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
     * Inserta un grupo en la base de datos
     * 
     * @param Grupo $this Grupo a insertar
     * 
     * @return int Identificador del grupo insertado
     */
    public function dbInsertar(): int
    {
        $bbdd = App::getSingleton()->bbddCon();

        $query = <<< SQL
        INSERT
        INTO
            gesi_grupos(
                id,
                nivel,
                curso_escolar,
                nombre_corto,
                nombre_completo,
                tutor
            )
        VALUES
            (?, ?, ?, ?, ?, ?)  
        SQL;

        $sentencia = $bbdd->prepare($query);

        $id = $this->getId();
        $nivel = $this->getNivelRaw();
        $curso_escolar = $this->getCursoEscolarRaw();
        $nombre_corto = $this->getNombreCorto();
        $nombre_completo = $this->getNombreCompleto();
        $tutor = $this->getTutor();

        $sentencia->bind_param(
            'iiisss',
            $id,
            $nivel,
            $curso_escolar,
            $nombre_corto,
            $nombre_completo,
            $tutor
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
     * Trae un grupo de la base de datos
     * 
     * @param int $id Identificador del grupo a seleccionar
     * 
     * @return Grupo Grupo seleccionado
     */
    public static function dbGet(int $id): self
    {
        $bbdd = App::getSingleton()->bbddCon();

        $query = <<< SQL
        SELECT 
            id,
            nivel,
            curso_escolar,
            nombre_corto,
            nombre_completo,
            tutor
        FROM
            gesi_grupos
        WHERE
            id = ?
        LIMIT 1
        SQL;

        $sentencia = $bbdd->prepare($query);
        $sentencia->bind_param('i', $id);
        $sentencia->execute();
        $resultado = $sentencia->get_result();
        $grupo = self::fromMysqlFetch($resultado->fetch_object());
        $sentencia->close();

        return $grupo;        
    }

    /**
     * Trae todos los grupos de la base de datos.
     *
     * @return array
     */
    public static function dbGetAll(): array
    {

        $bbdd = App::getSingleton()->bbddCon();

        $query = <<< SQL
        SELECT 
            id,
            nivel,
            curso_escolar,
            nombre_corto,
            nombre_completo,
            tutor
        FROM
            gesi_grupos
        SQL;

        $sentencia = $bbdd->prepare($query);
        $sentencia->execute();
        $resultado = $sentencia->get_result();
        $grupos = array();

        while ($g = $resultado->fetch_object()) {
            $grupos[] = self::fromMysqlFetch($g);
        }

        $sentencia->close();

        return $grupos;    
    }

    /**
     * Trae todos los grupos de la base de datos.
     *
     * @return array<Grupo>
     */
    public static function dbGetGruposId($id): array
    {

        $bbdd = App::getSingleton()->bbddCon();

        $query = <<< SQL
        SELECT 
            id,
            nivel,
            curso_escolar,
            nombre_corto,
            nombre_completo,
            tutor
        FROM
            gesi_grupos
        WHERE
            id = ?
        SQL;

        $sentencia = $bbdd->prepare($query);

        $sentencia->bind_param('i', $id);
    
        $sentencia->execute();
        $resultado = $sentencia->get_result();

        $grupos = array();

        while ($g = $resultado->fetch_object()) {
            $grupos[] = self::fromMysqlFetch($g);
        }

        $sentencia->close();

        return $grupos;    
    }

    /**
     * Comprueba si un grupo existe en la base de datos en base a su
     * identificador.
     *
     * @param int
     *
     * @return bool
     */
    public static function dbExisteId(int $id): bool
    {
        $bbdd = App::getSingleton()->bbddCon();

        $query = <<< SQL
        SELECT
            id
        FROM
            gesi_grupos
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
     * Comprueba si algun grupo tiene como tutor al profesor con
     * identificador id.
     *
     * @param int
     *
     * @return bool
     */
    public static function dbAnyByTutor(int $id): bool
    {
        $bbdd = App::getSingleton()->bbddCon();

        $query = <<< SQL
        SELECT
            id
        FROM
            gesi_grupos
        WHERE
            tutor = ?
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

    /*
     *
     * Operaciones UPDATE.
     *  
     */

    /**
     * Actualiza un grupo en la base de datos.
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
            gesi_grupos
        SET
            id = ?,
            nivel = ?,
            curso_escolar = ?,
            nombre_corto = ?,
            nombre_completo = ?,
            tutor = ?
        WHERE
            id = ?
        SQL;

        $sentencia = $bbdd->prepare($query);

        $id = $this->getId();
        $nivel = $this->getNivelRaw();
        $curso_escolar = $this->getCursoEscolar();
        $nombre_corto = $this->getNombreCorto();
        $nombre_completo = $this->getNombreCompleto();
        $tutor= $this->getTutor();
        
        $sentencia->bind_param(
            'iiisssi',
            $id,
            $nivel,
            $curso_escolar,
            $nombre_corto,
            $nombre_completo,
            $tutor,
            $id
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
     * Elimina un grupo de la base de datos por su id.
     * 
     * @param int $id
     * 
     * @return bool
     */
    public static function dbEliminar(int $id): bool
    {
        $bbdd = App::getSingleton()->bbddCon();

        $query = <<< SQL
        DELETE
        FROM
            gesi_grupos
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
        return [
            'uniqueId' => $this->getId(),
            'selectName' => $this->getNombreCompleto(),
            'id' => $this->getId(),
            'nivel' => $this->getNivel(),
            'cursoEscolar' => $this->getCursoEscolar(),
            'nombreCorto' => $this->getNombreCorto(),
            'nombreCompleto' => $this->getNombreCompleto(),
            'tutor' => $this->getTutor(),
            'checkbox' => $this->getId()
        ];
    }
}

?>