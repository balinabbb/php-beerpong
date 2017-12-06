<?php

namespace AppBundle\Transformers;

use OAuthBundle\Entity\User;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class UserTransformer implements IDataTransformer {

    private $router;

    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }

    public function transform($data)
    {
        if (!($data instanceof User)) {
            throw new \InvalidArgumentException("Data must be of type User::class");
        }

        $result = array(
            'type' => 'user',
            'id' => $data->getId(),
            'attributes' => array(
                'username' => $data->getUsername(),
                'email' => $data->getEmailCanonical(),
            ),
            'links' => array(
                #'self' => $this->router->generate('getPost', array('id' => $data->getId()), UrlGeneratorInterface::ABSOLUTE_URL),
            ),
        );

        return $result;
    }

}
