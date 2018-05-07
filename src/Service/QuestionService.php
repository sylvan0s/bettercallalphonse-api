<?php

namespace App\Service;

use App\Entity\Question;
use App\Repository\QuestionRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class QuestionService
{
    private $tokenStorage;
    private $questionRepository;

    public function __construct(TokenStorageInterface $tokenStorage, QuestionRepository $questionRepository)
    {
        $this->tokenStorage = $tokenStorage;
        $this->questionRepository = $questionRepository;
    }

    public function doSomething() : Question
    {
        $roles = $this->tokenStorage->getToken()->getRoles();
        $user = $this->tokenStorage->getToken()->getUser();

        return new Question();
    }
}