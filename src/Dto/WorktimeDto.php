<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

final class WorktimeDto
{
    public function __construct(

        #[Assert\NotBlank(null, 'Employee uuid can not be blank')]
        #[Assert\Type('string', 'Employee uuid must be string')]
        public string $uuid,

        #[Assert\NotBlank(null, 'Start date can not be blank')]
        #[Assert\Type('string', 'Start date must be string')]
        public ?string $startDate,

        #[Assert\NotBlank(null, 'End date can not be blank')]
        #[Assert\Type('string', 'End date must be string')]
        public ?string $endDate,
    ){
    }

}