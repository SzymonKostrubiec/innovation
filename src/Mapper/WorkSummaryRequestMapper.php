<?php

namespace App\Mapper;

use Symfony\Component\HttpFoundation\Request;

final class WorkSummaryRequestMapper implements WorkSummaryRequestMapperInterface
{
    public function mapToArray(Request $request): array
    {
        return [
          'uuid' => $request->get('uuid'),
          'date' => $request->get('date'),
          'type' => $request->get('type'),
        ];
    }
}