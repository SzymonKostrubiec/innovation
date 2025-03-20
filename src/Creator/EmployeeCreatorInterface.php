<?php

namespace App\Creator;

use App\Entity\Employee;

interface EmployeeCreatorInterface{
    public function createFromEntity(Employee $employee): Employee;
}