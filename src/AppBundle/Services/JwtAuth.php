<?php

namespace AppBundle\Services;

use AppBundle\Exceptions\NoAuthorizationActionException;
use AppBundle\Exceptions\UnauthorizedLoginException;
use AppBundle\Resources\Constants;
use Doctrine\Instantiator\Exception\UnexpectedValueException;
use Firebase\JWT\JWT;
use Symfony\Component\HttpKernel\Tests\Controller;

class JwtAuth {
    public  $manager;
    private $key;
    private $_algoritm;
    private $_expiration;
    private $_pass_crypt_algoritm;

    public function __construct($manager, $algoritm, $secretString, $expiration, $pass_crypt_algoritm) {
        $this->manager     = $manager;
        $this->_algoritm   = $algoritm;
        $this->key         = $secretString;
        $this->_expiration = $expiration;
        $this->_pass_crypt_algoritm = $pass_crypt_algoritm;
    }

    public function getUserByData($username, $password) {
        $user = $this->manager->getRepository("AppBundle:Users")->findOneBy(
            array(
                "username" => $username,
                "password" => $password
            )
        );

        return $user;
    }

    public function signup($username, $password) {
        $signup = false;
        $passwordEncoded = hash(Constants::PASS_CRYPT_ALGORITM, $password);
        //var_dump($passwordEncoded); die(Constants::PASS_CRYPT_ALGORITM);
        $user = $this->getUserByData($username, $passwordEncoded);

        if (is_object($user)) {
            $signup = true;
        }

        if ($signup) {
            $token = array(
                "id"             => $user->getId(),
                "username"       => $user->getUsername(),
                "password"       => $user->getPassword(),
                "currency"       => $user->getCurrency(),
                "iat"            => time()
            );

            //genera un hash
            $jwt = JWT::encode($token, $this->key, $this->_algoritm);

            if ($jwt) {
                return array("token" => $jwt, "message" => "User logged!");
            }
        } else {
            throw new UnauthorizedLoginException;
        }
    }

    public function checkToken($jwt) {
        try {
            $decoded = JWT::decode($jwt, $this->key, array($this->_algoritm));
        } catch(\UnexpectedValueException $e){
            throw new \UnexpectedValueException($e->getMessage());
        } catch(\DomainException $e){
            throw new \DomainException;
        }

        $user = $this->getUserByData($decoded->username, $decoded->password);

        //"sub" es el id del usuario
        if (is_object($user) && ((time() - $decoded->iat) < $this->_expiration)) {
            return $decoded;
        } else {
            throw new NoAuthorizationActionException(Constants::SESSION_EXPIRED, 401);
        }
    }
}