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

class SystemDfGetResponse200Normalizer implements DenormalizerInterface, NormalizerInterface, DenormalizerAwareInterface, NormalizerAwareInterface
{
    use DenormalizerAwareTrait;
    use NormalizerAwareTrait;
    use CheckArray;
    use ValidatorTrait;

    public function supportsDenormalization($data, $type, $format = null, array $context = []): bool
    {
        return 'App\\Service\\Docker\\Model\\SystemDfGetResponse200' === $type;
    }

    public function supportsNormalization($data, $format = null, array $context = []): bool
    {
        return is_object($data) && 'App\\Service\\Docker\\Model\\SystemDfGetResponse200' === get_class($data);
    }

    public function denormalize($data, $class, $format = null, array $context = []): mixed
    {
        if (isset($data['$ref'])) {
            return new Reference($data['$ref'], $context['document-origin']);
        }
        if (isset($data['$recursiveRef'])) {
            return new Reference($data['$recursiveRef'], $context['document-origin']);
        }
        $object = new \App\Service\Docker\Model\SystemDfGetResponse200();
        if (null === $data || false === \is_array($data)) {
            return $object;
        }
        if (\array_key_exists('LayersSize', $data)) {
            $object->setLayersSize($data['LayersSize']);
        }
        if (\array_key_exists('Images', $data)) {
            $values = [];
            foreach ($data['Images'] as $value) {
                $values[] = $this->denormalizer->denormalize($value, 'App\\Service\\Docker\\Model\\ImageSummary', 'json', $context);
            }
            $object->setImages($values);
        }
        if (\array_key_exists('Containers', $data)) {
            $values_1 = [];
            foreach ($data['Containers'] as $value_1) {
                $values_1[] = $this->denormalizer->denormalize($value_1, 'App\\Service\\Docker\\Model\\ContainerSummary', 'json', $context);
            }
            $object->setContainers($values_1);
        }
        if (\array_key_exists('Volumes', $data)) {
            $values_2 = [];
            foreach ($data['Volumes'] as $value_2) {
                $values_2[] = $this->denormalizer->denormalize($value_2, 'App\\Service\\Docker\\Model\\Volume', 'json', $context);
            }
            $object->setVolumes($values_2);
        }
        if (\array_key_exists('BuildCache', $data)) {
            $values_3 = [];
            foreach ($data['BuildCache'] as $value_3) {
                $values_3[] = $this->denormalizer->denormalize($value_3, 'App\\Service\\Docker\\Model\\BuildCache', 'json', $context);
            }
            $object->setBuildCache($values_3);
        }

        return $object;
    }

    /**
     * @return array|string|int|float|bool|\ArrayObject|null
     */
    public function normalize($object, $format = null, array $context = [])
    {
        $data = [];
        if ($object->isInitialized('layersSize') && null !== $object->getLayersSize()) {
            $data['LayersSize'] = $object->getLayersSize();
        }
        if ($object->isInitialized('images') && null !== $object->getImages()) {
            $values = [];
            foreach ($object->getImages() as $value) {
                $values[] = $this->normalizer->normalize($value, 'json', $context);
            }
            $data['Images'] = $values;
        }
        if ($object->isInitialized('containers') && null !== $object->getContainers()) {
            $values_1 = [];
            foreach ($object->getContainers() as $value_1) {
                $values_1[] = $this->normalizer->normalize($value_1, 'json', $context);
            }
            $data['Containers'] = $values_1;
        }
        if ($object->isInitialized('volumes') && null !== $object->getVolumes()) {
            $values_2 = [];
            foreach ($object->getVolumes() as $value_2) {
                $values_2[] = $this->normalizer->normalize($value_2, 'json', $context);
            }
            $data['Volumes'] = $values_2;
        }
        if ($object->isInitialized('buildCache') && null !== $object->getBuildCache()) {
            $values_3 = [];
            foreach ($object->getBuildCache() as $value_3) {
                $values_3[] = $this->normalizer->normalize($value_3, 'json', $context);
            }
            $data['BuildCache'] = $values_3;
        }

        return $data;
    }

    public function getSupportedTypes(string $format = null): array
    {
        return ['App\\Service\\Docker\\Model\\SystemDfGetResponse200' => false];
    }
}
