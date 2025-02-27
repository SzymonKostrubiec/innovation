<?php

namespace App\Calculator;


interface WorkSummaryCalculatorInterface
{
    public function getCalculatedData(array $workData): array;
}