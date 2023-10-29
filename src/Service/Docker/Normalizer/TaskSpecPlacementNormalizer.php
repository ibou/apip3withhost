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

class TaskSpecPlacementNormalizer implements DenormalizerInterface, NormalizerInterface, DenormalizerAwareInterface, NormalizerAwareInterface
{
    use DenormalizerAwareTrait;
    use NormalizerAwareTrait;
    use CheckArray;
    use ValidatorTrait;

    public function supportsDenormalization($data, $type, $format = null, array $context = []): bool
    {
        return 'App\\Service\\Docker\\Model\\TaskSpecPlacement' === $type;
    }

    public function supportsNormalization($data, $format = null, array $context = []): bool
    {
        return is_object($data) && 'App\\Service\\Docker\\Model\\TaskSpecPlacement' === get_class($data);
    }

    public function denormalize($data, $class, $format = null, array $context = []): mixed
    {
        if (isset($data['$ref'])) {
            return new Reference($data['$ref'], $context['document-origin']);
        }
        if (isset($data['$recursiveRef'])) {
            return new Reference($data['$recursiveRef'], $context['document-origin']);
        }
        $object = new \App\Service\Docker\Model\TaskSpecPlacement();
        if (null === $data || false === \is_array($data)) {
            return $object;
        }
        if (\array_key_exists('Constraints', $data)) {
            $values = [];
            foreach ($data['Constraints'] as $value) {
                $values[] = $value;
            }
            $object->setConstraints($values);
        }
        if (\array_key_exists('Preferences', $data)) {
            $values_1 = [];
            foreach ($data['Preferences'] as $value_1) {
                $values_1[] = $this->denormalizer->denormalize($value_1, 'App\\Service\\Docker\\Model\\TaskSpecPlacementPreferencesItem', 'json', $context);
            }
            $object->setPreferences($values_1);
        }
        if (\array_key_exists('MaxReplicas', $data)) {
            $object->setMaxReplicas($data['MaxReplicas']);
        }
        if (\array_key_exists('Platforms', $data)) {
            $values_2 = [];
            foreach ($data['Platforms'] as $value_2) {
                $values_2[] = $this->denormalizer->denormalize($value_2, 'App\\Service\\Docker\\Model\\Platform', 'json', $context);
            }
            $object->setPlatforms($values_2);
        }

        return $object;
    }

    /**
     * @return array|string|int|float|bool|\ArrayObject|null
     */
    public function normalize($object, $format = null, array $context = [])
    {
        $data = [];
        if ($object->isInitialized('constraints') && null !== $object->getConstraints()) {
            $values = [];
            foreach ($object->getConstraints() as $value) {
                $values[] = $value;
            }
            $data['Constraints'] = $values;
        }
        if ($object->isInitialized('preferences') && null !== $object->getPreferences()) {
            $values_1 = [];
            foreach ($object->getPreferences() as $value_1) {
                $values_1[] = $this->normalizer->normalize($value_1, 'json', $context);
            }
            $data['Preferences'] = $values_1;
        }
        if ($object->isInitialized('maxReplicas') && null !== $object->getMaxReplicas()) {
            $data['MaxReplicas'] = $object->getMaxReplicas();
        }
        if ($object->isInitialized('platforms') && null !== $object->getPlatforms()) {
            $values_2 = [];
            foreach ($object->getPlatforms() as $value_2) {
                $values_2[] = $this->normalizer->normalize($value_2, 'json', $context);
            }
            $data['Platforms'] = $values_2;
        }

        return $data;
    }

    public function getSupportedTypes(string $format = null): array
    {
        return ['App\\Service\\Docker\\Model\\TaskSpecPlacement' => false];
    }
}
