<?php

namespace App\Controller\Action;

use App\Checker\WorkSummaryRequestCheckerInterface;
use App\Enum\WorkSummaryEnum;
use App\Mapper\WorkSummaryRequestMapperInterface;
use App\Processor\WorkSummaryProcessor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

#[Route('/api/v1/work/summary')]
class WorkSummaryAction extends AbstractController
{
    public function __construct(
        private readonly WorkSummaryProcessor $workSummaryProcessor,
        private readonly WorkSummaryRequestCheckerInterface $workSummaryRequestChecker,
        private readonly WorkSummaryRequestMapperInterface $workSummaryRequestMapper,
    )
    {
    }

    #[Route('/{type}', methods: ['GET'])]
    #[OA\Get(
        operationId: 'get-summary-by-type',
        summary: 'Get work summary by type, supported types: [day/month] ',
        tags: ['Work Summary'],
        parameters: [
            new OA\Parameter(
                name: 'type',
                in: 'path',
                required: true,
                description: 'The type of work summary (day/month)',
                schema: new OA\Schema(
                    type: 'string',
                    enum: [WorkSummaryEnum::DAY->value, WorkSummaryEnum::MONTH->value],
                )
            ),
            new OA\Parameter(
                name: 'uuid',
                in: 'query',
                required: true,
                description: 'The unique identifier of the user',
                schema: new OA\Schema(
                    type: 'string',
                    format: 'uuid',
                    example: ''
                )
            ),
            new OA\Parameter(
                name: 'date',
                in: 'query',
                required: true,
                description: 'The date for the work summary (YYYY-MM-DD)',
                schema: new OA\Schema(
                    type: 'string',
                    format: 'date',
                    example: '2025-02-27'
                )
            )
        ]
    )]
    public function __invoke(Request $request):JsonResponse
    {
        try{
            $this->workSummaryRequestChecker->checkRequest($request);
            $requestData = $this->workSummaryRequestMapper->mapToArray($request);
            $response = $this->workSummaryProcessor->process($requestData);
            return new JsonResponse([$response]);
        }catch (\Exception $exception){
            return new JsonResponse(['Error' => $exception->getMessage()], 400);
        }
    }
}