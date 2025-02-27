<?php

namespace App\Factory;

use App\Dto\EmployeeDto;
use App\Entity\Employee;

interface EmployeeFactoryInterface
{
    public function create(EmployeeDto $employeeDto): Employee;
}