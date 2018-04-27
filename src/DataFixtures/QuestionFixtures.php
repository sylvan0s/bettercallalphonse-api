<?php
// src/DataFixtures/AppFixtures.php
namespace App\DataFixtures;

use App\Entity\Question;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class QuestionFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // create 30 Question! Bam!
        for ($i = 0; $i < 50; $i++) {
            $question = new Question();
            $question->setLibelle('Question-' . $i);
            $question->setNoteMax(mt_rand(1, 100));
            $manager->persist($question);
        }

        $manager->flush();
    }
}