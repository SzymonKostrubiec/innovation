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

        /** @var string $employeeName */
        $employeeName = $employeeDto->name;
        /** @var string $employeeLastName */
        $employeeLastName = $employeeDto->lastName;

        $employee->setName($employeeName);
        $employee->setUuid(Uuid::v4()->toRfc4122());
        $employee->setLastName($employeeLastName);

        return $employee;
    }
}