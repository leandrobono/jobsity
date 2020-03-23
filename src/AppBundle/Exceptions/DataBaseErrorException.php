<?php
namespace AppBundle\Exceptions;
use Exception;
use AppBundle\Resources\Constants;

class DataBaseErrorException extends Exception implements ExceptionInterface {
    private $_message;

    public function __construct($message = Constants::DATA_BASE_ERROR_DEFAUTL_MESSAGE) {
        $this->_message = $message;
    }

    public function getErrorMessage() {
        return $this->_message;
    }
}