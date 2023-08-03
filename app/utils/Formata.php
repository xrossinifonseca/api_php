<?php

namespace App\Utils;

class Formata
{

    public function removeCharacters($value)
    {
        $value = preg_replace('/[^0-9]/', "", $value);

        return $value;
    }
}
