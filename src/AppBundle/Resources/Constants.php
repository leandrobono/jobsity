<?php

namespace AppBundle\Resources;

class Constants {
    //HTTP RESPONSES
    const OPERATION_SUCCESS         = 200;
    const SOURCE_UPDATED            = 200;
    const SOURCE_CREATED            = 201;
    const ACCEPTED_NOT_FINISHED_YET = 202;
    const SOURCE_DELETED            = 204;
    const SOURCE_PATCHED            = 204;
    const REQUEST_BAD_FORMED        = 400;
    const UNAUTHORIZED              = 401;
    const NO_PERMISSION             = 403;
    const NOT_FOUND                 = 404;
    const NOT_SUPPORTED_METHOD      = 405;
    const INTERNAL_SERVER_ERROR     = 500;

    //DEFAULT MESSAGES FOR EXCEPTIONS
    const BAD_REQUEST_DEFAULT_MESSAGE                       = 'Error in the request. Check the header and body of the request';
    const DATA_BASE_ERROR_DEFAUTL_MESSAGE                   = 'An error has occurred in the database';
    const NO_AUTHORIZATION_ACTION_DEFAULT_MESSAGE           = 'You do not have the permissions to execute the requested action';
    const INCOMPLETE_OR_WRONG_BODY_REQUESTS_DEFAULT_MESSAGE = 'The body of the request is incomplete or wrong. Please verify that all required fields are being sent';
    const UNAUTHORIZED_LOGIN                                = 'Unauthorized Login';
    const UNAUTHORIZED_LOGIN_NOT_ACTIVE                     = 'Account is not active';
    const SESSION_EXPIRED                                   = 'The session has expired';
    
    const PASS_CRYPT_ALGORITM = 'sha256';
}
