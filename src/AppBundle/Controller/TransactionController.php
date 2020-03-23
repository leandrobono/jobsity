<?php

namespace AppBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Resources\Constants;
use Appbundle\Exceptions\BadRequestException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Classes\User;
use AppBundle\Exceptions\UnauthorizedLoginException;

class TransactionController extends Controller
{
    private $_tools;
    private $_codeResponse;
    private $_messageResponse;

    public function transactionAction(Request $request) {
        try {
            $this->_tools  = $this->container->get('tools');

            $parameters = json_decode($request->getContent(), true);

            $params = explode(" ", $parameters["message"]);

            $transactionService = $this->container->get('TransactionService');
            $curr = $this->container->get('currency');
            $resu = $transactionService->transaction($params, $curr, $request->get("token"));

            $this->_codeResponse    = Constants::OPERATION_SUCCESS;
            $this->_messageResponse = $resu;
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

    public function balanceAction(Request $request) {
        try {
            $this->_tools  = $this->container->get('tools');

            $transactionService = $this->container->get('TransactionService');
            $resu = $transactionService->balance($request->get("token"));

            $this->_codeResponse    = Constants::OPERATION_SUCCESS;
            $this->_messageResponse = $resu;
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
}
