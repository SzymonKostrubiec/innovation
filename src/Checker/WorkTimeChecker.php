<?php

namespace App\Checker;

use App\Entity\WorkTime;
use App\Repository\WorkTimeRepository;

final class WorkTimeChecker implements WorkTimeCheckerInterface
{
    public function __construct(
        private readonly WorkTimeRepository $workTimeRepository,
    )
    {
    }

    public function checkWorkTime(WorkTime $workTime):bool
    {
        if($this->canAddTime($workTime) && $this->givenTimeIsCorrect($workTime) ) {
            return true;
        }

        return false;
    }

    private function canAddTime(WorkTime $workTime): bool
    {
        $data = $this->workTimeRepository->findOneBy([
            'startDay' => $workTime->getStartDay(),
            'employee' => $workTime->getEmployee(),
        ]);
        if(null === $data){
            return true;
        }

        throw new \Exception("Work Time is already added.");
    }

    private function givenTimeIsCorrect(WorkTime $workTime): bool
    {

        /** @var \DateTimeInterface $startDate */
        $startDate = $workTime->getStartDate();
        /** @var \DateTimeInterface $endDate */
        $endDate = $workTime->getEndDate();

        if ($startDate >= $endDate) {
            throw new \Exception("Start date must be earlier than end date.");
        }

        $interval = $startDate->diff($endDate);
        $totalHours = $interval->days * 24 + $interval->h;

        if ($totalHours > 12) {
            throw new \Exception("Work time must not exceed 12 hours.");
        }

        return true;
    }
}