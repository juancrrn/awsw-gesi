<?php

/**
 * Métodos relacionados con los libros.
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

class Libro
{
    private $id;
    private $autor;
    private $titulo;
    private $asignatura;
    private $isbn;
    private $editorial;

    /**
     * Constructor.
     */
    private function __construct(
        $id,
        $autor,
        $titulo,
        $asignatura,
        $isbn,
        $editorial
    )
    {
        $this->id = $id;
        $this->autor = $autor;
        $this->titulo = $titulo;
        $this->asignatura = $asignatura;
        $this->$isbn = $isbn;
        $this->editorial = $editorial;        
    }

    /**
     * Inserta un nuevo libro en la base de datos.
     * 
     * @param Libro $libro Libro a insertar.
     * 
     * @requires Restricciones de la base de datos.
     * 
     * @return int Identificador del libro insertado.
     */
    public static function dbInsertar(): int {
        
        $bbdd = App::getSingleton()->bbddCon();
        
        $sentencia = $bbdd->prepare("
            INSERT
            INTO
                gesi_libros
                (
                    id,
                    autor,
                    titulo,
                    asignatura,
                    isbn,
                    editorial
                )
            VALUES
                (?, ?, ?, ?, ?, ?)
        ");

        $autor = $this->getAutor();
        $titulo = $this->getTitulo();
        $asignatura = $this->getAsignatura();
        $isbn = $this->getIsbn();
        $editorial = $this->getEditorial();
        
        $sentencia->bind_param(
            "sssss", 
            $id,
            $autor,
            $titulo,
            $asignatura,
            $isbn,
            $editorial
        );

        $sentencia->execute();
        
        $id_insertado = $bbdd->insert_id;

        $sentencia->close();

        $this->id = $id_insertado;

        return $this->id;
    }

    /**
     * Devuelve el numero de ejemplares que tiene un libro
     *
     * @param int $id
     *
     * @requires Existe un ejemplar del libro especificado.
     *
     * @return int $result
     */

    public static function numLibros($id)
    {
        $bbdd = App::getSingleton()->bbddCon();
        
        $sentencia = $bbdd->prepare("
            SELECT 
              COUNT(*)
            FROM
                gesi_libros
            WHERE
                id = ?
        ");

        $sentencia->bind_param(
            "i",
            $id
        );

        $sentencia->execute();
        $sentencia->store_result();

        $sentencia->bind_result(
            $result_num
        );
        $sentencia->close();
        return $result_num;
    }

    /**
     * Trae un libro de la base de datos.
     *
     * @param int $id
     *
     * @requires Existe un libro con el id especificado.
     *
     * @return Libro
     */
    public static function dbGet(int $id) : Libro
    {
        $bbdd = App::getSingleton()->bbddCon();

        $sentencia = $bbdd->prepare("
            SELECT 
                id,
                autor,
                titulo,
                asignatura,
                isbn,
                editorial
            FROM
                gesi_libros
            WHERE
                id = ?
            LIMIT 1
        ");
        $sentencia->bind_param(
            "i",
            $id
        );
        
        $sentencia->execute();
        $sentencia->store_result();

        $sentencia->bind_result(
            $result_id,
            $result_autor,
            $result_titulo,
            $result_asignatura,
            $result_isbn,
            $result_editorial
        );
        
        $libro = null;

        while($sentencia->fetch()) {
            $libro = new Libro(
                $result_id,
                $result_autor,
                $result_titulo,
                $result_asignatura,
                $result_isbn,
                $result_editorial
            );
        }
        
        $sentencia->close();

        return $libro;
    }

    /**
     * Trae todos los ejemplares de un libro de la base de datos.
     *
     * @param int $id
     *
     * @requires Existe un ejemplar del libro especificado.
     *
     * @return array<EjemplarLibro>
     */
    public static function dbGetEjemplares(int $id){
        
        $bbdd = App::getSingleton()->bbddCon();

        $sentencia = $bbdd->prepare("
            SELECT 
            E.id,
            E.libro_id,
            E.numero,
            E.prestado,
            E.fecha_alta_prestamo,
            E.fecha_expiracion_prestamo,
            E.fecha_alta_reserva
            FROM
                gesi_ejemplar_libro E
            WHERE
                E.libro_id = ?
        ");

        $sentencia->bind_param(
            "i",
            $id
        );
        
        $sentencia->execute();
        $sentencia->store_result();

        $sentencia->bind_result(
            $result_id,
            $result_numero,
            $result_libro_id,
            $result_prestado,
            $result_fecha_alta_prestamo,
            $result_fecha_expiracion_prestamo,
            $result_reserva,
            $result_fecha_alta_reserva,
            $fecha_expiracion_reserva
        );
        while($sentencia->fetch()) {
            $ejemplares[] = new EjemplarLibro(
                $result_id,
                $result_numero,
                $result_libro_id,
                $result_prestado,
                $result_fecha_alta_prestamo,
                $result_fecha_expiracion_prestamo,
                $result_reserva,
                $result_fecha_alta_reserva,
                $fecha_expiracion_reserva
            );
        }
        
        $sentencia->close();

        return $ejemplares;
    }

    public function getId(){
        return $this->id;
    }

    public function getAutor(){
        return $this->autor;
    }
    
    public function getTitulo(){
        return $this->titulo;
    }
    
    public function getAsignatura(){
        return $this->asignatura;
    }
    
    public function getIsbn(){
        return $this->isbn;
    }
    
    public function getEditorial(){
        return $this->editorial;
    }

    public static function dbActualizar(): bool{

        $sentencia = $bbdd->prepare("
            UPDATE
                gesi_libros
            SET
                autor = ?,
                titulo = ?,
                asignatura, = ?
                isbn = ?,
                editorial = ?
            WHERE
                id = ?
        ");

        $id= $this->getId();
        $autor= $this->getAutor();
        $titulo= $this->getTitulo();
        $asignatura= $this->getAsignatura();
        $isbn= $this->getIsbn();
        $editorial= $this->getEditorial();

        $sentencia->bind_param(
            "ississ", 
            $id,
            $autor,
            $titulo,
            $asignatura,
            $isbn,
            $editorial
        );

        $resultado = $sentencia->execute();

        $sentencia->close();

        return $resultado;
    }
}