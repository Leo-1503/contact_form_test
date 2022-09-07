<?php

namespace App\Controller;

use App\Entity\Question;
use App\Form\ContactType;
use App\Service\QuestionService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{

    public function __construct(
        private QuestionService $questionService,
    )
    { }

    #[Route('/', name: 'app_contact')]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $this->questionService->createFrom($form);

            $this->addFlash('notice', 'Merci de nous avoir contactés. Notre équipe va vous répondre dans les meilleurs délais.');
            return $this->redirectToRoute('app_contact');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
