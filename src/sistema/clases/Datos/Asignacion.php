<?php

/**
 * Métodos relacionados con la relación asignatura-profesor-grupo.
 * Para abreviar, esta relación se denomina "asignación".
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

class Asignacion
    implements JsonSerializable
{

    /**
     * @var int $id Identificador único de la relación.
     */
    private $id;

    /**
     * @var int $asignatura Asignatura de la asignación.
     */
    private $asignatura;

    /**
     * @var int $grupo Grupo de la asignación.
     */
    private $grupo;

    /**
     * @var int $profesor Profesor de la asignación.
     */
    private $profesor;

    /**
     * @var string $horario Horario en que el profesor imparte la asignatura al 
     * grupo.
     */
    private $horario;

    /**
     * @var int $foro_principal Foro de recursos de la asignatura para el grupo.
     */
    private $foro_principal;

    /**
     * Constructor.
     */
    public function __construct(
        $id,
        $asignatura, 
        $grupo,
        $profesor,
        $horario,
        $foro_principal
    )
    {
        $this->id = $id;
        $this->asignatura = $asignatura;
        $this->grupo = $grupo;
        $this->profesor = $profesor;
        $this->horario = $horario;
        $this->foro_principal = $foro_principal;
    }

    private static function fromDbFetch(Object $o) : Asignacion
    {
        return new self(
            $o->id,
            $o->asignatura,
            $o->grupo,
            $o->profesor,
            $o->horario,
            $o->foro_principal
        );
    }
    
    /**
     * Getters.
     */
    public function getId()
    {
        return $this->id;
    }

    public function getAsignatura()
    {
        return $this->asignatura;
    }

    public function getGrupo()
    {
        return $this->grupo;
    }

    public function getProfesor()
    {
        return $this->profesor;
    }

    public function getHorario()
    {
        return $this->horario;
    }

    public function getForoPrincipal()
    {
        return $this->foro_principal;
    }

    /**
     * Implementa la interfaz JsonSerializable
     */
    public function jsonSerialize()
    {
        $profesorNombre = Usuario::dbGet($this->getProfesor())
            ->getNombreCompleto();
        $asignaturaNombre = Asignatura::dbGet($this->getAsignatura())
            ->getNombreCompleto();
        $grupoNombre = Grupo::dbGet($this->getGrupo())
            ->getNombreCompleto();

        return [
            'uniqueId' => $this->getId(),
            'id' => $this->getId(),
            'asignatura' => $this->getAsignatura(),
            'grupo' => $this->getGrupo(),
            'profesor' => $this->getProfesor(),
            'horario' => $this->getHorario(),
            'foroPrincipal' => $this->getForoPrincipal(),
            'profesorNombre' => $profesorNombre,
            'asignaturaNombre' => $asignaturaNombre,
            'grupoNombre' => $grupoNombre
        ];
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
     * Inserta una nueva Asignacion en la base de datos.
     * 
     * @param Asignacion $this Asignacion a insertar.
     * 
     * @requires Restricciones de la base de datos.
     * 
     * @return int Identificador de la Asignacion insertada.
     */
    public function dbInsertar() : int
    {
        $bbdd = App::getSingleton()->bbddCon();
        
        $sentencia = $bbdd->prepare("
            INSERT
            INTO
                gesi_asignaciones
                (
                    profesor,
                    grupo,
                    asignatura,
                    horario,
                    foro_principal
                )
            VALUES
                (?, ?, ?, ?, ?)
        ");

        $profesorId = $this->getProfesor();
        $grupoId = $this->getGrupo();
        $asignaturaId = $this->getAsignatura();
        $horario = $this->getHorario();
        $foroPrincipalId = $this->getForoPrincipal();
        
        $sentencia->bind_param(
            'iiisi',
            $profesorId,
            $grupoId,
            $asignaturaId,
            $horario,
            $foroPrincipalId
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
     * Trae una Asignacion de la base de datos.
     *
     * @param int $id
     *
     * @requires Existe una Asignacion con el id especificado.
     *
     * @return Asignacion
     */
    public static function dbGet(int $id) : Asignacion
    {
        $bbdd = App::getSingleton()->bbddCon();

        $query = <<< SQL
        SELECT 
            id,
            profesor,
            grupo,
            asignatura,
            horario,
            foro_principal
        FROM
            gesi_asignaciones
        WHERE
            id = ?
        LIMIT 1
        SQL;

        $sentencia = $bbdd->prepare($query);
        $sentencia->bind_param('i', $id);
        $sentencia->execute();
        $resultado = $sentencia->get_result();
        $asignacion = self::fromDbFetch($resultado->fetch_object());
        $sentencia->close();
        
        return $asignacion;
    }

    /** 
     * Trae todas las asignaciones
     * 
     * @param int $id del
     * 
     * @return array<Asignacion>
     */
    public static function dbGetAll(): array {

        $bbdd = App::getSingleton()->bbddCon();

        $sentencia = $bbdd->prepare("
            SELECT 
                id,
                profesor,
                grupo,
                asignatura,
                horario,
                foro_principal
            FROM
                gesi_asignaciones
        ");
    
        $sentencia->execute();
        $resultado = $sentencia->get_result();
        $asignaciones = array();

        while ($asignacion = $resultado->fetch_object()) {
            $asignaciones[] = self::fromDbFetch($asignacion);
        }

        $sentencia->close();
        
        return $asignaciones;    
    }

    /**
     * Comprueba si la asignatura con identificador id participa en alguna 
     * asignación.
     * 
     * @param int $id
     * 
     * @return bool
     */
    public static function dbAnyByAsignatura(int $id) : bool
    {
        $bbdd = App::getSingleton()->bbddCon();

        $sentencia = $bbdd->prepare("
            SELECT
                id
            FROM
                gesi_asignaciones
            WHERE
                asignatura = ?
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
     * Trae todas las asignaciones de un grupo.
     * 
     * @param int $id grupo
     * 
     * @return array<Asignacion>
     */
    public static function dbGetByGrupo(int $grupo_id) : array
    {

        $bbdd = App::getSingleton()->bbddCon();

        $sentencia = $bbdd->prepare("
            SELECT 
                id,
                profesor,
                grupo,
                asignatura,
                horario,
                foro_principal
            FROM
                gesi_asignaciones
            WHERE
                grupo = ?
        ");

        $sentencia->bind_param(
            "i",
            $grupo_id
        );
    
        $sentencia->execute();

        $r = $sentencia->get_result();

        $as = array();

        while ($a = $r->fetch_object()) {
            $as[] = self::fromDbFetch($a);
        }

        $sentencia->close();
        return $as;    
    }

    /**
     * Trae las asignaturas que imparte un profesor
     * 
     * @param int $id del profesor
     * 
     * @return array<Asignatura>
     */
    public static function dbGetByProfesor(int $profesor) : array
    {
        $bbdd = App::getSingleton()->bbddCon();

        $sentencia = $bbdd->prepare("
            SELECT 
                id,
                profesor,
                asignatura,
                grupo,
                horario,
                foro_principal
            FROM
                gesi_asignaciones        
            WHERE
                profesor = ?    
        ");

        $sentencia->bind_param(
            "i",
            $profesor
        );

        $sentencia->execute();

        $r = $sentencia->get_result();

        $as = array();

        while ($a = $r->fetch_object()) {
            $as[] = self::fromDbFetch($a);
        }

        $sentencia->close();

        return $as;    
	}
	
	 /**
     * Trae las asignaciones en las que participa un profesor
     * 
     * @param int $id del profesor
     * 
     * @return array<Asignacion>
     */
    public static function dbGetAsignacionesByProfesor(int $profesor) : array
    {
        $bbdd = App::getSingleton()->bbddCon();

        $sentencia = $bbdd->prepare("
		SELECT 
			id,
			profesor,
			grupo,
			asignatura,
			horario,
			foro_principal
		FROM
			gesi_asignaciones
		WHERE
			profesor = ?   
        ");

        $sentencia->bind_param(
            "i",
            $profesor
        );

        $sentencia->execute();

        $r = $sentencia->get_result();

        $as = array();

        while ($a = $r->fetch_object()) {
            $as[] = self::fromDbFetch($a);
        }

        $sentencia->close();

        return $as;    
    }

    /**
     * Comprueba si una asignación existe en la base de datos en base a su
     * identificador.
     *
     * @param int $id
     *
     * @return bool
     */
    public static function dbExisteId(int $id) : bool
    {        
        $bbdd = App::getSingleton()->bbddCon();

        $query = <<< SQL
        SELECT id FROM gesi_asignaciones WHERE id = ? LIMIT 1
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
     * Comprueba si una asignación existe en la base de datos en base a su
     * identificador.
     *
     * @param int $id
     *
     * @return bool
     */
    public static function dbExisteByAsignaturaGrupo(
        int $asignatura,
        int $grupo
    ) : bool
    {        
        $bbdd = App::getSingleton()->bbddCon();

        $query = <<< SQL
        SELECT id
        FROM gesi_asignaciones
        WHERE asignatura = ?
        AND grupo = ?
        LIMIT 1
        SQL;

        $sentencia = $bbdd->prepare($query);
        $sentencia->bind_param('ii', $asignatura, $grupo);
        $sentencia->execute();
        $sentencia->store_result();
        $existe = $sentencia->num_rows > 0;
        $sentencia->close();

        return $existe;
    }

    /**
     * 
     * Comprueba si un grupo tiene alguna asignación.
     * 
     * @param int $id_grupo
     * 
     * @return bool
     */
    public static function dbAnyByGrupo($id_grupo) : bool
    {
        $bbdd = App::getSingleton()->bbddCon();

        $sentencia = $bbdd->prepare("
            SELECT
                id
            FROM
                gesi_asignaciones
            WHERE
                grupo = ?
            LIMIT 1
        
        ");

        $sentencia->bind_param(
            "i",
            $id_grupo
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
     * Trae las asignaciones en las que participa una asignatura en concreto.
     * 
     * @param int $id
     * 
     * @return array
     */
    public static function dbGetByAsignatura(int $id_asignatura) : array
    {
        $bbdd = App::getSingleton()->bbddCon();

        $sentencia = $bbdd->prepare("
            SELECT
                id,
                profesor,
                asignatura,
                grupo,
                horario,
                foro_principal
            FROM
                gesi_asignaciones
            WHERE
                asignatura = ?        
        ");

        $sentencia->bind_param(
            "i",
            $id_asignatura
            );

        $sentencia->execute();
            
        $r = $sentencia->get_result();

        $asignaciones = array();

        while ($a = $r->fetch_object()) {
            $asignaciones[] = self::fromDbFetch($a);
        }

        $sentencia->close();

        return $asignaciones;
    }

    /*
     *
     * Operaciones UPDATE.
     *  
     */

    /**
     * Actualiza la información de una Asignacion en la base de datos.
     * 
     * @param Asignacion $this la Asignacion cuya información se va a actualizar.
     * 
     * @return bool Resultado de la ejecución de la sentencia.
     */
    public function dbActualizar() : bool
    {
        $bbdd = App::getSingleton()->bbddCon();

        $query = <<< SQL
        UPDATE
            gesi_asignaciones
        SET
            profesor = ?,
            grupo = ?,
            asignatura = ?,
            horario = ?,
            foro_principal = ?
        WHERE
            id = ?
        SQL;

        $sentencia = $bbdd->prepare($query);

        $profesorId = $this->getProfesor();
        $grupoId = $this->getGrupo();
        $asignaturaId = $this->getAsignatura();
        $horario = $this->getHorario();
        $foroPrincipalId = $this->getForoPrincipal();
        $id = $this->getId();

        $sentencia->bind_param(
            'iiisii', 
            $profesorId,
            $grupoId,
            $asignaturaId,
            $horario,
            $foroPrincipalId,
            $id
        );

        $resultado = $sentencia->execute();
        $sentencia->close();

        return $resultado;
    }

    /**
     * 
     * Operaciones DELETE.
     * 
     */

    /**
     * Alimina un foro de la base de datos.
     * 
     * @param int $id
     * 
     * @return bool
     */
    public static function dbEliminar(int $id) : bool
    {
        $bbdd = App::getSingleton()->bbddCon();

        $sentencia = $bbdd->prepare("
            DELETE
            FROM
                gesi_asignaciones
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

?>