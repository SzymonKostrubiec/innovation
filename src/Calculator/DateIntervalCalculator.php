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
        $roundedMinutes = (int) round($minutes / 15) * 15;

        $hour = (int) $date->format('H');

        if ($roundedMinutes >= 60) {
            return $date->modify('+1 hour')->setTime($hour + 1, 0);
        }

        return $date->setTime($hour, $roundedMinutes);
    }
}