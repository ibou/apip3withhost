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

class TaskSpecContainerSpecConfigsItemNormalizer implements DenormalizerInterface, NormalizerInterface, DenormalizerAwareInterface, NormalizerAwareInterface
{
    use DenormalizerAwareTrait;
    use NormalizerAwareTrait;
    use CheckArray;
    use ValidatorTrait;

    public function supportsDenormalization($data, $type, $format = null, array $context = []): bool
    {
        return 'App\\Service\\Docker\\Model\\TaskSpecContainerSpecConfigsItem' === $type;
    }

    public function supportsNormalization($data, $format = null, array $context = []): bool
    {
        return is_object($data) && 'App\\Service\\Docker\\Model\\TaskSpecContainerSpecConfigsItem' === get_class($data);
    }

    public function denormalize($data, $class, $format = null, array $context = []): mixed
    {
        if (isset($data['$ref'])) {
            return new Reference($data['$ref'], $context['document-origin']);
        }
        if (isset($data['$recursiveRef'])) {
            return new Reference($data['$recursiveRef'], $context['document-origin']);
        }
        $object = new \App\Service\Docker\Model\TaskSpecContainerSpecConfigsItem();
        if (null === $data || false === \is_array($data)) {
            return $object;
        }
        if (\array_key_exists('File', $data)) {
            $object->setFile($this->denormalizer->denormalize($data['File'], 'App\\Service\\Docker\\Model\\TaskSpecContainerSpecConfigsItemFile', 'json', $context));
        }
        if (\array_key_exists('Runtime', $data)) {
            $object->setRuntime($data['Runtime']);
        }
        if (\array_key_exists('ConfigID', $data)) {
            $object->setConfigID($data['ConfigID']);
        }
        if (\array_key_exists('ConfigName', $data)) {
            $object->setConfigName($data['ConfigName']);
        }

        return $object;
    }

    /**
     * @return array|string|int|float|bool|\ArrayObject|null
     */
    public function normalize($object, $format = null, array $context = [])
    {
        $data = [];
        if ($object->isInitialized('file') && null !== $object->getFile()) {
            $data['File'] = $this->normalizer->normalize($object->getFile(), 'json', $context);
        }
        if ($object->isInitialized('runtime') && null !== $object->getRuntime()) {
            $data['Runtime'] = $object->getRuntime();
        }
        if ($object->isInitialized('configID') && null !== $object->getConfigID()) {
            $data['ConfigID'] = $object->getConfigID();
        }
        if ($object->isInitialized('configName') && null !== $object->getConfigName()) {
            $data['ConfigName'] = $object->getConfigName();
        }

        return $data;
    }

    public function getSupportedTypes(string $format = null): array
    {
        return ['App\\Service\\Docker\\Model\\TaskSpecContainerSpecConfigsItem' => false];
    }
}
