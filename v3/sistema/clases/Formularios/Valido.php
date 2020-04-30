<?php

/**
 * Validación de datos.
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

namespace Awsw\Gesi\Formularios;

class Valido
{
	/**
	 * Validate NIF or NIE
	 *
	 * @see http://www.interior.gob.es/web/servicios-al-ciudadano/dni/calculo-del-digito-de-control-del-nif-nie
	 *
	 * @param $nif NIF to be validated
	 *
	 * @return true if NIF or NIE valid format is found, else false
	 */
	public static function testNif($nif_nie) : bool {
		$nif_nie = strtoupper($nif_nie);

		/*
		 * Validate standard NIF.
		 */
		if (preg_match('/(^[0-9]{8}[A-Z]{1}$)/', $nif_nie)) {
			/* Check control digit. */
			if ($nif_nie[8] == substr('TRWAGMYFPDXBNJZSQVHLCKE', substr($nif_nie, 0, 8) % 23, 1)) {				
				return true;
			}
		}

		/**
		 * Validate standard NIE.
		 */
		if (preg_match('/(^[XYZ]{1}[0-9]{7}[A-Z]{1}$)/', $nif_nie)) {
			/* Check control digit after replacing first NIE digit. */
			if ($nif_nie[8] == substr('TRWAGMYFPDXBNJZSQVHLCKE', substr(str_replace(array('X','Y','Z'), array('0','1','2'), $nif_nie), 0, 8) % 23, 1)) {
				return true;
			}
		}

		/**
		 * Nothing valid found.
		 */
		return false;
	}

	/**
	 * Validate standard string: alphabetic characters, country-specific latin characters, spaces and dashes
	 *
	 * @see https://en.wikipedia.org/wiki/Latin-1_Supplement_%28Unicode_block%29
	 *
	 * @param $string String to be validated
	 *
	 * @return true if standard string valid format is found, else false
	 */
	public static function testStdString($string) : bool {
		return preg_match("/^[A-Za-z\x{00C0}-\x{00D6}\x{00D8}-\x{00f6}\x{00f8}-\x{00ff}\s-]{3,128}$/u", $string) ? true : false;
	}

	/**
	 * Validate password:
	 * - Any character
	 * - Between 8 and 64 characters
	 * - At least 1 lowercase letter
	 * - At least 1 uppercase letter
	 * - At least 1 number
	 *
	 * @see https://en.wikipedia.org/wiki/Latin-1_Supplement_%28Unicode_block%29
	 *
	 * @param $password Password to be validated
	 *
	 * @return true if valid password format is found, else false
	 */
	public static function testPassword($password) : bool {
		$general = preg_match("/^.{8,64}$/u", $password);
		$uppercase = preg_match("#[A-Z\x{00C0}-\x{00D6}\x{00D8}-\x{00DE}]#", $password);
		$lowercase = preg_match("#[a-z\x{00DF}-\x{00f6}\x{00f8}-\x{00ff}]#", $password);
		$number = preg_match("#[0-9]#", $password);
		return $general && $uppercase && $lowercase && $number;
	}

	/**
	 * Validate standard short string: alphabetic characters, country-specific latin characters, spaces and dashes
	 *
	 * @see https://en.wikipedia.org/wiki/Latin-1_Supplement_%28Unicode_block%29
	 *
	 * @param $string String to be validated
	 *
	 * @return true if standard short string valid format is found, else false
	 */
	public static function testStdShortString($string) : bool {
		return preg_match("/^[A-Za-z\x{00C0}-\x{00D6}\x{00D8}-\x{00f6}\x{00f8}-\x{00ff}\s-]{1,16}$/u", $string) ? true : false;
	}

	/**
	 * Validate email
	 *
	 * @param $email Email address to be validated
	 *
	 * @return true if email address valid format is found, else false
	 */
	public static function testEmail($email) : bool {
		return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
	}

	/**
	 * Validate phone number
	 *
	 * @param $phone_number Phone number to be validated
	 *
	 * @return true if valid phone number format is found, else false
	 */
	public static function testNumeroTelefono($phone_number) : bool {
		return preg_match("/^(\+[0-9]{1,4})?([\s0-9]*){4,15}$/", $phone_number) ? true : false;;
	}

	/**
	 * Validate URL
	 *
	 * @param $url URL to be validated
	 *
	 * @return true if valid URL format is found, else false
	 */
	public static function testURL($url) : bool {
		return filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_SCHEME_REQUIRED | FILTER_FLAG_HOST_REQUIRED) !== false;
	}

	/**
	 * Validate user address street type number
	 *
	 * @param $st_type User address street type number to be validated
	 *
	 * @return true if valid user address street type number format is found, else false
	 */
	public static function testStType($st_type) : bool {
		return filter_var($st_type, FILTER_VALIDATE_INT, array("options" => array("min_range" => 1, "max_range"=> 32))) !== false;
	}

	/**
	 * Validate standard integer
	 *
	 * @param $integer Integer to be validated
	 *
	 * @return true if valid standard integer format is found, else false
	 */
	public static function testStdInt($integer) : bool {
		return filter_var($integer, FILTER_VALIDATE_INT, array("options" => array("min_range" => 1, "max_range"=> 999999))) !== false;
	}

	/**
	 * Validatar fecha en formato dd/mm/yyyy
	 * 
	 * @see https://tools.ietf.org/html/rfc3339
	 * @see https://www.w3.org/TR/2011/WD-html-markup-20110405/input.date.html
	 *
	 * @param $date Date to be validated
	 *
	 * @return true if valid standard date format is found, else false
	 */
	public static function testDate($date) : bool {
		$format = 'd/m/Y';
		$d = \DateTime::createFromFormat($format, $date);
    	return $d && $d->format($format) == $date;
	}
}