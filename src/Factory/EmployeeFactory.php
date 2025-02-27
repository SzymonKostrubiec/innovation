<?php

namespace App\Factory;

use App\Dto\EmployeeDto;
use App\Entity\Employee;
use Symfony\Component\Uid\Uuid;

final class EmployeeFactory implements EmployeeFactoryInterface
{
    public function create(EmployeeDto $employeeDto): Employee
    {
        $employee = new Employee();
        $employee->setName($employeeDto->name);
        $employee->setUuid(Uuid::v4()->toRfc4122());
        $employee->setLastName($employeeDto->lastName);

        return $employee;
    }
}