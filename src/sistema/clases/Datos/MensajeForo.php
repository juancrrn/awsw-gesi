<?php

namespace Awsw\Gesi\Datos;

use Awsw\Gesi\App;
use Awsw\Gesi\Validacion\Valido;
use JsonSerializable;
use stdClass;

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
 * @version 0.0.4
 */

class MensajeForo 
    implements DAO, JsonSerializable
{
    /**
     * @var int $id           Identificador único.
     * @var int $foro         Foro al que pertenece.
     * @var int|null $padre   Mensaje al que responde, nulo si es raíz.
     * @var int $usuraio      Usuario autor.
     * @var string $fecha     Fecha de creación.
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
     * Trae todos los mensajes de foro de la base de datos.
     * 
     * @return array
     */
    public static function dbGetAll(): array
    {
        // Este método es solo para completar la interfaz.
        
        return array();
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

    /**
     * Comprueba si un mensaje de foro se puede eliminar, es decir, que no está 
     * referenciado como clave ajena en otra tabla.
     * 
     * @requires      El mensaje de foro existe.
     * 
     * @param int $id Identificador del mensaje de foro.
     * 
     * @return array  En caso de haberlas, devuelve un array con los nombres de 
     *                las tablas donde hay referencias al mensaje de foro. Si 
     *                no las hay, devuelve un array vacío.
     */
    public static function dbCompruebaRestricciones(int $id): array
    {
        // Los mensajes de foros no se pueden eliminar, así que no comprobamos restricciones.

        return array();
    }

    /*
     *
     * Operaciones UPDATE.
     *  
     */

    /**
     * Actualiza un mensaje de foro en la base de datos.
     * 
     * @param self $this
     * 
     * @return bool
     */
    public function dbActualizar(): bool
    {
        // Los mensajes de foro no se actualizan.

        return false;
    }

    /*
     *
     * Operaciones DELETE.
     *  
     */

    /**
     * Elimina un mensaje de foro de la base de datos.
     *
     * @param int $id
     */
    public static function dbEliminar(int $id): bool
    {
        // Los mensajes de foro no se eliminan.

        return false;
    }
    
    public function jsonSerialize()
    {
        $usuario = Usuario::dbGet($this->getUsuario());
        $fecha = \DateTime::createFromFormat(
            Valido::MYSQL_DATETIME_FORMAT, $this->getFecha())
                ->format(Valido::ESP_DATETIME_SHORT_FORMAT);

        return [
            'uniqueId' => $this->getId(),
            'checkbox' => $this->getId(),
            'id' => $this->getId(),
            'usuario' => $this->getUsuario(),
            'usuarioNombre' => $usuario->getNombreCompleto(),
            'foro' => $this->getForo(),
            'padre' => $this->getPadre(),
            'fecha' => $fecha,
            'contenido' => $this->getContenido(),
            'extractoContenido' => $this->getContenido(32)
        ];
    }
}

?>