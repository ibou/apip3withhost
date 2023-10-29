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

class TaskSpecContainerSpecDNSConfigNormalizer implements DenormalizerInterface, NormalizerInterface, DenormalizerAwareInterface, NormalizerAwareInterface
{
    use DenormalizerAwareTrait;
    use NormalizerAwareTrait;
    use CheckArray;
    use ValidatorTrait;

    public function supportsDenormalization($data, $type, $format = null, array $context = []): bool
    {
        return 'App\\Service\\Docker\\Model\\TaskSpecContainerSpecDNSConfig' === $type;
    }

    public function supportsNormalization($data, $format = null, array $context = []): bool
    {
        return is_object($data) && 'App\\Service\\Docker\\Model\\TaskSpecContainerSpecDNSConfig' === get_class($data);
    }

    public function denormalize($data, $class, $format = null, array $context = []): mixed
    {
        if (isset($data['$ref'])) {
            return new Reference($data['$ref'], $context['document-origin']);
        }
        if (isset($data['$recursiveRef'])) {
            return new Reference($data['$recursiveRef'], $context['document-origin']);
        }
        $object = new \App\Service\Docker\Model\TaskSpecContainerSpecDNSConfig();
        if (null === $data || false === \is_array($data)) {
            return $object;
        }
        if (\array_key_exists('Nameservers', $data)) {
            $values = [];
            foreach ($data['Nameservers'] as $value) {
                $values[] = $value;
            }
            $object->setNameservers($values);
        }
        if (\array_key_exists('Search', $data)) {
            $values_1 = [];
            foreach ($data['Search'] as $value_1) {
                $values_1[] = $value_1;
            }
            $object->setSearch($values_1);
        }
        if (\array_key_exists('Options', $data)) {
            $values_2 = [];
            foreach ($data['Options'] as $value_2) {
                $values_2[] = $value_2;
            }
            $object->setOptions($values_2);
        }

        return $object;
    }

    /**
     * @return array|string|int|float|bool|\ArrayObject|null
     */
    public function normalize($object, $format = null, array $context = [])
    {
        $data = [];
        if ($object->isInitialized('nameservers') && null !== $object->getNameservers()) {
            $values = [];
            foreach ($object->getNameservers() as $value) {
                $values[] = $value;
            }
            $data['Nameservers'] = $values;
        }
        if ($object->isInitialized('search') && null !== $object->getSearch()) {
            $values_1 = [];
            foreach ($object->getSearch() as $value_1) {
                $values_1[] = $value_1;
            }
            $data['Search'] = $values_1;
        }
        if ($object->isInitialized('options') && null !== $object->getOptions()) {
            $values_2 = [];
            foreach ($object->getOptions() as $value_2) {
                $values_2[] = $value_2;
            }
            $data['Options'] = $values_2;
        }

        return $data;
    }

    public function getSupportedTypes(string $format = null): array
    {
        return ['App\\Service\\Docker\\Model\\TaskSpecContainerSpecDNSConfig' => false];
    }
}
