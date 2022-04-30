<?php

namespace App\Controller;

use App\ApiResource\WithdrawResource;
use App\Repository\InvestmentRepository;
use App\Repository\WithdrawRepository;
use App\Service\InvestmentService;
use App\Service\WithdrawService;
use App\Validator\WithdrawCreateValidator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WithdrawController extends AbstractController
{
    /**
     * @Route("/withdraw", methods={"GET"})
     */
    public function index(ManagerRegistry $registry): Response
    {
        $withdrawRepository = new WithdrawRepository($registry);

        $withdraws = $withdrawRepository->findAll();

        return $this->json([
            "data" => (new WithdrawResource)->collection($withdraws)
        ]);
    }

    /**
     * @Route("/withdraw", methods={"POST"})
     */
    public function create(Request $request, ManagerRegistry $registry) {
        $withdrawRepository = new WithdrawRepository($registry);
        $investmentRepository = new InvestmentRepository($registry);
        $requestValues = $request->toArray();
        $investment = $investmentRepository->find($requestValues['investment_id']);

        WithdrawCreateValidator::validate($investment, $requestValues);

        $createdAt = isset($requestValues['created_at'])
            ? new \DateTimeImmutable($requestValues['created_at'])
            : new \DateTimeImmutable();
        $data = [
            "gross_amount" => 0,
            "amount" => 0,
            "taxes" => 0,
            "investment" => $investment,
            "created_at" => $createdAt
        ];
        $withdraw = WithdrawService::entityMassAssigned($data);

        $withdrawRepository->add($withdraw);
        $investment->setWithdraw($withdraw);

        $taxes = InvestmentService::getTaxation($investment);
        $totalAmount = InvestmentService::totalAmount($investment);
        $withdraw->setGrossAmount($totalAmount);
        $withdraw->setAmount($totalAmount - $taxes);
        $withdraw->setTaxes($taxes);
        $withdrawRepository->add($withdraw);

        return $this->json([
            "data" => (new WithdrawResource)->make($withdraw)
        ]);
    }

    /**
     * @Route("/withdraw/{id}", methods={"GET"})
     */
    public function find($id, ManagerRegistry $registry) {
        $withdrawRepository = new WithdrawRepository($registry);

        $withdraw = $withdrawRepository->find($id);

        return $this->json([
            "data" => (new WithdrawResource)->make($withdraw)
        ]);
    }
}
