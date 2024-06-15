<?php

namespace App\Controller;

use App\DTO\MyDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Exception\PartialDenormalizationException;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class MyJsonController extends AbstractController
{
    #[Route(path: '/edit', name: 'edit_sotheming', methods: ['PATCH'])]
    public function updatePatch(Request $request, SerializerInterface $serializer, ValidatorInterface $validator): JsonResponse
    {
        $preparedDTO = new MyDTO();

        try {
            $preparedDTO = $serializer->deserialize($request->getContent(),
                MyDTO::class,
                'json',
                [
                    DenormalizerInterface::COLLECT_DENORMALIZATION_ERRORS => true,
                    AbstractNormalizer::OBJECT_TO_POPULATE => $preparedDTO,
                ]
            );
        } catch (PartialDenormalizationException $e) {
            throw new HttpException(Response::HTTP_UNPROCESSABLE_ENTITY, implode("\n", array_map(static fn ($e) => $e->getMessage(), $e->getErrors())), $e);
        }

        return $this->json($preparedDTO);
    }
}
