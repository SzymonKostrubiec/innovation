<?php

namespace App\Mapper;

use Symfony\Component\HttpFoundation\Request;

interface WorkSummaryRequestMapperInterface
{
    public function mapToArray(Request $request): array;
}