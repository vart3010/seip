<?php

namespace Pequiven\ArrangementProgramBundle\Model\MovementEmployee;

use Pequiven\SEIPBundle\Model\BaseModel;


abstract class MovementEmployee extends BaseModel implements MovementEmployeeInterface{
    const ASIGNACION = 1;
    const SUPLENCIA = 2;
    const CAMIO = 3;
    const RETIRO = 4;
}