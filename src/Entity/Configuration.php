<?php

namespace App\Entity;

use App\Repository\ConfigurationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConfigurationRepository::class)]
class Configuration
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $monthlyNormHours = null;

    #[ORM\Column]
    private ?int $hourlyRate = null;

    #[ORM\Column]
    private ?int $overtimeMultiplier = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMonthlyNormHours(): ?int
    {
        return $this->monthlyNormHours;
    }

    public function setMonthlyNormHours(int $monthlyNormHours): static
    {
        $this->monthlyNormHours = $monthlyNormHours;

        return $this;
    }

    public function getHourlyRate(): ?int
    {
        return $this->hourlyRate;
    }

    public function setHourlyRate(int $hourlyRate): static
    {
        $this->hourlyRate = $hourlyRate;

        return $this;
    }

    public function getOvertimeMultiplier(): ?int
    {
        return $this->overtimeMultiplier;
    }

    public function setOvertimeMultiplier(int $overtimeMultiplier): static
    {
        $this->overtimeMultiplier = $overtimeMultiplier;

        return $this;
    }
}
