<?php

namespace App\Controller;

use App\ApiResource\InvestmentResource;
use App\ApiResource\UserResource;
use App\Entity\User;
use App\Repository\InvestmentRepository;
use App\Repository\UserRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user", methods={"GET"})
     */
    public function index(ManagerRegistry $registry): Response
    {
        $userRepository = new UserRepository($registry);
        $users = $userRepository->findAll();
        return $this->json([
            'data' => (new UserResource)->collection($users),
        ]);
    }

    /**
     * @param Request $request
     * @param ManagerRegistry $registry
     *
     * @Route("/user", methods={"POST"})
     */
    public function create(Request $request, ManagerRegistry $registry) {
        $userRepository = new UserRepository($registry);

        $user = new User();
        $user->setName($request->toArray()['name']);

        $userRepository->add($user);

        return $this->json([
            "data" => (new UserResource)->make($user)
        ]);
    }

    /**
     * @param Request $request
     * @param ManagerRegistry $registry
     * @param $id
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route("/user/{id}", methods={"PUT"})
     */
    public function update(Request $request, ManagerRegistry $registry, $id) {
        $userRepository = new UserRepository($registry);

        $user = $userRepository->find($id);
        $user->setName($request->toArray()['name']);

        $userRepository->add($user);

        return $this->json([
            "data" => (new UserResource)->make($user)
        ]);
    }

    /**
     * @Route("/user/{id}", methods={"GET"})
     */
    public function find($id, ManagerRegistry $registry) {
        $userRepository = new UserRepository($registry);
        $user = $userRepository->find($id);
        return $this->json([
            "data" => (new UserResource)->make($user),
        ]);
    }

    /**
     * @Route("/user/{id}/investments", methods={"GET"})
     */
    public function investments($id, Request $request, PaginatorInterface $paginator, ManagerRegistry $registry) {
        $userRepossitory = new UserRepository($registry);
        $investmentRepository = new InvestmentRepository($registry);

        $user = $userRepossitory->find($id);

        $page = $request->query->get("page") ?? 1;
        $perPage = $request->query->get("perPage") ?? 25;

        $investments = $investmentRepository->findByUserPaginated($paginator, $user->getId(), $page, $perPage);

        return $this->json([
            "data" => (new InvestmentResource)->collection($investments->getItems()),
            "page" => $page,
            "per_page" => $perPage,
            "total" => $investments->getTotalItemCount()
        ]);
    }
}
