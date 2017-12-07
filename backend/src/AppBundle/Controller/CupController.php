<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Cup;
use AppBundle\Entity\Player;
use AppBundle\Entity\Result;
use AppBundle\Transformers\CupTransformer;
use AppBundle\Transformers\ResultTransformer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Doctrine\ORM\Tools\Pagination\Paginator;

class CupController extends BaseController
{
    private $routerInterface;

    public function __construct(RouterInterface $router)
    {
        parent::__construct($router, 'listCups');
        $this->routerInterface = $router;
        $this->setTransformers(new CupTransformer($router));
    }

    /**
     * @Route("/cups", name="listCups")
     * @Method({"GET"})
     */
    public function listAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Cup::class);
        $limit = (int)$request->get('limit', 10);
        $page = (int)$request->get('page', 1);
        $count = (int)$repository->createQueryBuilder('p')->select('COUNT(p.id)')->getQuery()->getSingleScalarResult();
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
     * @Route("/cups/{id}", requirements={"id" = "\d+"}, name="getCupResults")
     * @Method({"GET"})
     */
    public function cupResultsAction($id, Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Result::class);
        $restresult = $repository->createQueryBuilder('p')
            ->select()
            ->where('IDENTITY(p.cup) = ?1')
            ->setParameter(1, $id)
            ->getQuery()
            ->getResult();

        if ($restresult === null) {
            throw $this->createNotFoundException('No results found.');
        }

        $transformer = new ResultTransformer();
        $result = array(
            'data' => array(),
        );

        foreach ($restresult as $key => $value) {
            $result['data'][] = $transformer->transform($value);
        }

        $response = new JsonResponse($result, 200);
        return $response;
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
     * @Route("/cups/{id}", requirements={"id" = "\d+"}, name="addCupResult")
     * @Method({"PUT"})
     */
    public function addCupResultAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $cup = $em->getRepository(Cup::class)->find($id);
        if (!$cup) {
            throw $this->createNotFoundException('No cup found for id ' . $id);
        }

        $data = json_decode($request->getContent(), true);
        $team1Result = $data['team1Result'];
        $team2Result = $data['team2Result'];
        $playerIds = $data['players'];
        $playerEntities = [];
        foreach ($playerIds as $playerId) {
            $player = $em->getRepository(Player::class)->find($playerId);
            if(!$player)
                throw $this->createNotFoundException('No player found for id ' . $playerId);
            $playerEntities []= $player;
        }

        $result = new Result();

        $result->setCup($cup);
        $result->setTeam1score($team1Result);
        $result->setTeam2score($team2Result);

        $result->setTeam1player1($playerEntities[0]);
        $result->setTeam1player2($playerEntities[1]);
        $result->setTeam2player1($playerEntities[2]);
        $result->setTeam2player2($playerEntities[3]);

        $em->persist($result);
        $em->flush();

        return $this->noContent();
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
            throw $this->createNotFoundException('No post found for id ' . $id);
        }
        $em->remove($entity);
        $em->flush();
        return $this->noContent();
    }
}
