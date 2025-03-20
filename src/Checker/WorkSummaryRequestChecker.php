<?php

namespace App\Checker;

use App\Enum\WorkSummaryEnum;
use Symfony\Component\HttpFoundation\Request;
use Webmozart\Assert\Assert;

final class WorkSummaryRequestChecker implements WorkSummaryRequestCheckerInterface
{
    public function checkRequest(Request $request): void
    {
        $availableTypes = [WorkSummaryEnum::DAY->value, WorkSummaryEnum::MONTH->value];
        Assert::notEmpty($request->get("uuid"));
        Assert::string($request->get("uuid"));

        Assert::notEmpty($request->get("date"));
        Assert::string($request->get("date"));

        Assert::notEmpty($request->get("type"));

        if(!in_array($request->get("type"), $availableTypes)){
            throw new \Exception('Invalid work summary request type');
        }

        if ($request->get("type") === WorkSummaryEnum::DAY->value &&
            !preg_match('/^\d{4}-\d{2}-\d{2}$/', $request->get("date"))
        )
        {
            throw new \Exception('Invalid date format. Expected format: Y-m-d.');
        }

        if ($request->get("type") === WorkSummaryEnum::MONTH->value &&
            !preg_match('/^\d{4}-\d{2}$/', $request->get("date"))
        )
        {
            throw new \Exception('Invalid date format. Expected format: Y-m.');
        }
    }
}