<?php

namespace App\Calculator;

use DateTimeImmutable;

interface DateIntervalCalculatorInterface
{
    public function calculateTotalHoursRounded(\DateTime $startDate, \DateTime $endDate): float;

}