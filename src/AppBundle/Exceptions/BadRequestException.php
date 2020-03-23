<?php
namespace AppBundle\Exceptions;
use Exception;
use AppBundle\Resources\Constants;

class BadRequestException extends Exception implements ExceptionInterface {

    private $_message;

    public function __construct($message = Constants::BAD_REQUEST_DEFAULT_MESSAGE) {
        $this->_message = $message;
    }

    public function getErrorMessage() {
        return $this->_message;
    }
}