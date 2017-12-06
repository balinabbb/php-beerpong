<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Cup;
use AppBundle\Transformers\CupTransformer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Doctrine\ORM\Tools\Pagination\Paginator;

class CupController extends BaseController
{

    public function __construct(RouterInterface $router)
    {
        parent::__construct($router, 'listCups');
        $this->setTransformers(new CupTransformer($router));
    }

    /**
     * @Route("/cups", name="listCups")
     * @Method({"GET"})
     */
    public function listAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Cup::class);
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
     * @Route("/cups", name="createCup")
     * @Method({"POST"})
     */
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $data = json_decode($request->getContent(), true);

        $entity = new Cup();
        $entity->setDate(\DateTime::createFromFormat('Y-m-d', $data['date']));

        $errors = $this->container->get('validator')->validate($entity);

        if (count($errors) > 0) {
            throw new BadRequestHttpException($errors[0]->getMessage());
        }

        $em->persist($entity);
        $em->flush();

        return $this->single($entity, 201);
    }

    /**
     * @Route("/cups/{id}", requirements={"id" = "\d+"}, name="deleteCup")
     * @Method({"DELETE"})
     */
    public function deleteAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(Cup::class)->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('No post found for id '.$id);
        }
        $em->remove($entity);
        $em->flush();
        return $this->noContent();
    }
}
