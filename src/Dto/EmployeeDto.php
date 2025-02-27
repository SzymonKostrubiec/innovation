<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

final class EmployeeDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type('string')]
        public ?string $name,

        #[Assert\NotBlank]
        #[Assert\Type('string')]
        public ?string $lastName,
    ){
    }

}