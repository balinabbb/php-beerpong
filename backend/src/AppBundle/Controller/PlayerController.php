<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Player;
use AppBundle\Transformers\PlayerTransformer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Doctrine\ORM\Tools\Pagination\Paginator;

class PlayerController extends BaseController
{

    public function __construct(RouterInterface $router)
    {
        parent::__construct($router, 'listPlayers');
        $this->setTransformers(new PlayerTransformer($router));
    }

    /**
     * @Route("/players", name="listPlayers")
     * @Method({"GET"})
     */
    public function listAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Player::class);
        $limit = (int) $request->get('limit', 10);
        $page = (int) $request->get('page', 1);
        $count = (int) $repository->createQueryBuilder('p')->select('COUNT(p.id)')->getQuery()->getSingleScalarResult();
        $restresult = $repository->createQueryBuilder('p')
                    ->select()
                    ->setFirstResult($limit * ($page - 1))
                    ->setMaxResults($limit)
                    ->getQuery()
                    ->getResult();

        if ($restresult === null) {
            throw $this->createNotFoundException('No posts found.');
        }

        return $this->collection($restresult, $count, $limit, $page);
    }

    /**
     * @Route("/players", name="createPlayer")
     * @Method({"POST"})
     */
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $data = json_decode($request->getContent(), true);

        $entity = new Player();
        $entity->fill($data);

        $errors = $this->container->get('validator')->validate($entity);

        if (count($errors) > 0) {
            throw new BadRequestHttpException($errors[0]->getMessage());
        }

        $em->persist($entity);
        $em->flush();

        return $this->single($entity, 201);
    }

    /**
     * @Route("/players/{id}", requirements={"id" = "\d+"}, name="deletePlayer")
     * @Method({"DELETE"})
     */
    public function deleteAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(Player::class)->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('No post found for id '.$id);
        }
        $em->remove($entity);
        $em->flush();
        return $this->noContent();
    }
}
