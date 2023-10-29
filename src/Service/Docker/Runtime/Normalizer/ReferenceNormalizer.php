<?php

namespace App\Service\Docker\Runtime\Normalizer;

use Jane\Component\JsonSchemaRuntime\Reference;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ReferenceNormalizer implements NormalizerInterface
{
    public function normalize($object, $format = null, array $context = []): array|string|int|float|bool|\ArrayObject|null
    {
        $ref = [];
        $ref['$ref'] = (string) $object->getReferenceUri();

        return $ref;
    }

    public function supportsNormalization($data, $format = null, array $context = []): bool
    {
        return $data instanceof Reference;
    }

    public function getSupportedTypes(?string $format): array
    {
        return ['*'];
    }
}
