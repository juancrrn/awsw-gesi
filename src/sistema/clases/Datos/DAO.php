<?php

namespace Awsw\Gesi\Datos;

/**
 * Interfaz para objetos de tipo DAO (patrón objeto de acceso a datos, data
 * access object).
 * 
 * El tipo "static" en los comentarios hace referencia a la clase que 
 * implementará la interfaz.
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

interface DAO
{
    
    /*
     *
     * Operaciones INSERT.
     *  
     */

    /**
     * Inserta el objeto en la base de datos.
     * 
     * @param static $this Objeto a insertar.
     * 
     * @return int         Identificador del objeto insertado.
     */
    public function dbInsertar(): int;

    /*
     *
     * Operaciones SELECT.
     *  
     */

    /**
     * Recoge un objeto de la base de datos.
     * 
     * @param int $id Identificador del objeto.
     * 
     * @return static Objeto.
     */
    public static function dbGet(int $id);

    /**
     * Comprueba si un objeto existe en la base de datos por su id.
     * 
     * @param int $id Identificador del objeto.
     * 
     * @return bool   True si el objeto existe, false en otro caso.
     */
    public static function dbExisteId(int $id): bool;

    /**
     * Recoge todos los objetos de la base de datos.
     * 
     * @return array Lista con todos los objetos.
     */
    public static function dbGetAll(): array;

    /**
     * Comprueba si un objeto se puede eliminar, es decir, que no está 
     * referenciado como clave ajena en otra tabla.
     * 
     * @requires      El objeto existe.
     * 
     * @param int $id Identificador del objeto.
     * 
     * @return array  En caso de haberlas, devuelve un array con los nombres de 
     *                las tablas donde hay referencias al objeto. Si no las 
     *                hay, devuelve un array vacío.
     */
    public static function dbCompruebaRestricciones(int $id): array;

    /*
     *
     * Operaciones UPDATE.
     *  
     */

    /**
     * Actualiza un objeto en la base de datos.
     * 
     * @requires           El objeto existe.
     * 
     * @param static $this Objeto a actualizar.
     * 
     * @return bool        Resultado de la ejecución de la sentencia.
     */
    public function dbActualizar(): bool;

    /*
     *
     * Operaciones DELETE.
     *  
     */

    /**
     * Elimina un objeto de la base de datos.
     * 
     * @requires      El objeto existe.
     * 
     * @param int $id Identificador del objeto.
     * 
     * @return bool   Resultado de la ejecución de la sentencia.
     */
    public static function dbEliminar(int $id): bool;
}

?>