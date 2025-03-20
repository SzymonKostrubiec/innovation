<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

final class EmployeeDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type('string', 'Employee name can not be blank')]
        public ?string $name,

        #[Assert\NotBlank]
        #[Assert\Type('string', 'Employee last name can not be blank')]
        public ?string $lastName,
    ){
    }

}