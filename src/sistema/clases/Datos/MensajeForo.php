<?php

/**
 * Métodos relacionados con los mensajes de foros.
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

use \Awsw\Gesi\App;
use \Awsw\Gesi\Formularios\Valido;
use JsonSerializable;

class MensajeForo 
    /* implements JsonSerializable TODO */
{
    /**
     * @var int $id Identificador único.
     * @var int $foro Foro al que pertenece.
     * @var int|null $padre Mensaje al que responde, nulo si es raíz.
     * @var int $usuraio Usuario autor.
     * @var string $fecha Fecha de creación.
     * @var string $contenido Contenido.
     */
    private $id;
    private $foro;
    private $padre;
    private $usuario;
    private $fecha;
    private $contenido;

    /**
     * Constructor.
     */
    public function __construct(
        $id,
        int $foro,
        $padre,
        int $usuario,
        string $fecha,
        string $contenido
    )
    {
        $this->id = $id;
        $this->foro = $foro;
        $this->padre = $padre;
        $this->usuario = $usuario;
        $this->fecha = $fecha;
        $this->contenido = $contenido;
    }

    /**
     * Constructor desde un objeto de mysqli_result::fetch_object.
     */
    public static function fromMysqlFetch(Object $o) : self
    {
        return new self(
            $o->id,
            $o->foro,
            $o->padre,
            $o->usuario,
            $o->fecha,
            $o->contenido
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

    public function getForo(): int
    {
        return $this->foro;
    }

    public function getPadre()
    {
        return $this->padre;
    }

    public function getUsuario(): int
    {
        return $this->usuario;
    }

    public function getFecha(): string
    {
        return $this->fecha;
    }

    public function getContenido(): string
    {
        return $this->contenido;
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
     * Inserta un nuevo mensaje de foro en la base de datos.
     * 
     * @param self $this Mensaje de foro a insertar.
     * 
     * @requires Restricciones de la base de datos.
     * 
     * @return int Identificador del mensaje de foro insertado.
     */
    public function dbInsertar(): int
    {
        $bbdd = App::getSingleton()->bbddCon();

        $query = <<< SQL
        INSERT
        INTO 
            gesi_mensajes_foros
            (
                foro,
                padre,
                usuario,
                fecha,
                contenido
            )
        VALUES
            (?, ?, ?, ?, ?)
        SQL;

        $sentencia = $bbdd->prepare($query);

        $foro = $this->getForo();
        $padre = $this->getPadre();
        $usuario = $this->getUsuario();
        $fecha = $this->getFecha();
        $contenido = $this->getContenido();

        $sentencia->bind_param(
            'iiiss',
            $foro,
            $padre,
            $usuario,
            $fecha,
            $contenido
        );

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
     * Trae de la base de datos un mensaje.
     * 
     * @param int $mensajeForoId Id del mensaje.
     * 
     * @return array Mensajes hijos (respuestas) del mensaje.
    */
    public static function dbGet($mensajeForoId): self
    {
        $bbdd = App::getSingleton()->bbddCon();

        $query = <<< SQL
        SELECT
            id,
            foro,
            padre,
            usuario,
            fecha,
            contenido
        FROM
            gesi_mensajes_foros
        WHERE
            id = ?
        SQL;

        $sentencia = $bbdd->prepare($query);
        $sentencia->bind_param('i', $mensajeForoId);
        $sentencia->execute();
        $resultado = $sentencia->get_result();
        $mensaje = self::fromMysqlFetch($resultado->fetch_object());
        $sentencia->close();

        return $mensaje;
    }

    /**
     * Trae de la base de datos todos los mensajes raíz de un foro a partir del
     * identificador de este.
     * 
     * @param int $foroId Identificador del foro.
     * 
     * @return array Mensajes del foro.
    */
    public static function getAllByForo(int $foroId): array
    {
        $bbdd = App::getSingleton()->bbddCon();

        $query = <<< SQL
        SELECT
            id,
            foro,
            padre,
            usuario,
            fecha,
            contenido
        FROM
            gesi_mensajes_foros
        WHERE
            foro = ?
        AND
            padre IS NULL
        SQL;

        $sentencia = $bbdd->prepare($query);
        $sentencia->bind_param('i', $foroId);
        $sentencia->execute();
        $resultado = $sentencia->get_result();

        $mensajes = array();

        while ($mensaje = $resultado->fetch_object()) {
            $mensajes[] = self::fromMysqlFetch($mensaje);
        }
        
        $sentencia->close();

        return $mensajes;
    }

    /**
     * Comprueba si un mensaje de foro existe en la base de datos en base a su
     * identificador.
     * 
     * @param int $mensajeForoId
     * 
     * @return bool
     */
    public static function dbExisteId(int $id): bool
    {        
        $bbdd = App::getSingleton()->bbddCon();

        $query = <<< SQL
        SELECT id FROM gesi_mensajes_foros WHERE id = ? LIMIT 1
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
     * Trae de la base de datos todos los mensajes hijos (respuestas) de un 
     * mensaje. Según la especificación, solo se admite un nivel de respuestas.
     * 
     * @param self $this Mensaje padre.
     * 
     * @return array Mensajes hijos (respuestas) del mensaje.
    */
    public function dbGetRespuestas(): array
    {
        $bbdd = App::getSingleton()->bbddCon();

        $query = <<< SQL
        SELECT
            id,
            foro,
            padre,
            usuario,
            fecha,
            contenido
        FROM
            gesi_mensajes_foros
        WHERE
            padre = ?
        SQL;

        $sentencia = $bbdd->prepare($query);
        $id = $this->getId();
        $sentencia->bind_param('i', $id);
        $sentencia->execute();
        $resultado = $sentencia->get_result();
        $mensajes = array();

        while ($mensaje = $resultado->fetch_object()) {
            $mensajes[] = self::fromMysqlFetch($mensaje);
        }
        
        $sentencia->close();

        return $mensajes;
    }
    
    /* TODO BORRAR ? 
    public function jsonSerialize()
    {
        return [
            'uniqueId' => $this->getId(),
            'checkbox' => $this->getId(),
            'id' => $this->getId(),
            'usuario' => $this->getUsuario(),
            'foro' => $this->getForo(),
            'padre' => $this->getPadre(),
            'fecha' => $this->getFecha(Valido::ESP_DATETIME_SHORT_FORMAT),
            'contenido' => $this->getContenido(),
            'extractoContenido' => $this->getContenido(32)
        ];
    }*/
}

?>