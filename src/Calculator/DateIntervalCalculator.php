<?php

namespace App\Calculator;


final class DateIntervalCalculator implements DateIntervalCalculatorInterface
{

    public function calculateTotalHoursRounded(\DateTime $startDate, \DateTime $endDate): float
    {
        $startDate = $this->roundMinutes($startDate);
        $endDate = $this->roundMinutes($endDate);

        $interval = $startDate->diff($endDate);
        $totalHours = ($interval->days * 24) + $interval->h + ($interval->i / 60);

        return $totalHours;
    }

    private function roundMinutes(\DateTime $date): \DateTime
    {
        $minutes = (int) $date->format('i');
        $roundedMinutes = round($minutes / 15) * 15;

        if ($roundedMinutes === 60) {
            return $date->modify('+1 hour')->setTime($date->format('H'), 0);
        }

        return $date->setTime($date->format('H'), $roundedMinutes);
    }
}