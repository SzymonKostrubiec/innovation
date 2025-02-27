<?php

namespace App\Calculator;

use App\Entity\Configuration;
use App\Repository\ConfigurationRepository;
use Webmozart\Assert\Assert;

final class WorkSummaryCalculator implements WorkSummaryCalculatorInterface
{
    private const DAILY_HOURS = 8;

    public function __construct(
        private readonly DateIntervalCalculatorInterface $dateIntervalCalculator,
        private readonly ConfigurationRepository $configurationRepository,
    ){
    }

    public function getCalculatedData(array $workData): array
    {
        $calculatedHours = $this->calculateHours($workData);
        $calculatedMoney = $this->calculateMoney($calculatedHours);

        return array_merge($calculatedMoney, $calculatedHours);
    }

    private function calculateHours(array $workData): array
    {
        $hours = [
            'standard_hours' => 0,
            'extra_hours' => 0
        ];

        foreach ($workData as $workTime) {
            $startTime = $workTime->getStartDate();
            $endTime =  $workTime->getEndDate();

            $interval = $this->dateIntervalCalculator->calculateTotalHoursRounded($startTime,$endTime);
            if((int)$interval > self::DAILY_HOURS){
                $extra = $interval - self::DAILY_HOURS;
                $hours['standard_hours'] += self::DAILY_HOURS;
                $hours['extra_hours'] += $extra;
            }
            $hours['standard_hours'] += $interval;
        }

        return $hours;
    }

    private function calculateMoney(array $workedHours): array
    {
        $configuration = $this->configurationRepository->find(1);
        Assert::notNull($configuration);
        $extraRate = $this->calculateExtraRate($configuration);
        $standardRate = $configuration->getHourlyRate();
        $money = [
            'standard_rate' => $standardRate,
            'extra_rate' => $extraRate,
            'standard_money' => $this->calculateTotalMoney($workedHours['standard_hours'], $standardRate),
            'extra_money' => $this->calculateTotalMoney($workedHours['extra_hours'], $extraRate),
        ];
        return $money;
    }

    private function calculateTotalMoney(float $rate, float $hours): float
    {
        return $rate * $hours;
    }

    private function calculateExtraRate(Configuration $configuration): int
    {
        return ($configuration->getOvertimeMultiplier() * $configuration->getHourlyRate() / 100);
    }
}