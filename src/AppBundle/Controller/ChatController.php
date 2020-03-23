<?php

namespace AppBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Resources\Constants;
use Appbundle\Exceptions\BadRequestException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Exceptions\UnauthorizedLoginException;

class ChatController extends Controller
{

    public function indexAction(Request $request) {
        return $this->render('base.html.twig', []);
    }
}
