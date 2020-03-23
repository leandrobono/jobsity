<?php
namespace AppBundle\Exceptions;
use Exception;
use AppBundle\Resources\Constants;

class IncompleteOrWrongBodyRequestException extends Exception implements ExceptionInterface {
    private $_message;

    public function __construct($message = Constants::INCOMPLETE_OR_WRONG_BODY_REQUESTS_DEFAULT_MESSAGE) {
        $this->_message = $message;
    }

    public function getErrorMessage() {
        return $this->_message;
    }
}