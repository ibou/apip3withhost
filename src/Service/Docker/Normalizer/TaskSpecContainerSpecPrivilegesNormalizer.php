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

class TaskSpecContainerSpecPrivilegesNormalizer implements DenormalizerInterface, NormalizerInterface, DenormalizerAwareInterface, NormalizerAwareInterface
{
    use DenormalizerAwareTrait;
    use NormalizerAwareTrait;
    use CheckArray;
    use ValidatorTrait;

    public function supportsDenormalization($data, $type, $format = null, array $context = []): bool
    {
        return 'App\\Service\\Docker\\Model\\TaskSpecContainerSpecPrivileges' === $type;
    }

    public function supportsNormalization($data, $format = null, array $context = []): bool
    {
        return is_object($data) && 'App\\Service\\Docker\\Model\\TaskSpecContainerSpecPrivileges' === get_class($data);
    }

    public function denormalize($data, $class, $format = null, array $context = []): mixed
    {
        if (isset($data['$ref'])) {
            return new Reference($data['$ref'], $context['document-origin']);
        }
        if (isset($data['$recursiveRef'])) {
            return new Reference($data['$recursiveRef'], $context['document-origin']);
        }
        $object = new \App\Service\Docker\Model\TaskSpecContainerSpecPrivileges();
        if (null === $data || false === \is_array($data)) {
            return $object;
        }
        if (\array_key_exists('CredentialSpec', $data)) {
            $object->setCredentialSpec($this->denormalizer->denormalize($data['CredentialSpec'], 'App\\Service\\Docker\\Model\\TaskSpecContainerSpecPrivilegesCredentialSpec', 'json', $context));
        }
        if (\array_key_exists('SELinuxContext', $data)) {
            $object->setSELinuxContext($this->denormalizer->denormalize($data['SELinuxContext'], 'App\\Service\\Docker\\Model\\TaskSpecContainerSpecPrivilegesSELinuxContext', 'json', $context));
        }

        return $object;
    }

    /**
     * @return array|string|int|float|bool|\ArrayObject|null
     */
    public function normalize($object, $format = null, array $context = [])
    {
        $data = [];
        if ($object->isInitialized('credentialSpec') && null !== $object->getCredentialSpec()) {
            $data['CredentialSpec'] = $this->normalizer->normalize($object->getCredentialSpec(), 'json', $context);
        }
        if ($object->isInitialized('sELinuxContext') && null !== $object->getSELinuxContext()) {
            $data['SELinuxContext'] = $this->normalizer->normalize($object->getSELinuxContext(), 'json', $context);
        }

        return $data;
    }

    public function getSupportedTypes(string $format = null): array
    {
        return ['App\\Service\\Docker\\Model\\TaskSpecContainerSpecPrivileges' => false];
    }
}
