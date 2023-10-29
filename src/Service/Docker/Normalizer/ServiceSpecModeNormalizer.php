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

class ServiceSpecModeNormalizer implements DenormalizerInterface, NormalizerInterface, DenormalizerAwareInterface, NormalizerAwareInterface
{
    use DenormalizerAwareTrait;
    use NormalizerAwareTrait;
    use CheckArray;
    use ValidatorTrait;

    public function supportsDenormalization($data, $type, $format = null, array $context = []): bool
    {
        return 'App\\Service\\Docker\\Model\\ServiceSpecMode' === $type;
    }

    public function supportsNormalization($data, $format = null, array $context = []): bool
    {
        return is_object($data) && 'App\\Service\\Docker\\Model\\ServiceSpecMode' === get_class($data);
    }

    public function denormalize($data, $class, $format = null, array $context = []): mixed
    {
        if (isset($data['$ref'])) {
            return new Reference($data['$ref'], $context['document-origin']);
        }
        if (isset($data['$recursiveRef'])) {
            return new Reference($data['$recursiveRef'], $context['document-origin']);
        }
        $object = new \App\Service\Docker\Model\ServiceSpecMode();
        if (null === $data || false === \is_array($data)) {
            return $object;
        }
        if (\array_key_exists('Replicated', $data)) {
            $object->setReplicated($this->denormalizer->denormalize($data['Replicated'], 'App\\Service\\Docker\\Model\\ServiceSpecModeReplicated', 'json', $context));
        }
        if (\array_key_exists('Global', $data)) {
            $object->setGlobal($data['Global']);
        }
        if (\array_key_exists('ReplicatedJob', $data)) {
            $object->setReplicatedJob($this->denormalizer->denormalize($data['ReplicatedJob'], 'App\\Service\\Docker\\Model\\ServiceSpecModeReplicatedJob', 'json', $context));
        }
        if (\array_key_exists('GlobalJob', $data)) {
            $object->setGlobalJob($data['GlobalJob']);
        }

        return $object;
    }

    /**
     * @return array|string|int|float|bool|\ArrayObject|null
     */
    public function normalize($object, $format = null, array $context = [])
    {
        $data = [];
        if ($object->isInitialized('replicated') && null !== $object->getReplicated()) {
            $data['Replicated'] = $this->normalizer->normalize($object->getReplicated(), 'json', $context);
        }
        if ($object->isInitialized('global') && null !== $object->getGlobal()) {
            $data['Global'] = $object->getGlobal();
        }
        if ($object->isInitialized('replicatedJob') && null !== $object->getReplicatedJob()) {
            $data['ReplicatedJob'] = $this->normalizer->normalize($object->getReplicatedJob(), 'json', $context);
        }
        if ($object->isInitialized('globalJob') && null !== $object->getGlobalJob()) {
            $data['GlobalJob'] = $object->getGlobalJob();
        }

        return $data;
    }

    public function getSupportedTypes(string $format = null): array
    {
        return ['App\\Service\\Docker\\Model\\ServiceSpecMode' => false];
    }
}
