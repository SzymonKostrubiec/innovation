<?php

namespace App\Controller;

use App\Creator\EmployeeCreatorInterface;
use App\Dto\EmployeeDto;
use App\Factory\EmployeeFactoryInterface;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1/employee')]
class EmployeeController extends AbstractController
{
    public function __construct(
        private readonly EmployeeFactoryInterface $employeeFactory,
        private readonly EmployeeCreatorInterface $employeeCreator,
    ){
    }

    #[Route( '', name: 'create-employee', methods: ['POST'])]
    #[OA\Post(
        operationId: 'create-employee',
        summary: 'Creates employee',
        tags: ['Employees'],

    )]
    #[OA\RequestBody(
        content: [
            new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(properties: [
                    new OA\Property(
                        property: 'name',
                        type: 'string',
                        example: 'Szymon'
                    ),
                    new OA\Property(
                        property: 'lastName',
                        type: 'string',
                        example: 'Koster'
                    )
                ])
            ),
        ]
    )]
    public function store(#[MapRequestPayload] EmployeeDto $employeeDto): JsonResponse
    {
        $employeeEntity = $this->employeeFactory->create($employeeDto);
        $employee = $this->employeeCreator->createFromEntity($employeeEntity);

        return new JsonResponse(['employee_uuid' => $employee->getUuid()]);
    }
}