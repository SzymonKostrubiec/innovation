<?php

namespace App\Calculator;

use DateTimeImmutable;

interface DateIntervalCalculatorInterface
{
    public function calculateTotalHours(DateTimeImmutable $startDate, DateTimeImmutable $endDate): int;

    public function calculateTotalHoursRounded(\DateTime $startDate, \DateTime $endDate): float;

}