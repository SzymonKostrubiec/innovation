<?php

namespace App\Factory;

use App\Dto\WorktimeDto;
use App\Entity\WorkTime;
use App\Resolver\EmployeeResolver;


final class WorkTimeFactory implements WorkTimeFactoryInterface
{
    public function __construct(
        private readonly EmployeeResolver $employeeResolver,
    ){
    }

    public function create( WorktimeDto $workTimeDto ): WorkTime
    {
        $employee = $this->employeeResolver->resolveByUuid($workTimeDto->uuid);
        $workTime = new WorkTime();

        /** @var string $startDate */
        $startDate = $workTimeDto->startDate;
        /** @var string $endDate */
        $endDate = $workTimeDto->endDate;

        $workTime->setEmployee($employee);
        $workTime->setStartDate(new \DateTime($startDate));
        $workTime->setEndDate(new \DateTime($endDate));
        $workTime->setStartDay(new \DateTime($startDate));
        return $workTime;
    }
}