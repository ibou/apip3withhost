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

class ServiceEndpointNormalizer implements DenormalizerInterface, NormalizerInterface, DenormalizerAwareInterface, NormalizerAwareInterface
{
    use DenormalizerAwareTrait;
    use NormalizerAwareTrait;
    use CheckArray;
    use ValidatorTrait;

    public function supportsDenormalization($data, $type, $format = null, array $context = []): bool
    {
        return 'App\\Service\\Docker\\Model\\ServiceEndpoint' === $type;
    }

    public function supportsNormalization($data, $format = null, array $context = []): bool
    {
        return is_object($data) && 'App\\Service\\Docker\\Model\\ServiceEndpoint' === get_class($data);
    }

    public function denormalize($data, $class, $format = null, array $context = []): mixed
    {
        if (isset($data['$ref'])) {
            return new Reference($data['$ref'], $context['document-origin']);
        }
        if (isset($data['$recursiveRef'])) {
            return new Reference($data['$recursiveRef'], $context['document-origin']);
        }
        $object = new \App\Service\Docker\Model\ServiceEndpoint();
        if (null === $data || false === \is_array($data)) {
            return $object;
        }
        if (\array_key_exists('Spec', $data)) {
            $object->setSpec($this->denormalizer->denormalize($data['Spec'], 'App\\Service\\Docker\\Model\\EndpointSpec', 'json', $context));
        }
        if (\array_key_exists('Ports', $data)) {
            $values = [];
            foreach ($data['Ports'] as $value) {
                $values[] = $this->denormalizer->denormalize($value, 'App\\Service\\Docker\\Model\\EndpointPortConfig', 'json', $context);
            }
            $object->setPorts($values);
        }
        if (\array_key_exists('VirtualIPs', $data)) {
            $values_1 = [];
            foreach ($data['VirtualIPs'] as $value_1) {
                $values_1[] = $this->denormalizer->denormalize($value_1, 'App\\Service\\Docker\\Model\\ServiceEndpointVirtualIPsItem', 'json', $context);
            }
            $object->setVirtualIPs($values_1);
        }

        return $object;
    }

    /**
     * @return array|string|int|float|bool|\ArrayObject|null
     */
    public function normalize($object, $format = null, array $context = [])
    {
        $data = [];
        if ($object->isInitialized('spec') && null !== $object->getSpec()) {
            $data['Spec'] = $this->normalizer->normalize($object->getSpec(), 'json', $context);
        }
        if ($object->isInitialized('ports') && null !== $object->getPorts()) {
            $values = [];
            foreach ($object->getPorts() as $value) {
                $values[] = $this->normalizer->normalize($value, 'json', $context);
            }
            $data['Ports'] = $values;
        }
        if ($object->isInitialized('virtualIPs') && null !== $object->getVirtualIPs()) {
            $values_1 = [];
            foreach ($object->getVirtualIPs() as $value_1) {
                $values_1[] = $this->normalizer->normalize($value_1, 'json', $context);
            }
            $data['VirtualIPs'] = $values_1;
        }

        return $data;
    }

    public function getSupportedTypes(string $format = null): array
    {
        return ['App\\Service\\Docker\\Model\\ServiceEndpoint' => false];
    }
}
