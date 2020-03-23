<?php

namespace AppBundle\Services;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;
use AppBundle\Resources\Constants;
use AppBundle\Exceptions\UnauthorizedLoginException;

class Tools {
    public $jwt_auth;
    public $path_log;

    public function __construct($jwt_auth, $path_log) {
        $this->jwt_auth   = $jwt_auth;
        $this->path_log   = $path_log;
    }

    public function login($username, $password) {
        try {
            $jwt_auth = $this->jwt_auth;

            return $jwt_auth->signup($username, $password);
        } catch(UnauthorizedLoginException $e) {
            throw new UnauthorizedLoginException($e->getErrorMessage());
        }
    }
    public function authCheck($hash) {
        $jwt_auth = $this->jwt_auth;

        return $jwt_auth->checkToken($hash);
    }

    public function response(
        $status  = 200,
        $msg     = null,
        $data    = null,
        $headers = array()
    ) {
        $normalizers = array(new GetSetMethodNormalizer());
        $encoders    = array("json" => new JsonEncode());
        $serializer  = new Serializer($normalizers, $encoders);
        $json        = $serializer->serialize($this->getDataResponse($msg, $data), "json");
        $response    = new Response();

        if (!empty($msg) OR !empty($data)) {
            $response->setContent($json);
        }

        $response->setStatusCode($status);
        $response->headers->set("Content-Type", "application/json");

        foreach ($headers as $header) {
            $response->headers->set($header[0], $header[1]);
        }

        return $response;
    }

    public function getDataResponse($msg, $data) {
        $return = array();

        if (!empty($msg)) {
            $return['message'] = $msg;
        }

        if (!empty($data)) {
            $return['data'] = $data;
        }

        return $return;
    }

    public function getEntityResponse() {
        return array(
            'error' => 0,
            'msg'   =>'Operation Success'
        );
    }

    public function json($data, $status = 200, $headers = Array(), $context = Array()) {
        $normalizers = array(new GetSetMethodNormalizer());
        $encoders    = array("json" => new JsonEncode());
        $serializer  = new Serializer($normalizers, $encoders);
        $json        = $serializer->serialize($data, "json");
        $response    = new Response();
        $response->setContent($json);
        $response->headers->set("Content-Type", "application/json");

        return $response;
    }

    public function object_to_array($obj) {
        if(is_object($obj)) $obj = (array) $obj;
        if(is_array($obj)) {
            $new = array();
            foreach($obj as $key => $val) {
                $new[$key] = $this->object_to_array($val);
            }
        }
        else $new = $obj;
        return $new;
    }

    public function getTimeStamp($stringDate, $withHour = false) {
        //Espera el formato dd/mm/aaaa [18:00:00]
        if ($withHour) {
            $arrTmp = explode(' ', $stringDate);

            //fecha
            $arrDate = explode('/', $arrTmp[0]);

            //hora
            $arrHour = explode(':', $arrTmp[1]);

            return mktime(
                $arrHour[0],
                $arrHour[1],
                $arrHour[2],
                $arrDate[1],
                $arrDate[0],
                $arrDate[2]
            );
        } else {
            $arr = explode('/', $stringDate);
            return mktime(0, 0, 0, $arr[1], $arr[0], $arr[2]);
        }
    }

    public function getSalesChannels($string) {
        switch($string) {
            case 'ALL':
                return Constants::ALL;
                break;
            case 'ONLY_SELECTED':
                return Constants::ONLY_SELECTED;
                break;
            default:
                return Constants::ALL;
                break;
        }
    }

    public function getSalesChannelsInverse($string) {
        switch($string) {
            case Constants::ALL:
                return 'ALL';
                break;
            case Constants::ONLY_SELECTED:
                return 'ONLY_SELECTED';
                break;
            default:
                return 'ALL';
                break;
        }
    }

    public function getStatus($status) {
        switch($status) {
            case 'ONSALE':
                return Constants::ONSALE;
                break;
            case 'SOLDOUT':
                return Constants::SOLDOUT;
                break;
            default:
                return Constants::ONSALE;
                break;
        }
    }

    public function getStatusInverse($status) {
        switch($status) {
            case Constants::ONSALE:
                return 'ONSALE';
                break;
            case Constants::SOLDOUT:
                return 'SOLDOUT';
                break;
            default:
                return 'ONSALE';
                break;
        }
    }
    /**
    const PUBLIC_VISIBILITY = 1;
    const PRIVATE_VISIBILITY = 2;
    const PRIVATE_PRIME_VISIBILITY = 3;
     */
    public function getVisibility($status) {
        switch($status) {
            case 'PUBLIC_VISIBILITY':
                return Constants::PUBLIC_VISIBILITY;
                break;
            case 'PRIVATE_VISIBILITY':
                return Constants::PRIVATE_VISIBILITY;
                break;
            case 'PRIVATE_PRIME_VISIBILITY':
                return Constants::PRIVATE_PRIME_VISIBILITY;
                break;
            default:
                throw new IncompleteOrWrongBodyRequestException("Incorrect Visibility Type");
                break;
        }
    }

    public function getVisibilityInverse($status) {
        switch($status) {
            case Constants::PUBLIC_VISIBILITY:
                return 'PUBLIC_VISIBILITY';
                break;
            case Constants::PRIVATE_VISIBILITY:
                return 'PRIVATE_VISIBILITY';
                break;
            case Constants::PRIVATE_PRIME_VISIBILITY:
                return 'PRIVATE_PRIME_VISIBILITY';
                break;
            default:
                return 'PUBLIC_VISIBILITY';
                break;
        }
    }

    public function getGenre($genre) {
        $genre = strtoupper($genre);

        switch ($genre) {
            case 'MALE':
                return Constants::MALE_GENRE;
                break;
            case 'FEMALE':
                return Constants::FEMALE_GENRE;
                break;
            case 'ALL':
                return Constants::ALL_GENRE;
                break;
            default:
                return Constants::ALL_GENRE;
                break;
        }
    }

    public function getGenreInverse($genre) {
        switch ($genre) {
            case Constants::MALE_GENRE:
                return 'MALE';
                break;
            case Constants::FEMALE_GENRE:
                return 'FEMALE';
                break;
            default:
                return 'MALE';
                break;
        }
    }

    public function getBlockStatus($status) {

        switch ($status) {
            case 'USER_BLOCK':
                return Constants::USER_BLOCK;
                break;
            case 'USER_BLOCK_PERMANENTLY':
                return Constants::USER_BLOCK_PERMANENTLY;
        }
    }

    public function getBlockStatusInverse($status) {

        switch ($status) {
            case Constants::USER_BLOCK:
                return 'USER_BLOCK';
                break;
            case Constants::USER_BLOCK_PERMANENTLY:
                return 'USER_BLOCK_PERMANENTLY';
        }
    }

    public function getIn($status) {

        switch ($status) {
            case 'IN':
                return Constants::IN;
                break;
            case 'OUT':
                return Constants::OUT;
        }
    }

    public function getInInverse($status) {

        switch ($status) {
            case Constants::IN:
                return 'IN';
                break;
            case Constants::OUT:
                return 'OUT';
        }
    }
    
    public static function getHashToLoginMail($email, $uuid, $apellido)
    {
        return $uuid . "-" . md5($uuid . $uuid) . "-" . md5($uuid . $apellido . $email);
    }
    
}