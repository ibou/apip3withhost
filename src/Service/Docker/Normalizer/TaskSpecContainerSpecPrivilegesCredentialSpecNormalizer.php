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

class TaskSpecContainerSpecPrivilegesCredentialSpecNormalizer implements DenormalizerInterface, NormalizerInterface, DenormalizerAwareInterface, NormalizerAwareInterface
{
    use DenormalizerAwareTrait;
    use NormalizerAwareTrait;
    use CheckArray;
    use ValidatorTrait;

    public function supportsDenormalization($data, $type, $format = null, array $context = []): bool
    {
        return 'App\\Service\\Docker\\Model\\TaskSpecContainerSpecPrivilegesCredentialSpec' === $type;
    }

    public function supportsNormalization($data, $format = null, array $context = []): bool
    {
        return is_object($data) && 'App\\Service\\Docker\\Model\\TaskSpecContainerSpecPrivilegesCredentialSpec' === get_class($data);
    }

    public function denormalize($data, $class, $format = null, array $context = []): mixed
    {
        if (isset($data['$ref'])) {
            return new Reference($data['$ref'], $context['document-origin']);
        }
        if (isset($data['$recursiveRef'])) {
            return new Reference($data['$recursiveRef'], $context['document-origin']);
        }
        $object = new \App\Service\Docker\Model\TaskSpecContainerSpecPrivilegesCredentialSpec();
        if (null === $data || false === \is_array($data)) {
            return $object;
        }
        if (\array_key_exists('Config', $data)) {
            $object->setConfig($data['Config']);
        }
        if (\array_key_exists('File', $data)) {
            $object->setFile($data['File']);
        }
        if (\array_key_exists('Registry', $data)) {
            $object->setRegistry($data['Registry']);
        }

        return $object;
    }

    /**
     * @return array|string|int|float|bool|\ArrayObject|null
     */
    public function normalize($object, $format = null, array $context = [])
    {
        $data = [];
        if ($object->isInitialized('config') && null !== $object->getConfig()) {
            $data['Config'] = $object->getConfig();
        }
        if ($object->isInitialized('file') && null !== $object->getFile()) {
            $data['File'] = $object->getFile();
        }
        if ($object->isInitialized('registry') && null !== $object->getRegistry()) {
            $data['Registry'] = $object->getRegistry();
        }

        return $data;
    }

    public function getSupportedTypes(string $format = null): array
    {
        return ['App\\Service\\Docker\\Model\\TaskSpecContainerSpecPrivilegesCredentialSpec' => false];
    }
}
