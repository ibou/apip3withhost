<?php

namespace App\Service\Docker\Normalizer;

use App\Service\Docker\Runtime\Normalizer\CheckArray;
use App\Service\Docker\Runtime\Normalizer\ValidatorTrait;
use Jane\Component\JsonSchemaRuntime\Reference;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ServiceSpecModeReplicatedJobNormalizer implements DenormalizerInterface, NormalizerInterface, DenormalizerAwareInterface, NormalizerAwareInterface
{
    use DenormalizerAwareTrait;
    use NormalizerAwareTrait;
    use CheckArray;
    use ValidatorTrait;

    public function supportsDenormalization($data, $type, $format = null, array $context = []): bool
    {
        return 'App\\Service\\Docker\\Model\\ServiceSpecModeReplicatedJob' === $type;
    }

    public function supportsNormalization($data, $format = null, array $context = []): bool
    {
        return is_object($data) && 'App\\Service\\Docker\\Model\\ServiceSpecModeReplicatedJob' === get_class($data);
    }

    public function denormalize($data, $class, $format = null, array $context = []): mixed
    {
        if (isset($data['$ref'])) {
            return new Reference($data['$ref'], $context['document-origin']);
        }
        if (isset($data['$recursiveRef'])) {
            return new Reference($data['$recursiveRef'], $context['document-origin']);
        }
        $object = new \App\Service\Docker\Model\ServiceSpecModeReplicatedJob();
        if (null === $data || false === \is_array($data)) {
            return $object;
        }
        if (\array_key_exists('MaxConcurrent', $data)) {
            $object->setMaxConcurrent($data['MaxConcurrent']);
        }
        if (\array_key_exists('TotalCompletions', $data)) {
            $object->setTotalCompletions($data['TotalCompletions']);
        }

        return $object;
    }

    /**
     * @return array|string|int|float|bool|\ArrayObject|null
     */
    public function normalize($object, $format = null, array $context = [])
    {
        $data = [];
        if ($object->isInitialized('maxConcurrent') && null !== $object->getMaxConcurrent()) {
            $data['MaxConcurrent'] = $object->getMaxConcurrent();
        }
        if ($object->isInitialized('totalCompletions') && null !== $object->getTotalCompletions()) {
            $data['TotalCompletions'] = $object->getTotalCompletions();
        }

        return $data;
    }

    public function getSupportedTypes(string $format = null): array
    {
        return ['App\\Service\\Docker\\Model\\ServiceSpecModeReplicatedJob' => false];
    }
}
