<?php

namespace App\Processor;

use App\Calculator\WorkSummaryCalculatorInterface;
use App\Entity\Employee;
use App\Enum\WorkSummaryEnum;
use App\Resolver\EmployeeResolver;
use App\Resolver\WorkSummaryResolver;

final class WorkSummaryProcessor
{
    public function __construct(
        private readonly EmployeeResolver $employeeResolver,
        private readonly WorkSummaryResolver $workSummaryResolver,
        private readonly WorkSummaryCalculatorInterface $workSummaryCalculator,

    ){
    }

    public function process(array $workSummaryRequest): array
    {
        $employee = $this->employeeResolver->resolveByUuid($workSummaryRequest['uuid']);
        $workData = $this->getWorkData($workSummaryRequest, $employee);

        $data = $this->workSummaryCalculator->getCalculatedData($workData);

       return $data;
    }

    private function getWorkData(array $workSummaryRequest, Employee $employee): array
    {
        if($workSummaryRequest['type'] === WorkSummaryEnum::MONTH->value){
            return $this->workSummaryResolver->resolveByMonth($employee, $workSummaryRequest['date']);
        }
        return $this->workSummaryResolver->resolveByDay($employee, $workSummaryRequest['date']);
    }

}