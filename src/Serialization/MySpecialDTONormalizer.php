<?php

namespace App\Serialization;

use App\DTO\MySpecialDTO;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class MySpecialDTONormalizer implements NormalizerInterface, DenormalizerInterface
{
    public function normalize(mixed $object, string $format = null, array $context = []): array
    {
        return ['key' => $object->key];
    }

    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): MySpecialDTO
    {
        $mySpecialDTO = new MySpecialDTO();

        $valueThatNeedsProcessing = $data['key'];
        if ('goodValue' != $valueThatNeedsProcessing) {
            throw NotNormalizableValueException::createForUnexpectedDataType('A clear message for the end user', 'Sample', ['ValidTypeIExpect'], $context['deserialization_path'].'.key', true);
        }

        $mySpecialDTO->key = $valueThatNeedsProcessing;

        return $mySpecialDTO;
    }

    public function supportsNormalization(mixed $data, string $format = null, array $context = []): bool
    {
        return $data instanceof MySpecialDTO;
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null, array $context = []): bool
    {
        return MySpecialDTO::class === $type;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            MySpecialDTO::class => false,
        ];
    }
}
