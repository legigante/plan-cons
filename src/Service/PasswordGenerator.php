<?php

namespace App\Service;

class PasswordGenerator
{

    /**
     * @param $nb_chars
     * @return string
     */
    public function generate($nb_chars)
    {
        $newPassword = '';
        // on vire les caractères ressemblants genre 0O ou 1l
        $allowed_chars = '23456789azertyuiopqsdfghjkmwxcvbnAZERTYUIPMLKJHGFDSQWXCVBN?!$@-_';
        $c = strlen($allowed_chars)-1;
        $i = 0;
        while($i < $nb_chars){
            $newPassword .= $allowed_chars[rand(0,$c)];
            $i++;
        }
        return $newPassword;
    }

}
