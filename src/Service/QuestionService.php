<?php

namespace App\Service;

use App\Entity\Question;
use Doctrine\ORM\EntityManagerInterface;

class QuestionService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private BackupService $backupService
    )
    { }

    public function createFrom($form) {
        $question = $form->getData();
        $this->entityManager->persist($question);
        $this->entityManager->flush();

        $this->backupService->backupToJson($question);
    }

    public function setCheckedState(Question $question){
        $question->setChecked(true);
        $this->entityManager->persist($question);
        $this->entityManager->flush();
    }

}