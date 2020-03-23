<?php
namespace AppBundle\Exceptions;
use Exception;
use AppBundle\Resources\Constants;

class NoAuthorizationActionException extends Exception implements ExceptionInterface {
    private $_message;

    public function __construct($message = Constants::NO_AUTHORIZATION_ACTION_DEFAULT_MESSAGE, $code = 0) {
        $this->_message = $message;
        $this->code = $code;
    }

    public function getErrorMessage() {
        return $this->_message;
    }
}