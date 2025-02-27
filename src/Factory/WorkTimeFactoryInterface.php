<?php

namespace App\Factory;

use App\Dto\WorktimeDto;
use App\Entity\WorkTime;


interface WorkTimeFactoryInterface
{
    public function create( WorktimeDto $workTimeDto ): WorkTime;
}