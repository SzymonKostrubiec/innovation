<?php

namespace App\Resolver;

use App\Entity\Employee;
use App\Repository\EmployeeRepository;
use Webmozart\Assert\Assert;

final class EmployeeResolver
{
    public function __construct(
        private readonly EmployeeRepository $employeeRepository,
    ){
    }

    public function resolveByUuid(string $uuid): Employee
    {
        Assert::notEmpty($uuid);
        $employee = $this->employeeRepository->findOneBy(['uuid' => $uuid]);
        Assert::notNull($employee, "Employee with uuid {$uuid} not found.");
        return $employee;
    }
}