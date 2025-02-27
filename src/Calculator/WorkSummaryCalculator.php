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
            $endTime = $workTime->getEndDate();

            $interval = $this->dateIntervalCalculator->calculateTotalHoursRounded($startTime, $endTime);

            $hours = $this->increaseHours($interval, $hours);
        }

        return $hours;
    }

    private function increaseHours(float $hours, array $actualHours): array
    {
        if ($hours > self::DAILY_HOURS) {
            $extra = $hours - self::DAILY_HOURS;
            $actualHours['standard_hours'] += self::DAILY_HOURS;
            $actualHours['extra_hours'] += $extra;
            return $actualHours;
        }
        $actualHours['standard_hours'] += $hours;
        return $actualHours;
    }

    private function calculateMoney(array $workedHours): array
    {
        $configuration = $this->configurationRepository->find(1);
        Assert::notNull($configuration);
        $extraRate = $this->calculateExtraRate($configuration);
        /** @var float $standardRate */
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