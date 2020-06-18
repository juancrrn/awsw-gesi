<?php

/**
 * Métodos relacionados con los mensajes de Secretaría.
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
use Awsw\Gesi\Formularios\Valido;
use JsonSerializable;
use stdClass;

class MensajeSecretaria
    implements JsonSerializable
{
    /**
     * @var int $id               Identificador único del mensaje.
     * @var int $usuario          Si lo ha enviado un usuario registrado, su 
     *                            identificador.
     * @var string $from_nombre   Si lo ha enviado un usuario invitado, su 
     *                            nombre.
     * @var string $from_email    Si lo ha enviado un usuario invitado, su 
     *                            email.
     * @var string $from_telefono Si lo ha enviado un usuario invitado, su 
     *                            teléfono.
     * @var string $contenido     Contenido del mensaje.
     * @var string $fecha         Fecha de envio del mensaje.
     */
    private $id;
    private $usuario;
    private $from_nombre;
    private $from_email;
    private $from_telefono;
    private $contenido;
    private $fecha;

    /**
     * Constructor.
     */
    public function __construct(
        $id,
        $usuario,
        $from_nombre,
        $from_email,
        $from_telefono,
        $fecha,
        $contenido
    )
    {
        $this->id = $id;
        $this->usuario = $usuario;
        $this->from_nombre = $from_nombre;
        $this->from_email = $from_email;
        $this->from_telefono = $from_telefono;
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
            $o->usuario,
            $o->from_nombre,
            $o->from_email,
            $o->from_telefono,
            $o->fecha,
            $o->contenido
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

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function getFromNombre()
    {
        return $this->from_nombre;
    }

    public function getFromEmail()
    {
        return $this->from_email;
    }

    public function getFromTelefono()
    {
        return $this->from_telefono;
    }

    public function getFecha($format = null): string
    {
        if (! $format) {
            return $this->fecha;
        } else {
            return \DateTime::createFromFormat(
                Valido::MYSQL_DATETIME_FORMAT, $this->fecha)
                ->format($format);
        }
    }

    public function getContenido($length = null): string
    {
        if (! $length) {
            return $this->contenido;
        } else {
            return substr($this->contenido, 0, $length) .
                (strlen($this->contenido) > $length ? '...' : '');
        }
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
     * Inserta un mensaje de Secretaria en la base de datos.
     *
     * @param MensajeSecretaria $this MensajeSecretaria a insertar.
     * 
     * @requires Restricciones de la Base de Datos.
     * 
     * @return int Identificador del MensajeSecretaria insertado.
     */
    public function dbInsertar(): bool  {
        $bbdd = App::getSingleton()->bbddCon();

        $query = <<< SQL
        INSERT
        INTO
            gesi_mensajes_secretaria
            (
                usuario,
                from_nombre,
                from_email,
                from_telefono,
                fecha,
                contenido
            )
        VALUES
            (?, ?, ?, ?, ?, ?)
        SQL;
        
        $sentencia = $bbdd->prepare($query);

        $usuario = $this->getUsuario();
        $from_nombre = $this->getFromNombre();
        $from_email = $this->getFromEmail();
        $from_telefono = $this->getFromTelefono();
        $fecha = $this->getFecha();
        $contenido = $this->getContenido();

        $sentencia->bind_param(
            'isssss',
            $usuario,
            $from_nombre,
            $from_email,
            $from_telefono,
            $fecha,
            $contenido
        );

        $sentencia->execute();
        $id_insertado = $bbdd->insert_id;
        $sentencia->close();
        $this->id = $id_insertado;

        return $id_insertado;
    }

    /*
     *
     * Operaciones SELECT.
     *  
     */

    /**
     * Trae un mensaje de Secretaría de la base de datos.
     *
     * @param int $id
     *
     * @requires Existe un mensaje de Secretaría con el id especificado.
     *
     * @return MensajeSecretaria
     */
    public static function dbGet(int $id) : self
    {
        $bbdd = App::getSingleton()->bbddCon();

        $query = <<< SQL
        SELECT 
            id,
            usuario,
            from_nombre,
            from_email,
            from_telefono,
            fecha,
            contenido
        FROM
            gesi_mensajes_secretaria
        WHERE
            id = ?
        LIMIT 1
        SQL;

        $sentencia = $bbdd->prepare($query);
        $sentencia->bind_param('i', $id);
        $sentencia->execute();
        $resultado = $sentencia->get_result();
        $mensaje = self::fromMysqlFetch($resultado->fetch_object());
        $sentencia->close();
        
        return $mensaje;
    }

    /**
     * Trae todos los mensajes de Secretaría de la base de datos.
     *
     * @requires Existe al menos un mensaje en la base de datos.
     *
     * @return array<MensajeSecretaria>
     */
    public static function dbGetAll() : array
    {    
        $bbdd = App::getSingleton()->bbddCon();

        $query = <<< SQL
        SELECT 
            id,
            usuario,
            from_nombre,
            from_email,
            from_telefono,
            fecha,
            contenido
        FROM
            gesi_mensajes_secretaria
        SQL;

        $sentencia = $bbdd->prepare($query);
        $sentencia->execute();
        $result = $sentencia->get_result();
        $mensajes = array();

        while ($m = $result->fetch_object()) {
            $mensajes[] = self::fromMysqlFetch($m);
        }
        
        $sentencia->close();

        return $mensajes;
    }

    /**
     * Trae todos los mensajes de Secretaría de la base de datos.
     *
     * @requires Existe al menos un mensaje en la base de datos.
     *
     * @return array<MensajeSecretaria>
     */
    public static function dbAny(): bool
    {
        $bbdd = App::getSingleton()->bbddCon();

        $query = <<< SQL
        SELECT 
            id
        FROM
            gesi_mensajes_secretaria
        SQL;

        $sentencia = $bbdd->prepare($query);
        $sentencia->execute();
        $sentencia->store_result();
        $existe = $sentencia->num_rows > 0;
        $sentencia->close();

        return $existe;
    }

    /**
     * Trae todos los mensajes de Secretaría de la base de datos que 
     * pertenezcan a un Usuario.
     *
     * @return array<MensajeSecretaria>
     */
    public static function dbGetByUsuario(int $usuario_id): array
    {
        $bbdd = App::getSingleton()->bbddCon();

        $query = <<< SQL
        SELECT 
            id,
            usuario,
            from_nombre,
            from_email,
            from_telefono,
            fecha,
            contenido
        FROM
            gesi_mensajes_secretaria
        WHERE
            usuario = ?
        SQL;

        $sentencia = $bbdd->prepare($query);
        $sentencia->bind_param('i', $usuario_id);
        $sentencia->execute();
        $resultado = $sentencia->get_result();
        $mensajes = array();

        while ($m = $resultado->fetch_object()) {
            $mensajes[] = self::fromMysqlFetch($m);
        }

        $sentencia->close();

        return $mensajes;
    }

    /**
     * Comprueba si el Usuario id tiene algun mensaje de secretaria
     *
     * @param int
     *
     * @return bool
     */
    public static function dbAnyByUsuario(int $id): bool
    {
        $bbdd = App::getSingleton()->bbddCon();

        $query = <<< SQL
        SELECT
            id
        FROM
            gesi_mensajes_secretaria
        WHERE
            usuario = ?
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
     * Comprueba si un mensaje de Secretaría existe en la base de datos en base 
     * a su identificador.
     *
     * @param int $id
     *
     * @return bool
     */
    public static function dbExisteId(int $id): bool
    {        
        $bbdd = App::getSingleton()->bbddCon();

        $query = <<< SQL
        SELECT id
        FROM gesi_mensajes_secretaria
        WHERE id = ?
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
     * Comprueba si un mensaje de Secretaría se puede eliminar, es decir, que 
     * no está referenciado como clave ajena en otra tabla.
     * 
     * @requires      El mensaje de Secretaría existe.
     * 
     * @param int $id Identificador del mensaje de Secretaría.
     * 
     * @return array  En caso de haberlas, devuelve un array con los nombres de 
     *                las tablas donde hay referencias al mensaje de 
     *                Secretaría. Si no las hay, devuelve un array vacío.
     */
    public static function dbCompruebaRestricciones(int $id): array
    {
        // Los mensajes de Secretaría no se pueden eliminar, así que no comprobamos restricciones.

        return array();
    }

    public function jsonSerialize()
    {
        if ($this->getUsuario()) {
            $usuario = Usuario::dbGet($this->getUsuario());
            $nombre = $usuario->getNombreCompleto();
            $email = $usuario->getEmail();
            $telefono = $usuario->getNumeroTelefono();
        } else {
            $nombre = $this->getFromNombre();
            $email = $this->getFromEmail();
            $telefono = $this->getFromTelefono();
        }

        return [
            'uniqueId' => $this->getId(),
            'checkbox' => $this->getId(),
            'id' => $this->getId(),
            'usuario' => $this->getUsuario(),
            'fromNombre' => $nombre,
            'fromEmail' => $email,
            'fromTelefono' => $telefono,
            'fecha' => $this->getFecha(Valido::ESP_DATETIME_SHORT_FORMAT),
            'contenido' => $this->getContenido(),
            'extractoContenido' => $this->getContenido(32)
        ];
    }
}

?>