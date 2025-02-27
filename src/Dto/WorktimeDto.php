<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

final class WorktimeDto
{
    public function __construct(

        #[Assert\NotBlank]
        #[Assert\Type('string')]
        public string $uuid,

        #[Assert\NotBlank]
        #[Assert\Type('string')]
        public ?string $startDate,

        #[Assert\NotBlank]
        #[Assert\Type('string')]
        public ?string $endDate,
    ){
    }

}