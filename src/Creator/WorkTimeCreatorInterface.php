<?php

namespace App\Creator;

use App\Entity\WorkTime;

interface WorkTimeCreatorInterface
{
    public function createFromEntity(WorkTime $workTime): WorkTime;
}