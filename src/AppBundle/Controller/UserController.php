<?php

namespace AppBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Resources\Constants;
use Appbundle\Exceptions\BadRequestException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Classes\User;
use AppBundle\Exceptions\UnauthorizedLoginException;

class UserController extends Controller
{
    private $_tools;
    private $_codeResponse;
    private $_messageResponse;

    public function createAction(Request $request) {
        try {
            $this->_tools  = $this->container->get('tools');

            $parameters = json_decode($request->getContent(), true);

            $params = explode(" ", $parameters["message"]);

            $userService = $this->container->get('UserService');
            $curr = $this->container->get('currency');
            $res = $userService->create($params, $curr, $this->getParameter("pass_crypt_algoritm"));

            $this->_codeResponse    = Constants::OPERATION_SUCCESS;
            $this->_messageResponse = $res;
        } catch(BadRequestException $e) {
            $this->_codeResponse    = Constants::REQUEST_BAD_FORMED;
            $this->_messageResponse = $e->getErrorMessage();
        } catch(DataBaseErrorException $e) {
            $this->_codeResponse    = Constants::REQUEST_BAD_FORMED;
            $this->_messageResponse = $e->getErrorMessage();
        }

        return $this->_tools->response(
            $this->_codeResponse,
            $this->_messageResponse
        );
    }

    public function loginAction(Request $request) {
        try {
            $this->_tools  = $this->container->get('tools');

            $parameters = json_decode($request->getContent(), true);

            $params = explode(" ", $parameters["message"]);

            $userService = $this->container->get('UserService');

            $this->_codeResponse    = Constants::OPERATION_SUCCESS;
            $this->_messageResponse = $userService->login($params);
        } catch(BadRequestException $e) {
            $this->_codeResponse    = Constants::REQUEST_BAD_FORMED;
            $this->_messageResponse = $e->getErrorMessage();
        } catch(UnauthorizedLoginException $e) {
            $this->_codeResponse    = Constants::UNAUTHORIZED;
            $this->_messageResponse = $e->getErrorMessage();
        }

        return $this->_tools->response(
            $this->_codeResponse,
            $this->_messageResponse
        );
    }
}
