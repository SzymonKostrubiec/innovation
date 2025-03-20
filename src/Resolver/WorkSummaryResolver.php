<?php

namespace App\Resolver;

use App\Entity\Employee;
use App\Repository\WorkTimeRepository;
use DateTimeImmutable;
use Webmozart\Assert\Assert;

final class WorkSummaryResolver
{
    public function __construct(
        private readonly WorkTimeRepository $workTimeRepository,
    )
    {
    }

    public function resolveByDay(Employee $employee, string $date): array
    {
        $startDate = new DateTimeImmutable($date);
        $employeeWork = $this->workTimeRepository->findBy(['employee' => $employee, 'startDay' => $startDate]);
        Assert::isArray($employeeWork);

        return $employeeWork;
    }

    public function resolveByMonth(Employee $employee, string $date): array
    {
        $startDate = new DateTimeImmutable($date);
        $startOfMonth = $startDate->modify('first day of this month')->setTime(0, 0, 0);
        $endOfMonth = $startDate->modify('last day of this month')->setTime(23, 59, 59);

        $employeeWork = $this->workTimeRepository->createQueryBuilder('w')
            ->where('w.employee = :employee')
            ->andWhere('w.startDate >= :startOfMonth')
            ->andWhere('w.startDate <= :endOfMonth')
            ->setParameter('employee', $employee)
            ->setParameter('startOfMonth', $startOfMonth)
            ->setParameter('endOfMonth', $endOfMonth)
            ->getQuery()
            ->getResult();

        Assert::isArray($employeeWork);

        return $employeeWork;
    }
}