<?php

namespace Awsw\Gesi\Validacion;

/**
 * Esta clase representa una franja (slot) de un horario de Gesi.
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

class GesiScheduleSlot
{

    public $dia;
    public $horaInicio;
    public $minutosInicio;
    public $horaFinal;
    public $minutosFinal;
            
    public function __construct(
        $dia,
        $horaInicio,
        $minutosInicio,
        $horaFinal,
        $minutosFinal
    )
    {
        $this->dia = $dia;
        $this->horaInicio = $horaInicio;
        $this->minutosInicio = $minutosInicio;
        $this->horaFinal = $horaFinal;
        $this->minutosFinal = $minutosFinal;
    }

    public function getInicioEnMinutos() : int
    {
        return $this->horaInicio * 60 + $this->minutosInicio;
    }

    public function getFinalEnMinutos() : int
    {
        return $this->horaFinal * 60 + $this->minutosFinal;
    }

    public function getDuracionEnMinutos() : int
    {
        return $this->getFinalEnMinutos() - $this->getInicioEnMinutos();
    }

    /**
     * Valida un formato de horario Gesi.
     */
    public static function validaGesiSchedule(string $schedule) : bool
    {
        $day = '[LMXJVSD]{1}';
        $number = '(?:[0-9]{1,2})';
        $slot = "$day $number:$number $number:$number;";

        $format = "$slot";
        // TODO: comprobar que las horas son válidas.
        return preg_match_all("#$format#", $schedule) > 1;
    }

    /**
     * Convierte un formato de horario Gesi a array de objetos de franjas.
     */
    public static function convierteGesiSchedule(string $schedule) : array
    {
        $day = '([LMXJVSD]{1})';
        $number = '([0-9]{1,2})';
        $slot = "$day $number:$number $number:$number;";

        $format = "$slot";

        preg_match_all("#$format#", $schedule, $matches, PREG_OFFSET_CAPTURE);

        $result = array();

        $nTotal = sizeof($matches[0]);

        $dia = $matches[1];
        $horaInicio = $matches[2];
        $minutosInicio = $matches[3];
        $horaFinal = $matches[4];
        $minutosFinal = $matches[5];

        for ($i = 0; $i < $nTotal; $i++) {
            $result[] = new GesiScheduleSlot(
                $dia[$i][0],
                $horaInicio[$i][0],
                $minutosInicio[$i][0],
                $horaFinal[$i][0],
                $minutosFinal[$i][0]
            );
        }

        return $result;
    }
}

?>