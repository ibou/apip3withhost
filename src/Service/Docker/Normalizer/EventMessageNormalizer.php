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

class EventMessageNormalizer implements DenormalizerInterface, NormalizerInterface, DenormalizerAwareInterface, NormalizerAwareInterface
{
    use DenormalizerAwareTrait;
    use NormalizerAwareTrait;
    use CheckArray;
    use ValidatorTrait;

    public function supportsDenormalization($data, $type, $format = null, array $context = []): bool
    {
        return 'App\\Service\\Docker\\Model\\EventMessage' === $type;
    }

    public function supportsNormalization($data, $format = null, array $context = []): bool
    {
        return is_object($data) && 'App\\Service\\Docker\\Model\\EventMessage' === get_class($data);
    }

    public function denormalize($data, $class, $format = null, array $context = []): mixed
    {
        if (isset($data['$ref'])) {
            return new Reference($data['$ref'], $context['document-origin']);
        }
        if (isset($data['$recursiveRef'])) {
            return new Reference($data['$recursiveRef'], $context['document-origin']);
        }
        $object = new \App\Service\Docker\Model\EventMessage();
        if (null === $data || false === \is_array($data)) {
            return $object;
        }
        if (\array_key_exists('Type', $data)) {
            $object->setType($data['Type']);
        }
        if (\array_key_exists('Action', $data)) {
            $object->setAction($data['Action']);
        }
        if (\array_key_exists('Actor', $data)) {
            $object->setActor($this->denormalizer->denormalize($data['Actor'], 'App\\Service\\Docker\\Model\\EventActor', 'json', $context));
        }
        if (\array_key_exists('scope', $data)) {
            $object->setScope($data['scope']);
        }
        if (\array_key_exists('time', $data)) {
            $object->setTime($data['time']);
        }
        if (\array_key_exists('timeNano', $data)) {
            $object->setTimeNano($data['timeNano']);
        }

        return $object;
    }

    /**
     * @return array|string|int|float|bool|\ArrayObject|null
     */
    public function normalize($object, $format = null, array $context = [])
    {
        $data = [];
        if ($object->isInitialized('type') && null !== $object->getType()) {
            $data['Type'] = $object->getType();
        }
        if ($object->isInitialized('action') && null !== $object->getAction()) {
            $data['Action'] = $object->getAction();
        }
        if ($object->isInitialized('actor') && null !== $object->getActor()) {
            $data['Actor'] = $this->normalizer->normalize($object->getActor(), 'json', $context);
        }
        if ($object->isInitialized('scope') && null !== $object->getScope()) {
            $data['scope'] = $object->getScope();
        }
        if ($object->isInitialized('time') && null !== $object->getTime()) {
            $data['time'] = $object->getTime();
        }
        if ($object->isInitialized('timeNano') && null !== $object->getTimeNano()) {
            $data['timeNano'] = $object->getTimeNano();
        }

        return $data;
    }

    public function getSupportedTypes(string $format = null): array
    {
        return ['App\\Service\\Docker\\Model\\EventMessage' => false];
    }
}
