<?php

namespace AppBundle\Transformers;

use AppBundle\Entity\Player;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PlayerTransformer implements IDataTransformer {

    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function transform($data)
    {
        if (!($data instanceof Player)) {
            throw new \InvalidArgumentException("Data must be of type Player::class");
        }

        $result = array(
            'type' => 'player',
            'id' => $data->getId(),
            'name' => $data->getName(),
            'links' => array(
//                'self' => $this->router->generate('getPost', array('id' => $data->getId()), UrlGeneratorInterface::ABSOLUTE_URL),
            ),
        );

        return $result;
    }

}
