<?php

namespace App\Controller;

use App\ApiResource\InvestmentResource;
use App\Repository\InvestmentRepository;
use App\Repository\UserRepository;
use App\Service\InvestmentService;
use App\Validator\InvesmentCreateValidator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InvestmentController extends AbstractController
{
    /**
     * @Route("/investment", methods={"GET"})
     */
    public function index(ManagerRegistry $registry): Response
    {
        $investmentRepository = new InvestmentRepository($registry);

        $investments = $investmentRepository->findAll();

        return $this->json([
            "data" => (new InvestmentResource)->collection($investments),
        ]);
    }

    /**
     * @Route("/investment", methods={"POST"})
     */
    public function create(Request $request, ManagerRegistry $registry) {
        $investmentRepository = new InvestmentRepository($registry);
        $userRepository = new UserRepository($registry);

        $data = $request->toArray();
        InvesmentCreateValidator::validate($data);

        $data['user'] = $userRepository->findOrFail($data['user_id']);
        $investment = InvestmentService::entityMassAssigned($data);

        $investmentRepository->add($investment);

        return $this->json([
            "data" => (new InvestmentResource)->make($investment)
        ]);
    }

    /**
     * @Route("/investment/{id}", methods={"GET"})
     */
    public function find($id, ManagerRegistry $registry) {
        $investmentRepository = new InvestmentRepository($registry);

        $investment = $investmentRepository->findOrFail($id);

        return $this->json([
            "data" => (new InvestmentResource)->make($investment)
        ]);
    }
}
