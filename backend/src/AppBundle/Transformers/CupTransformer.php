<?php

namespace AppBundle\Transformers;

use AppBundle\Entity\Cup;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CupTransformer implements IDataTransformer {

    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function transform($data)
    {
        if (!($data instanceof Cup)) {
            throw new \InvalidArgumentException("Data must be of type Cup::class");
        }

        $result = array(
            'type' => 'cup',
            'id' => $data->getId(),
            'date' => $data->getDate()->format('Y-m-d'),
            'links' => array(
//                'self' => $this->router->generate('getPost', array('id' => $data->getId()), UrlGeneratorInterface::ABSOLUTE_URL),
            ),
        );

        return $result;
    }

}
