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

class IPAMNormalizer implements DenormalizerInterface, NormalizerInterface, DenormalizerAwareInterface, NormalizerAwareInterface
{
    use DenormalizerAwareTrait;
    use NormalizerAwareTrait;
    use CheckArray;
    use ValidatorTrait;

    public function supportsDenormalization($data, $type, $format = null, array $context = []): bool
    {
        return 'App\\Service\\Docker\\Model\\IPAM' === $type;
    }

    public function supportsNormalization($data, $format = null, array $context = []): bool
    {
        return is_object($data) && 'App\\Service\\Docker\\Model\\IPAM' === get_class($data);
    }

    public function denormalize($data, $class, $format = null, array $context = []): mixed
    {
        if (isset($data['$ref'])) {
            return new Reference($data['$ref'], $context['document-origin']);
        }
        if (isset($data['$recursiveRef'])) {
            return new Reference($data['$recursiveRef'], $context['document-origin']);
        }
        $object = new \App\Service\Docker\Model\IPAM();
        if (null === $data || false === \is_array($data)) {
            return $object;
        }
        if (\array_key_exists('Driver', $data)) {
            $object->setDriver($data['Driver']);
        }
        if (\array_key_exists('Config', $data)) {
            $values = [];
            foreach ($data['Config'] as $value) {
                $values[] = $this->denormalizer->denormalize($value, 'App\\Service\\Docker\\Model\\IPAMConfig', 'json', $context);
            }
            $object->setConfig($values);
        }
        if (\array_key_exists('Options', $data)) {
            $values_1 = new \ArrayObject([], \ArrayObject::ARRAY_AS_PROPS);
            foreach ($data['Options'] as $key => $value_1) {
                $values_1[$key] = $value_1;
            }
            $object->setOptions($values_1);
        }

        return $object;
    }

    /**
     * @return array|string|int|float|bool|\ArrayObject|null
     */
    public function normalize($object, $format = null, array $context = [])
    {
        $data = [];
        if ($object->isInitialized('driver') && null !== $object->getDriver()) {
            $data['Driver'] = $object->getDriver();
        }
        if ($object->isInitialized('config') && null !== $object->getConfig()) {
            $values = [];
            foreach ($object->getConfig() as $value) {
                $values[] = $this->normalizer->normalize($value, 'json', $context);
            }
            $data['Config'] = $values;
        }
        if ($object->isInitialized('options') && null !== $object->getOptions()) {
            $values_1 = [];
            foreach ($object->getOptions() as $key => $value_1) {
                $values_1[$key] = $value_1;
            }
            $data['Options'] = $values_1;
        }

        return $data;
    }

    public function getSupportedTypes(string $format = null): array
    {
        return ['App\\Service\\Docker\\Model\\IPAM' => false];
    }
}
