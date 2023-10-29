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

class IPAMConfigNormalizer implements DenormalizerInterface, NormalizerInterface, DenormalizerAwareInterface, NormalizerAwareInterface
{
    use DenormalizerAwareTrait;
    use NormalizerAwareTrait;
    use CheckArray;
    use ValidatorTrait;

    public function supportsDenormalization($data, $type, $format = null, array $context = []): bool
    {
        return 'App\\Service\\Docker\\Model\\IPAMConfig' === $type;
    }

    public function supportsNormalization($data, $format = null, array $context = []): bool
    {
        return is_object($data) && 'App\\Service\\Docker\\Model\\IPAMConfig' === get_class($data);
    }

    public function denormalize($data, $class, $format = null, array $context = []): mixed
    {
        if (isset($data['$ref'])) {
            return new Reference($data['$ref'], $context['document-origin']);
        }
        if (isset($data['$recursiveRef'])) {
            return new Reference($data['$recursiveRef'], $context['document-origin']);
        }
        $object = new \App\Service\Docker\Model\IPAMConfig();
        if (null === $data || false === \is_array($data)) {
            return $object;
        }
        if (\array_key_exists('Subnet', $data)) {
            $object->setSubnet($data['Subnet']);
        }
        if (\array_key_exists('IPRange', $data)) {
            $object->setIPRange($data['IPRange']);
        }
        if (\array_key_exists('Gateway', $data)) {
            $object->setGateway($data['Gateway']);
        }
        if (\array_key_exists('AuxiliaryAddresses', $data)) {
            $values = new \ArrayObject([], \ArrayObject::ARRAY_AS_PROPS);
            foreach ($data['AuxiliaryAddresses'] as $key => $value) {
                $values[$key] = $value;
            }
            $object->setAuxiliaryAddresses($values);
        }

        return $object;
    }

    /**
     * @return array|string|int|float|bool|\ArrayObject|null
     */
    public function normalize($object, $format = null, array $context = [])
    {
        $data = [];
        if ($object->isInitialized('subnet') && null !== $object->getSubnet()) {
            $data['Subnet'] = $object->getSubnet();
        }
        if ($object->isInitialized('iPRange') && null !== $object->getIPRange()) {
            $data['IPRange'] = $object->getIPRange();
        }
        if ($object->isInitialized('gateway') && null !== $object->getGateway()) {
            $data['Gateway'] = $object->getGateway();
        }
        if ($object->isInitialized('auxiliaryAddresses') && null !== $object->getAuxiliaryAddresses()) {
            $values = [];
            foreach ($object->getAuxiliaryAddresses() as $key => $value) {
                $values[$key] = $value;
            }
            $data['AuxiliaryAddresses'] = $values;
        }

        return $data;
    }

    public function getSupportedTypes(string $format = null): array
    {
        return ['App\\Service\\Docker\\Model\\IPAMConfig' => false];
    }
}
