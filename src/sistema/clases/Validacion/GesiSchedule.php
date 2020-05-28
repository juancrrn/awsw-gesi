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

class GesiSchedule
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

                public function getInicio() : int
                {
                    return $this->horaInicio * 60 + $this->minutosInicio;
                }
            };
        }

        return $result;
    }
}

?>