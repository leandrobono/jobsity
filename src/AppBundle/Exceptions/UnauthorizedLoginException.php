<?php
namespace AppBundle\Exceptions;
use Exception;
use AppBundle\Resources\Constants;

class UnauthorizedLoginException extends Exception implements ExceptionInterface {
    private $_message;

    public function __construct($message = Constants::UNAUTHORIZED_LOGIN) {
        $this->_message = $message;
    }

    public function getErrorMessage() {
        return $this->_message;
    }
}