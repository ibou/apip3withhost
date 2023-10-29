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

class ClusterVolumeSpecAccessModeAccessibilityRequirementsNormalizer implements DenormalizerInterface, NormalizerInterface, DenormalizerAwareInterface, NormalizerAwareInterface
{
    use DenormalizerAwareTrait;
    use NormalizerAwareTrait;
    use CheckArray;
    use ValidatorTrait;

    public function supportsDenormalization($data, $type, $format = null, array $context = []): bool
    {
        return 'App\\Service\\Docker\\Model\\ClusterVolumeSpecAccessModeAccessibilityRequirements' === $type;
    }

    public function supportsNormalization($data, $format = null, array $context = []): bool
    {
        return is_object($data) && 'App\\Service\\Docker\\Model\\ClusterVolumeSpecAccessModeAccessibilityRequirements' === get_class($data);
    }

    public function denormalize($data, $class, $format = null, array $context = []): mixed
    {
        if (isset($data['$ref'])) {
            return new Reference($data['$ref'], $context['document-origin']);
        }
        if (isset($data['$recursiveRef'])) {
            return new Reference($data['$recursiveRef'], $context['document-origin']);
        }
        $object = new \App\Service\Docker\Model\ClusterVolumeSpecAccessModeAccessibilityRequirements();
        if (null === $data || false === \is_array($data)) {
            return $object;
        }
        if (\array_key_exists('Requisite', $data)) {
            $values = [];
            foreach ($data['Requisite'] as $value) {
                $values_1 = new \ArrayObject([], \ArrayObject::ARRAY_AS_PROPS);
                foreach ($value as $key => $value_1) {
                    $values_1[$key] = $value_1;
                }
                $values[] = $values_1;
            }
            $object->setRequisite($values);
        }
        if (\array_key_exists('Preferred', $data)) {
            $values_2 = [];
            foreach ($data['Preferred'] as $value_2) {
                $values_3 = new \ArrayObject([], \ArrayObject::ARRAY_AS_PROPS);
                foreach ($value_2 as $key_1 => $value_3) {
                    $values_3[$key_1] = $value_3;
                }
                $values_2[] = $values_3;
            }
            $object->setPreferred($values_2);
        }

        return $object;
    }

    /**
     * @return array|string|int|float|bool|\ArrayObject|null
     */
    public function normalize($object, $format = null, array $context = [])
    {
        $data = [];
        if ($object->isInitialized('requisite') && null !== $object->getRequisite()) {
            $values = [];
            foreach ($object->getRequisite() as $value) {
                $values_1 = [];
                foreach ($value as $key => $value_1) {
                    $values_1[$key] = $value_1;
                }
                $values[] = $values_1;
            }
            $data['Requisite'] = $values;
        }
        if ($object->isInitialized('preferred') && null !== $object->getPreferred()) {
            $values_2 = [];
            foreach ($object->getPreferred() as $value_2) {
                $values_3 = [];
                foreach ($value_2 as $key_1 => $value_3) {
                    $values_3[$key_1] = $value_3;
                }
                $values_2[] = $values_3;
            }
            $data['Preferred'] = $values_2;
        }

        return $data;
    }

    public function getSupportedTypes(string $format = null): array
    {
        return ['App\\Service\\Docker\\Model\\ClusterVolumeSpecAccessModeAccessibilityRequirements' => false];
    }
}
