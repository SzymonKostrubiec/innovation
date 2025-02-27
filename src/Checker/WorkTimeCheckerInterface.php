<?php

namespace App\Checker;

use App\Entity\WorkTime;

interface WorkTimeCheckerInterface
{
    public function checkWorkTime(WorkTime $workTime):bool;
}