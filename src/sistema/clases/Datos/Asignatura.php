<?php

/**
 * Métodos relacionados con las asignaturas.
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

class Asignatura
    implements DAO, JsonSerializable
{

    private $id;
    private $nivel;
    private $curso_escolar;
    private $nombre_corto;
    private $nombre_completo;

    /**
     * Constructor.
     */
    public function __construct(
        $id,
        $nivel,
        $curso_escolar,
        $nombre_corto,
        $nombre_completo
    )
    {
        $this->id = $id;
        $this->nivel = $nivel;
        $this->curso_escolar = $curso_escolar;
        $this->nombre_corto = $nombre_corto;
        $this->nombre_completo = $nombre_completo;
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
            $o->nombre_completo
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
     * Insertar una nueva Asignatura en la base de datos
     * 
     * @param Asignatura $this
     * 
     * @return int
     */
    public function dbInsertar(): int
    {
        $bbdd = App::getSingleton()->bbddCon();
        
        $query = <<< SQL
        INSERT
        INTO
            gesi_asignaturas(
                id,
                nivel,
                curso_escolar,
                nombre_corto,
                nombre_completo
            )
        VALUES
            (?, ?, ?, ?, ?)    
        SQL;

        $sentencia = $bbdd->prepare($query);

        $id = $this->getId();
        $nivel = $this->getNivelRaw();
        $curso_escolar = $this->getCursoEscolarRaw();
        $nombre_corto = $this->getNombreCorto();
        $nombre_completo = $this->getNombreCompleto();

        $sentencia->bind_param(
            'iiiss',
            $id,
            $nivel,
            $curso_escolar,
            $nombre_corto,
            $nombre_completo,
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
     * Comprueba si una asignatura existe en la base de datos en base a su
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
            gesi_asignaturas
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
     * Seleccionar todas las asignaturas de la base de datos.
     * 
     * @return array<Asignatura>
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
            nombre_completo
        FROM
            gesi_asignaturas
        SQL;

        $sentencia = $bbdd->prepare($query);
        $sentencia->execute();
        $resultado = $sentencia->get_result();
        $asignaturas = array();

        while ($a = $resultado->fetch_object()) {
            $asignaturas[] = Asignatura::fromMysqlFetch($a);
        }

        $sentencia->close();

        return $asignaturas;    
    }

    /**
     * Trae las asignaturas de un curso escolar específico.
     * 
     * @param int $curso escolar
     * 
     * @return array<Asignatura>
     */
    public static function dbGetByCursoEscolar(int $curso_escolar): array
    {
        $bbdd = App::getSingleton()->bbddCon();

        $query = <<< SQL
        SELECT 
            id,
            nivel,
            curso_escolar,
            nombre_corto,
            nombre_completo
        FROM
            gesi_asignaturas        
        WHERE
            curso_escolar = ?
        SQL;

        $sentencia = $bbdd->prepare($query);
        $sentencia->bind_param('i', $curso_escolar);
        $sentencia->execute();
        $resultado = $sentencia->get_result();
        $asignaturas = array();

        while ($a = $resultado->fetch_object()) {
            $asignaturas[] = Asignatura::fromMysqlFetch($a);
        }

        $sentencia->close();

        return $asignaturas;    
    }

    /** 
     * Trae una asignatura de la base de datos.
     *
     * @param int $id
     *
     * @requires Existe una asignatura con el id especificado.
     *
     * @return Asignatura
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
            nombre_completo
        FROM
            gesi_asignaturas
        WHERE
            id = ?
        LIMIT 1
        SQL;

        $sentencia = $bbdd->prepare($query);
        $sentencia->bind_param('i', $id);
        $sentencia->execute();
        $resultado = $sentencia->get_result();
        $asignatura = Asignatura::fromMysqlFetch($resultado->fetch_object());
        $sentencia->close();
        
        return $asignatura;
    }

    /**
     * Comprueba si una asignatura se puede eliminar, es decir, que no está 
     * referenciado como clave ajena en otra tabla.
     * 
     * @requires      La asignatura existe.
     * 
     * @param int $id Identificador de la asignatura.
     * 
     * @return array  En caso de haberlas, devuelve un array con los nombres de 
     *                las tablas donde hay referencias a la asignatura. Si no 
     *                   las hay, devuelve un array vacío.
     */
    public static function dbCompruebaRestricciones(int $id): array
    {
        $bbdd = App::getSingleton()->bbddCon();

        $restricciones = array();

        // gesi_mensajes_secretaria.usuario

        $query = <<< SQL
        SELECT id FROM gesi_mensajes_secretaria WHERE usuario = ? LIMIT 1
        SQL;

        $sentencia = $bbdd->prepare($query);
        $sentencia->bind_param('i', $id);
        $sentencia->execute();
        $sentencia->store_result();
        if ($sentencia->num_rows > 0)
            $restricciones[] = 'mensaje de Secretaría (usuario)';
        $sentencia->close();
        
        return $restricciones;
    }

    /*
     *
     * Operaciones UPDATE.
     *  
     */

    /**
     * Actualiza la información de una asignatura en la base de datos.
     * 
     * @param asignatura la asignatura cuya información se va a actualizar.
     * 
     * @return bool Resultado de la ejecución de la sentencia.
     */
    public function dbActualizar(): bool
    {
        $bbdd = App::getSingleton()->bbddCon();

        $query = <<< SQL
        UPDATE
            gesi_asignaturas
        SET
            nivel = ?,
            curso_escolar = ?,
            nombre_corto = ?,
            nombre_completo = ?
        WHERE
            id = ?
        SQL;

        $sentencia = $bbdd->prepare($query);
        
        $id = $this->getId();
        $nivel = $this->getNivelRaw();
        $curso_escolar = $this->getCursoEscolarRaw();
        $nombre_corto = $this->getNombreCorto();
        $nombre_completo = $this->getNombreCompleto();

        $sentencia->bind_param(
            'iissi',
            $nivel,
            $curso_escolar,
            $nombre_corto,
            $nombre_completo,
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
     * Elimina una asignatura de la base de datos.
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
            gesi_asignaturas
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
            'nivel' => $this->getNivelRaw(),
            'cursoEscolar' => $this->getCursoEscolarRaw(),
            'nivelEscolar' => $this->getNivel(),
            'curso' => $this->getCursoEscolar(),
            'nombreCorto' => $this->getNombreCorto(),
            'nombreCompleto' => $this->getNombreCompleto(),
            'checkbox' => $this->getId()
        ];
    }
}

?>