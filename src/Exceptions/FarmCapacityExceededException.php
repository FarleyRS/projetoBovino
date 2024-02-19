<?php

namespace App\Exception;

use Exception;

class FarmCapacityExceededException extends \Exception
{
    public function __construct($message = "A fazenda excedeu a capacidade máxima de animais por hectare.", $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
