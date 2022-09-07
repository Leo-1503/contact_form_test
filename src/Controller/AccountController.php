<?php

namespace App\Controller;

use App\Entity\Question;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Service\QuestionService;
use Symfony\Component\Routing\Annotation\Route;


class AccountController extends AbstractController
{

    public function __construct(
        private QuestionService $questionService,
    )
    { }

    #[Route('/account', name: 'app_account')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $questions = $doctrine->getRepository(Question::class)->findBy([],
            ['checked'=> 'ASC','email' => 'DESC']
        );

        return $this->render('account/index.html.twig', [
            'questions' => $questions,
        ]);
    }

    //Lire les messages
    #[Route('/account/{id}', name: 'message_show')]
    public function show(Question $question): Response{

        return $this->render('account/show.html.twig', [
            'question' => $question,
        ]);
    }

    //Checker les message lus"
    #[Route('/account/check/{id}', name: 'edit_checked', methods: ['POST', 'GET'])]
    public function edit(Question $question): Response {
        $this->questionService->setCheckedState($question);

        return new JsonResponse(null, Response::HTTP_OK);
    }

}
