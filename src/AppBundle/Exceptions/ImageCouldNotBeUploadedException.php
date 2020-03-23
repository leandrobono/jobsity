<?php
namespace AppBundle\Exceptions;
use Exception;
use AppBundle\Resources\Constants;

class ImageCouldNotBeUploadedException extends Exception implements ExceptionInterface {
    private $_message;

    public function __construct($message = Constants::IMAGE_COULD_NOT_BE_UPLOADED_DEFAULT_MESSAGE) {
        $this->_message = $message;
    }

    public function getErrorMessage() {
        return $this->_message;
    }
}