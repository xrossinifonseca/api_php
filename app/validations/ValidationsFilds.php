<?php


namespace App\Validations;



class ValidationsFilds
{

    public function isCpfValid($cpf)
    {

        $cpf = preg_replace('/[^0-9]/', "", $cpf);

        if (strlen($cpf) != 11) {
            return false;
        }

        // Verifica se todos os dígitos são iguais
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Verifica a validade do CPF usando o algoritmo de verificação
        if (strlen($cpf) === 11) {
            $sum = 0;
            for ($i = 0; $i < 9; $i++) {
                $sum += (int) $cpf[$i] * (10 - $i);
            }

            $remainder = $sum % 11;
            $digit1 = ($remainder < 2) ? 0 : 11 - $remainder;

            if ($cpf[9] != $digit1) {
                return false;
            }

            $sum = 0;
            for ($i = 0; $i < 10; $i++) {
                $sum += (int) $cpf[$i] * (11 - $i);
            }

            $remainder = $sum % 11;
            $digit2 = ($remainder < 2) ? 0 : 11 - $remainder;

            if ($cpf[10] != $digit2) {
                return false;
            }

            return true;
        }
    }
}
