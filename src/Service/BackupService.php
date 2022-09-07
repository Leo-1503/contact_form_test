<?php

namespace App\Service;

use App\Entity\Question;

class BackupService
{
    public function __construct(
        private string $filePath
    )
    { }

    public function backupToJson(Question $question) {
        $filePath = $this->filePath . '/data/json/';
        $fileName = $question->getId() . ' - ' . $question->getEmail() . '.json';

        file_put_contents(
            $filePath . $fileName,
            json_encode($question->toArray())
        );
    }
}