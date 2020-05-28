<?php 

/**
 * Métodos relacionados con los usuarios.
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
use Awsw\Gesi\Formularios\Valido;
use JsonSerializable;

class Usuario
    implements JsonSerializable
{
    
    /**
     * @var int|null $id
     * @var string $nif
     * @var int $rol
     * @var string $nombre
     * @var string $apellidos
     * @var string $fecha_nacimiento (DATE)
     * @var string $numero_telefono
     * @var string $email
     * @var string|null $fecha_ultimo_acceso (DATETIME)
     * @var string $fecha_registro (DATETIME)
     * @var string|null $grupo
     */
    private $id;
    private $nif;
    private $rol;
    private $nombre;
    private $apellidos;
    private $fecha_nacimiento;
    private $numero_telefono;
    private $email;
    private $fecha_ultimo_acceso;
    private $fecha_registro;
    private $grupo;

    /**
     * Constructor.
     */
    public function __construct(
        $id,
        string $nif,
        int $rol,
        string $nombre,
        string $apellidos,
        string $fecha_nacimiento,
        string $numero_telefono,
        string $email,
        $fecha_ultimo_acceso,
        string $fecha_registro,
        $grupo
    )
    {
        $this->id = $id;
        $this->nif = $nif;
        $this->rol = $rol;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->fecha_nacimiento = $fecha_nacimiento;
        $this->numero_telefono = $numero_telefono;
        $this->email = $email;
        $this->fecha_ultimo_acceso = $fecha_ultimo_acceso;
        $this->fecha_registro = $fecha_registro;
        $this->grupo = $grupo;
    }

    public static function fromDbFetch(Object $o) : Usuario
    {
        // Convertir fechas al formato correcto.

        $fechaNacimiento = \DateTime::createFromFormat(
            Valido::MYSQL_DATE_FORMAT, $o->fecha_nacimiento)
                ->format(Valido::ESP_DATE_FORMAT);

        $fechaUltimoAcceso = \DateTime::createFromFormat(
            Valido::MYSQL_DATETIME_FORMAT, $o->fecha_ultimo_acceso);
        $fechaUltimoAcceso = $fechaUltimoAcceso ?
            $fechaUltimoAcceso->format(Valido::ESP_DATETIME_FORMAT) : null;

        $fechaRegistro = \DateTime::createFromFormat(
            Valido::MYSQL_DATETIME_FORMAT, $o->fecha_registro)
                ->format(Valido::ESP_DATETIME_FORMAT);

        return new self(
            $o->id,
            $o->nif,
            $o->rol,
            $o->nombre,
            $o->apellidos,
            $fechaNacimiento,
            $o->numero_telefono,
            $o->email,
            $fechaUltimoAcceso,
            $fechaRegistro,
            $o->grupo
        );
    }

    /*
     *
     * Getters.
     *  
     */

    public function getId() : int
    {
        return $this->id;
    }
    
    public function getNif() : string
    {
        return $this->nif;
    }    
    
    public function getRol() : int
    {
        return $this->rol;
    }

    public function isPs() : bool
    {
        return $this->rol == 3;
    }

    public function isPd() : bool
    {
        return $this->rol == 2;
    }

    public function isEst() : bool
    {
        return $this->rol == 1;
    }
    
    public function getNombre() : string
    {
        return $this->nombre;
    }

    public function getApellidos() : string
    {
        return $this->apellidos;
    }

    public function getNombreCompleto() : string
    {
        return $this->nombre . " " . $this->apellidos;
    }

    public function getFechaNacimiento() : string
    {
        return $this->fecha_nacimiento;
    }
    
    public function getNumeroTelefono() : string
    {
        return $this->numero_telefono;
    }

    public function getEmail() : string
    {
        return $this->email;
    }

    // Puede devolver null.
    public function getFechaUltimoAcceso()
    {
        return $this->fecha_ultimo_acceso;
    }

    public function getFechaRegistro() : string
    {
        return $this->fecha_registro;    
    }
    
    // Puede devolver null.
    public function getGrupo()
    {
        return $this->grupo;
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
     * Inserta un nuevo usuario en la base de datos.
     * 
     * @param Usuario $this Usuario a insertar.
     * 
     * @requires Restricciones de la base de datos.
     * 
     * @return int Identificador del usuario insertado.
     */
    public function dbInsertar() : int
    {
        $app = App::getSingleton();
        $bbdd = $app->bbddCon();

        $query = <<< SQL
        INSERT
        INTO
            gesi_usuarios
            (
                nif,
                rol,
                nombre,
                apellidos,
                password,
                fecha_nacimiento,
                numero_telefono,
                email,
                fecha_registro,
                grupo
            )
        VALUES
            (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        SQL;
        
        $sentencia = $bbdd->prepare($query);

        $nif = $this->getNif();
        $rol = $this->getRol();
        $nombre = $this->getNombre();
        $apellidos = $this->getApellidos();
        $password = password_hash($app->getDefaultPassword(), PASSWORD_DEFAULT);
        $fecha_nacimiento = $this->getFechaNacimiento();
        $numero_telefono = $this->getNumeroTelefono();
        $email = $this->getEmail();
        $fecha_registro = $this->getFechaRegistro();
        $grupo = $this->getGrupo();
        
        $sentencia->bind_param(
            "sisssssssi", 
            $nif,
            $rol,
            $nombre,
            $apellidos,
            $password,
            $fecha_nacimiento,
            $numero_telefono,
            $email,
            $fecha_registro,
            $grupo
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
     * Trae un usuario de la base de datos.
     *
     * @param int $id
     *
     * @requires Existe un usuario con el id especificado.
     *
     * @return Usuario
     */
    public static function dbGet(int $id) : Usuario
    {
        $bbdd = App::getSingleton()->bbddCon();

        $query = <<< SQL
        SELECT 
            id,
            nif,
            rol,
            nombre,
            apellidos,
            fecha_nacimiento,
            numero_telefono,
            email,
            fecha_ultimo_acceso,
            fecha_registro,
            grupo
        FROM
            gesi_usuarios
        WHERE
            id = ?
        LIMIT 1
        SQL;

        $sentencia = $bbdd->prepare($query);
        $sentencia->bind_param('i', $id);
        $sentencia->execute();
        $resultado = $sentencia->get_result();
        $usuario = Usuario::fromDbFetch($resultado->fetch_object());
        $sentencia->close();
        
        return $usuario;
    }

    /**
     * Trae todos los usuarios de la base de datos.
     *
     * @requires Existe un usuario con el id especificado.
     *
     * @return array<Usuario>
     */
    public static function dbGetAll() : array
    {

        $bbdd = App::getSingleton()->bbddCon();

        $query = <<< SQL
        SELECT 
            id,
            nif,
            rol,
            nombre,
            apellidos,
            fecha_nacimiento,
            numero_telefono,
            email,
            fecha_ultimo_acceso,
            fecha_registro,
            grupo
        FROM
            gesi_usuarios
        SQL;

        $sentencia = $bbdd->prepare($query);
        $sentencia->execute();
        $resultado = $sentencia->get_result();
        $usuarios = array();

        while ($a = $resultado->fetch_object()) {
            $usuarios[] = Usuario::fromDbFetch($a);
        }

        $sentencia->close();

        return $usuarios;    
    }

    /**
     * Trae la contraseña de un usuario de la base de datos.
     *
     * @requires Existe un usuario con el id especificado.
     *
     * @param int $id
     *
     * @return string
     */
    public static function dbGetPasswordDesdeId(int $id) : string
    {
        $bbdd = App::getSingleton()->bbddCon();

        $query = <<< SQL
        SELECT 
            password
        FROM
            gesi_usuarios
        WHERE
            id = ?
        LIMIT 1
        SQL;

        $sentencia = $bbdd->prepare($query);

        $sentencia->bind_param(
            "i",
            $id
        );
        
        $sentencia->execute();

        $resultado = $sentencia->get_result()->fetch_object();

        $return = $resultado->password;

        $sentencia->close();

        return $return;
    }

    /**
     * Busca el identificador de un usuario en base a su NIF o NIE.
     *
     * @param string $nif
     *
     * @requires Existe un usuario con el NIF o NIE especificado.
     *
     * @return int
     */
    public static function dbGetIdDesdeNif(string $nif) : int
    {
        $bbdd = App::getSingleton()->bbddCon();

        $sentencia = $bbdd->prepare("
            SELECT id
            FROM gesi_usuarios
            WHERE nif = ?
            LIMIT 1
        ");
        $sentencia->bind_param(
            "s",
            $nif
        );
        
        $sentencia->execute();
        $sentencia->store_result();

        $sentencia->bind_result(
            $result_id
        );
        
        $id = null;

        while($sentencia->fetch()) {
            $id = $result_id;
        }
        
        $sentencia->close();

        return $id;
    }

    /**
     * Comprueba si un usuario existe en la base de datos en base a su
     * identificador.
     *
     * @param int
     *
     * @return bool
     */
    public static function dbExisteId(int $id) : bool
    {        
        $bbdd = App::getSingleton()->bbddCon();

        $query = <<< SQL
        SELECT id FROM gesi_usuarios WHERE id = ? LIMIT 1
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
     * Comprueba si un usuario existe en la base de datos en base a su
     * NIF o NIE.
     *
     * @param string $nif
     *
     * @return bool
     */
    public static function dbExisteNif(string $nif) : bool
    {        
        $bbdd = App::getSingleton()->bbddCon();

        $sentencia = $bbdd->prepare("
            SELECT id
            FROM gesi_usuarios
            WHERE nif = ?
            LIMIT 1
        ");

        $sentencia->bind_param(
            "s",
            $nif
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
     * Trae todos los usuarios de la base de datos de un rol específico.
     *
     * @param int $tipo
     *
     * @return array<Usuario>
     */
    public static function dbGetByRol(int $rol) : array
    {

        $bbdd = App::getSingleton()->bbddCon();

        $sentencia = $bbdd->prepare("
            SELECT 
                id,
                nif,
                rol,
                nombre,
                apellidos,
                fecha_nacimiento,
                numero_telefono,
                email,
                fecha_ultimo_acceso,
                fecha_registro,
                grupo
            FROM
                gesi_usuarios
            WHERE
                rol = ?
        ");

        $sentencia->bind_param(
            'i',
            $rol
        );
    
        $sentencia->execute();
        $resultado = $sentencia->get_result();

        $usuarios = array();

        while ($a = $resultado->fetch_object()) {
            $usuarios[] = Usuario::fromDbFetch($a);
        }

        $sentencia->close();

        return $usuarios;    
    }

    /**
     * Trae todos los usuarios de la base de datos de un grupo específico.
     *
     * @param int $grupo_id
     *
     * @return array<Usuario>
     */
    public static function dbGetEstudiantesByGrupo(int $grupo_id) : array
    {

        $bbdd = App::getSingleton()->bbddCon();

        $sentencia = $bbdd->prepare("
            SELECT 
                id,
                nif,
                rol,
                nombre,
                apellidos,
                fecha_nacimiento,
                numero_telefono,
                email,
                fecha_ultimo_acceso,
                fecha_registro,
                grupo
            FROM
                gesi_usuarios
            WHERE
                grupo = ?
        ");

        $sentencia->bind_param(
            'i',
            $grupo_id
        );
    
        $sentencia->execute();
        $resultado = $sentencia->get_result();

        $usuarios = array();

        while ($a = $resultado->fetch_object()) {
            $usuarios[] = Usuario::fromDbFetch($a);
        }

        $sentencia->close();

        return $usuarios;    
    }

    /*
     *
     * Operaciones UPDATE.
     *  
     */

    /**
     * Actualiza la información de un usuario en la base de datos.
     * 
     * @param Usuario $this El usuario cuya información se va a actualizar.
     * 
     * @return bool Resultado de la ejecución de la sentencia.
     */
    public function dbActualizar() : bool
    {
        $bbdd = App::getSingleton()->bbddCon();

        $query = <<< SQL
        UPDATE
            gesi_usuarios
        SET
            nif = ?,
            rol = ?,
            nombre = ?,
            apellidos = ?,
            fecha_nacimiento = ?,
            numero_telefono = ?,
            email = ?,
            fecha_ultimo_acceso = ?,
            fecha_registro = ?,
            grupo = ?
        WHERE
            id = ?
        SQL;

        $sentencia = $bbdd->prepare($query);

        $id = $this->getId();
        $nif = $this->getNif();
        $rol = $this->getRol();
        $nombre = $this->getNombre();
        $apellidos = $this->getApellidos();
        $fecha_nacimiento = $this->getFechaNacimiento();
        $numero_telefono = $this->getNumeroTelefono();
        $email = $this->getEmail();
        $fecha_ultimo_acceso = $this->getFechaUltimoAcceso();
        $fecha_registro = $this->getFechaRegistro();
        $grupo = $this->getGrupo();

        $sentencia->bind_param(
            "sisssssssii", 
            $nif,
            $rol,
            $nombre,
            $apellidos,
            $fecha_nacimiento,
            $numero_telefono,
            $email,
            $fecha_ultimo_acceso,
            $fecha_registro,
            $grupo,
            $id
        );

        $resultado = $sentencia->execute();

        $sentencia->close();

        return $resultado;
    }

    /**
     * Actualiza la fecha de la última vez que el usuario inició sesión.
     * 
     * @param Usuario $this El usuario cuya información se va a actualizar.
     * 
     * @return bool Resultado de la ejecución de la sentencia.
     */
    public function dbActualizaUltimaSesion() : bool
    {
        $bbdd = App::getSingleton()->bbddCon();

        $sentencia = $bbdd->prepare("
            UPDATE
                gesi_usuarios
            SET
                fecha_ultimo_acceso = ?
            WHERE
                id = ?
        ");

        $id = $this->getId();
        $fecha_ultimo_acceso = date('Y-m-d H:i:s');

        $sentencia->bind_param(
            "si",
            $fecha_ultimo_acceso,
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
     * Eliminar un usuario de la base de datos.
     * 
     * @param int $id
     * 
     * @require $id existe en la abse de datos
     * 
     * @return bool Resultado de la ejecución de la sentencia.
     */
    public static function dbEliminar(int $id) : bool
    {
        $bbdd = App::getSingleton()->bbddCon();

        $sentencia = $bbdd->prepare("
            DELETE
            FROM
                gesi_usuarios
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
     * Implementa la interfaz JsonSerializable.
     */
    public function jsonSerialize()
    {
        return [
            'uniqueId' => $this->getId(),
            'selectName' => $this->getNombreCompleto(),
            'checkbox' => $this->getId(),
            'id' => $this->getId(),
            'nif' => $this->getNif(),
            'rol' => $this->getRol(),
            'nombre' => $this->getNombre(),
            'apellidos' => $this->getApellidos(),
            'fechaNacimiento' => $this->getFechaNacimiento(),
            'numeroTelefono' => $this->getNumeroTelefono(),
            'email' => $this->getEmail(),
            'fechaUltimoAcceso' => $this->getFechaUltimoAcceso(),
            'fechaRegistro' => $this->getFechaRegistro(),
            'grupo' => $this->getGrupo()
        ];
    }
}

?>