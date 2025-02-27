<?php

namespace App\Creator;

use App\Entity\Employee;
use Doctrine\ORM\EntityManagerInterface;

final class EmployeeCreator implements EmployeeCreatorInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ){
    }

    public function createFromEntity(Employee $employee): Employee
    {
        $this->entityManager->persist($employee);
        $this->entityManager->flush();

        return $employee;
    }
}