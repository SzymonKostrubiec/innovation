<?php

namespace App\Creator;

use App\Entity\WorkTime;
use Doctrine\ORM\EntityManagerInterface;

class WorkTimeCreator implements WorkTimeCreatorInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ){
    }

    public function createFromEntity(WorkTime $workTime): WorkTime
    {
        $this->entityManager->persist($workTime);
        $this->entityManager->flush();

        return $workTime;
    }
}