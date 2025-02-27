<?php

namespace App\Calculator;


interface DateIntervalCalculatorInterface
{
    public function calculateTotalHoursRounded(\DateTime $startDate, \DateTime $endDate): float;

}