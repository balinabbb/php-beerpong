<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Transformers\IDataTransformer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class BaseController extends Controller {

    private $transformer;
    private $router;
    private $routeName;

    public function __construct(RouterInterface $router, $routeName = '')
    {
        $this->router = $router;
        $this->routeName = $routeName;
    }

    protected function setTransformers(IDataTransformer $singleTransformer)
    {
        $this->transformer = $singleTransformer;
    }

    protected function single($object, $status = 200)
    {
        $response = new JsonResponse($this->transformer->transform($object), $status);
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    protected function collection($object, $count, $limit, $page, $status = 200)
    {
        if (!(is_array($object))) {
            throw new \InvalidArgumentException("Data must be an array of objects");
        }

        $pageCount = ceil($count / $limit);
        $nextPage = $page + 1;
        if($nextPage > $pageCount) {
            $nextPage = $pageCount;
        }
        $prevPage = $page - 1;
        if($prevPage < 1) {
            $prevPage = 1;
        }

        $result = array(
            'links' => array(
                'self' => $this->router->generate($this->routeName, array('page' => $page), UrlGeneratorInterface::ABSOLUTE_URL),
                'first' => $this->router->generate($this->routeName, array('page' => 1), UrlGeneratorInterface::ABSOLUTE_URL),
                'last' => $this->router->generate($this->routeName, array('page' => $pageCount), UrlGeneratorInterface::ABSOLUTE_URL),
                'next' => $this->router->generate($this->routeName, array('page' => $nextPage), UrlGeneratorInterface::ABSOLUTE_URL),
                'prev' => $this->router->generate($this->routeName, array('page' => $prevPage), UrlGeneratorInterface::ABSOLUTE_URL),
            ),
            'meta' => array(
                'count' => $count,
                'current_page' => $page,
                'limit' => $limit,
                'pages' => $pageCount,
            ),
            'data' => array(),
        );

        foreach ($object as $key => $value) {
            $result['data'][] = $this->transformer->transform($value);
        }

        $response = new JsonResponse($result, $status);
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    protected function noContent($status = 204)
    {
        return new JsonResponse(null, $status);
    }

}
