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

class DeviceMappingNormalizer implements DenormalizerInterface, NormalizerInterface, DenormalizerAwareInterface, NormalizerAwareInterface
{
    use DenormalizerAwareTrait;
    use NormalizerAwareTrait;
    use CheckArray;
    use ValidatorTrait;

    public function supportsDenormalization($data, $type, $format = null, array $context = []): bool
    {
        return 'App\\Service\\Docker\\Model\\DeviceMapping' === $type;
    }

    public function supportsNormalization($data, $format = null, array $context = []): bool
    {
        return is_object($data) && 'App\\Service\\Docker\\Model\\DeviceMapping' === get_class($data);
    }

    public function denormalize($data, $class, $format = null, array $context = []): mixed
    {
        if (isset($data['$ref'])) {
            return new Reference($data['$ref'], $context['document-origin']);
        }
        if (isset($data['$recursiveRef'])) {
            return new Reference($data['$recursiveRef'], $context['document-origin']);
        }
        $object = new \App\Service\Docker\Model\DeviceMapping();
        if (null === $data || false === \is_array($data)) {
            return $object;
        }
        if (\array_key_exists('PathOnHost', $data)) {
            $object->setPathOnHost($data['PathOnHost']);
        }
        if (\array_key_exists('PathInContainer', $data)) {
            $object->setPathInContainer($data['PathInContainer']);
        }
        if (\array_key_exists('CgroupPermissions', $data)) {
            $object->setCgroupPermissions($data['CgroupPermissions']);
        }

        return $object;
    }

    /**
     * @return array|string|int|float|bool|\ArrayObject|null
     */
    public function normalize($object, $format = null, array $context = [])
    {
        $data = [];
        if ($object->isInitialized('pathOnHost') && null !== $object->getPathOnHost()) {
            $data['PathOnHost'] = $object->getPathOnHost();
        }
        if ($object->isInitialized('pathInContainer') && null !== $object->getPathInContainer()) {
            $data['PathInContainer'] = $object->getPathInContainer();
        }
        if ($object->isInitialized('cgroupPermissions') && null !== $object->getCgroupPermissions()) {
            $data['CgroupPermissions'] = $object->getCgroupPermissions();
        }

        return $data;
    }

    public function getSupportedTypes(string $format = null): array
    {
        return ['App\\Service\\Docker\\Model\\DeviceMapping' => false];
    }
}
