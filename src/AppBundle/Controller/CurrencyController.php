<?php

namespace AppBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Resources\Constants;
use AppBundle\Exceptions\BadRequestException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Classes\User;
use AppBundle\Exceptions\UnauthorizedLoginException;

class CurrencyController extends Controller
{
    private $_tools;
    private $_codeResponse;
    private $_messageResponse;

    public function convertAction(Request $request) {
        try {
            $this->_tools  = $this->container->get('tools');

            $parameters = $request->query->get("message");

            $params = explode(" ", $parameters);

            if (isset($params[0]) && isset($params[1]) && isset($params[2]) && (sizeof($params) == 3)) {
                if (!is_numeric($params[2])) {
                    throw new BadRequestException('Invalid amount!');
                }

                $curr = $this->container->get('currency');
                $res = $curr->convert($params[0], $params[1], $params[2]);

                $this->_codeResponse    = Constants::OPERATION_SUCCESS;
                $this->_messageResponse = $res;
            } else {
                throw new BadRequestException('To make a conversion, mandatory fields are: fromCurrency toCurrency amount.');
            }
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
