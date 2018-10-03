<?php

namespace App\Service;

use App\Entity\User;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService
{

    private $encoder;
    private $passwordNbChars = 8;
    private $passwordAllowedChars = '23456789azertyuiopqsdfghjkmwxcvbnAZERTYUIPMLKJHGFDSQWXCVBN?!$@-_';

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }


    /**
     * @param User $user
     * @return string
     */
    public function activate(User &$user)
    {
        $newPassword = '';
        // on vire les caractères ressemblants genre 0O ou 1l

        $c = strlen($this->passwordAllowedChars)-1;
        $i = 0;
        while($i < $this->passwordNbChars){
            $newPassword .= $this->passwordAllowedChars[rand(0,$c)];
            $i++;
        }

        $encodedPassword = $this->encoder->encodePassword($user, $newPassword);
        $user->setPassword($encodedPassword);
        $user->setIsActive(1);
        $user->setNbFailedConnexion(0);

        return $user;
    }



}
