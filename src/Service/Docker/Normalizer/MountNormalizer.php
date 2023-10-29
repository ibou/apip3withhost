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

class MountNormalizer implements DenormalizerInterface, NormalizerInterface, DenormalizerAwareInterface, NormalizerAwareInterface
{
    use DenormalizerAwareTrait;
    use NormalizerAwareTrait;
    use CheckArray;
    use ValidatorTrait;

    public function supportsDenormalization($data, $type, $format = null, array $context = []): bool
    {
        return 'App\\Service\\Docker\\Model\\Mount' === $type;
    }

    public function supportsNormalization($data, $format = null, array $context = []): bool
    {
        return is_object($data) && 'App\\Service\\Docker\\Model\\Mount' === get_class($data);
    }

    public function denormalize($data, $class, $format = null, array $context = []): mixed
    {
        if (isset($data['$ref'])) {
            return new Reference($data['$ref'], $context['document-origin']);
        }
        if (isset($data['$recursiveRef'])) {
            return new Reference($data['$recursiveRef'], $context['document-origin']);
        }
        $object = new \App\Service\Docker\Model\Mount();
        if (null === $data || false === \is_array($data)) {
            return $object;
        }
        if (\array_key_exists('Target', $data)) {
            $object->setTarget($data['Target']);
        }
        if (\array_key_exists('Source', $data)) {
            $object->setSource($data['Source']);
        }
        if (\array_key_exists('Type', $data)) {
            $object->setType($data['Type']);
        }
        if (\array_key_exists('ReadOnly', $data)) {
            $object->setReadOnly($data['ReadOnly']);
        }
        if (\array_key_exists('Consistency', $data)) {
            $object->setConsistency($data['Consistency']);
        }
        if (\array_key_exists('BindOptions', $data)) {
            $object->setBindOptions($this->denormalizer->denormalize($data['BindOptions'], 'App\\Service\\Docker\\Model\\MountBindOptions', 'json', $context));
        }
        if (\array_key_exists('VolumeOptions', $data)) {
            $object->setVolumeOptions($this->denormalizer->denormalize($data['VolumeOptions'], 'App\\Service\\Docker\\Model\\MountVolumeOptions', 'json', $context));
        }
        if (\array_key_exists('TmpfsOptions', $data)) {
            $object->setTmpfsOptions($this->denormalizer->denormalize($data['TmpfsOptions'], 'App\\Service\\Docker\\Model\\MountTmpfsOptions', 'json', $context));
        }

        return $object;
    }

    /**
     * @return array|string|int|float|bool|\ArrayObject|null
     */
    public function normalize($object, $format = null, array $context = [])
    {
        $data = [];
        if ($object->isInitialized('target') && null !== $object->getTarget()) {
            $data['Target'] = $object->getTarget();
        }
        if ($object->isInitialized('source') && null !== $object->getSource()) {
            $data['Source'] = $object->getSource();
        }
        if ($object->isInitialized('type') && null !== $object->getType()) {
            $data['Type'] = $object->getType();
        }
        if ($object->isInitialized('readOnly') && null !== $object->getReadOnly()) {
            $data['ReadOnly'] = $object->getReadOnly();
        }
        if ($object->isInitialized('consistency') && null !== $object->getConsistency()) {
            $data['Consistency'] = $object->getConsistency();
        }
        if ($object->isInitialized('bindOptions') && null !== $object->getBindOptions()) {
            $data['BindOptions'] = $this->normalizer->normalize($object->getBindOptions(), 'json', $context);
        }
        if ($object->isInitialized('volumeOptions') && null !== $object->getVolumeOptions()) {
            $data['VolumeOptions'] = $this->normalizer->normalize($object->getVolumeOptions(), 'json', $context);
        }
        if ($object->isInitialized('tmpfsOptions') && null !== $object->getTmpfsOptions()) {
            $data['TmpfsOptions'] = $this->normalizer->normalize($object->getTmpfsOptions(), 'json', $context);
        }

        return $data;
    }

    public function getSupportedTypes(string $format = null): array
    {
        return ['App\\Service\\Docker\\Model\\Mount' => false];
    }
}
