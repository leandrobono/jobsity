<?php

namespace AppBundle\Classes;

use AppBundle\Exceptions\BadRequestException;
use AppBundle\Exceptions\IncompleteOrWrongBodyRequestException;

class Defaults {
    protected $_tools;

    public function __construct(
        $tools
    ) {
        $this->_tools = $tools;
    }

    public function login($json) {
        $this->_validateFields($json);

        return $this->_tools->login($json->email, $json->password);
    }
    
    public function forgetpass($json) {
        return $this->_tools->forgetpass($json->email);
    }
    
    public function authCheck($hash) {
        return $this->_tools->authCheck($hash);
    }

    private function _validateFields($json) {
        if (empty($json)) {
            throw new BadRequestException('Json not defined');
        }

        if (
            empty($json->email) ||
            empty($json->password)
        ) {
            throw new IncompleteOrWrongBodyRequestException;
        }
    }
}