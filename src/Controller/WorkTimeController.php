<?php

namespace App\Controller;

use App\Checker\WorkTimeCheckerInterface;
use App\Creator\WorkTimeCreatorInterface;
use App\Dto\WorktimeDto;
use App\Factory\WorkTimeFactoryInterface;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1/work-time')]
class WorkTimeController extends AbstractController
{
    public function __construct(
        private readonly WorkTimeFactoryInterface $workTimeFactory,
        private readonly WorkTimeCreatorInterface $workTimeCreator,
        private readonly WorkTimeCheckerInterface $workTimeChecker,
    )
    {
    }

    #[Route( '', name: 'create-work-time', methods: ['POST'])]
    #[OA\Post(
        operationId: 'create-work-time',
        summary: 'Creates work time',
        tags: ['Work time'],

    )]
    #[OA\RequestBody(
        content: [
            new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(properties: [
                    new OA\Property(
                        property: 'uuid',
                        type: 'string',
                        format: 'uuid',
                        example: ''
                    ),
                    new OA\Property(
                        property: 'startDate',
                        type: 'string',
                        format: 'date-time',
                        example: '2025-02-27T10:00:00Z'
                    ),
                    new OA\Property(
                        property: 'endDate',
                        format: 'date-time',
                        example: '2025-02-27T13:00:00Z'
                    )
                ])
            ),
        ]
    )]
    public function store(#[MapRequestPayload] WorktimeDto $worktimeDto): JsonResponse
    {
        try {
            $workTimeEntity = $this->workTimeFactory->create($worktimeDto);
            $this->workTimeChecker->checkWorkTime($workTimeEntity);
            $workTime = $this->workTimeCreator->createFromEntity($workTimeEntity);
            return new JsonResponse(dump($workTime));
        }catch (\Exception $exception){
            return new JsonResponse(['Error' => $exception->getMessage()], 400);
        }
    }
}