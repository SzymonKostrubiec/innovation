<?php

namespace App\Checker;

use Symfony\Component\HttpFoundation\Request;

interface WorkSummaryRequestCheckerInterface
{
    public function checkRequest(Request $request): void;
}