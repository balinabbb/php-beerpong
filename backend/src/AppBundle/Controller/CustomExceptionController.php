<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CustomExceptionController extends Controller {

    private $is_debug = false;

    public function __construct($debug)
    {
        $this->is_debug = $debug;
    }

    public function showExceptionAction(Request $request, FlattenException $exception, DebugLoggerInterface $logger = null)
    {
        #print_r($exception);
        #die();
        $error = array(
            'status' => $exception->getStatusCode(),
            'error' => $exception->getMessage(),
            'class' => (new \ReflectionClass($exception->getClass()))->getShortName(),
        );
        if($this->is_debug) {
            $error['trace'] = $exception->getTrace();
        }
        return new JsonResponse($error, $exception->getStatusCode());
    }

}
