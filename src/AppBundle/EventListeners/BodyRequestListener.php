<?php

namespace AppBundle\EventListeners;

use AppBundle\Classes\User;
use AppBundle\Exceptions\NoAuthorizationActionException;
use AppBundle\Resources\Constants;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Config\FileLocator;

/**
 * Class BodyRequestListener
 * @package AppBundle\EventListener
 */
class BodyRequestListener
{
    protected $_loginService;
    protected $_tools;
    protected $_rootDir;
    private   $_method;
    private   $_userData;
    private   $_secret;

    public function __construct($loginService, $tools, $rootDirectory, $secret) {
        $this->_loginService = $loginService;
        $this->_tools        = $tools;
        $this->_rootDir      = $rootDirectory;
        $this->_secret       = $secret;
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        if ($request->attributes->get('_route') != "chat") {
            $access_key = $request->query->get("access_key");
            if ($access_key != $this->_secret) {
                $response =  $this->_tools->response(Constants::UNAUTHORIZED, "Incorrect Access Key");
                $event->setResponse($response);
            }
        }

        $controller = explode("\\", $request->attributes->get('_controller'));

        $headers = $request->headers->all();
        $xAuth = null;
        if (isset($headers["x-auth"])) {
            $xAuth = $headers["x-auth"][0];
        }
        
        if(isset($controller[2])) {
            $this->_method = $this->_getMethod($request);
            $json = $request->get("data", null);
            $jsonDecoded = json_decode($json);
            $this->_validateMethod($request, $event, $jsonDecoded, $xAuth, $headers);
        }
    }

    private function _validateMethod($request, $event, $jsonDecoded, $xAuth = null, $headers = null) {
        $data = null;

        switch ($this->_method) {
            case 'Transaction::transaction':
                $data = $this->_validateToken($xAuth, $event);
                break;
            case 'Transaction::balance':
                $data = $this->_validateToken($xAuth, $event);
                break;
        }

        if ($data != null) {
            $request->attributes->set("token", $data);
        }
    }

    private function _validateToken($token, $event) {
        if ($token == null || empty($token)) {
            $response = $this->_tools->response(Constants::REQUEST_BAD_FORMED, 'Token is not defined');
            $event->setResponse($response);
        } else {
            try {
                return $this->_tools->authCheck($token);
            } catch (NoAuthorizationActionException $e) {
                $response =  $this->_tools->response(Constants::UNAUTHORIZED, $e->getErrorMessage());
                $event->setResponse($response);
            } catch (\UnexpectedValueException $e) {
                $response =  $this->_tools->response(Constants::UNAUTHORIZED, "Incorrect Token");
                $event->setResponse($response);
            } catch (\DomainException $e) {
                $response =  $this->_tools->response(Constants::UNAUTHORIZED, "Incorrect Token");
                $event->setResponse($response);
            }
        }
    }

    private function _getMethod($request) {
        $string = explode("\\", $request->attributes->get('_controller'));
        return str_replace(
            array("Action", "Controller"),
            "",
            $string[2]
        );
    }
}
