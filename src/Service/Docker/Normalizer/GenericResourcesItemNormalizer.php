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

class GenericResourcesItemNormalizer implements DenormalizerInterface, NormalizerInterface, DenormalizerAwareInterface, NormalizerAwareInterface
{
    use DenormalizerAwareTrait;
    use NormalizerAwareTrait;
    use CheckArray;
    use ValidatorTrait;

    public function supportsDenormalization($data, $type, $format = null, array $context = []): bool
    {
        return 'App\\Service\\Docker\\Model\\GenericResourcesItem' === $type;
    }

    public function supportsNormalization($data, $format = null, array $context = []): bool
    {
        return is_object($data) && 'App\\Service\\Docker\\Model\\GenericResourcesItem' === get_class($data);
    }

    public function denormalize($data, $class, $format = null, array $context = []): mixed
    {
        if (isset($data['$ref'])) {
            return new Reference($data['$ref'], $context['document-origin']);
        }
        if (isset($data['$recursiveRef'])) {
            return new Reference($data['$recursiveRef'], $context['document-origin']);
        }
        $object = new \App\Service\Docker\Model\GenericResourcesItem();
        if (null === $data || false === \is_array($data)) {
            return $object;
        }
        if (\array_key_exists('NamedResourceSpec', $data)) {
            $object->setNamedResourceSpec($this->denormalizer->denormalize($data['NamedResourceSpec'], 'App\\Service\\Docker\\Model\\GenericResourcesItemNamedResourceSpec', 'json', $context));
        }
        if (\array_key_exists('DiscreteResourceSpec', $data)) {
            $object->setDiscreteResourceSpec($this->denormalizer->denormalize($data['DiscreteResourceSpec'], 'App\\Service\\Docker\\Model\\GenericResourcesItemDiscreteResourceSpec', 'json', $context));
        }

        return $object;
    }

    /**
     * @return array|string|int|float|bool|\ArrayObject|null
     */
    public function normalize($object, $format = null, array $context = [])
    {
        $data = [];
        if ($object->isInitialized('namedResourceSpec') && null !== $object->getNamedResourceSpec()) {
            $data['NamedResourceSpec'] = $this->normalizer->normalize($object->getNamedResourceSpec(), 'json', $context);
        }
        if ($object->isInitialized('discreteResourceSpec') && null !== $object->getDiscreteResourceSpec()) {
            $data['DiscreteResourceSpec'] = $this->normalizer->normalize($object->getDiscreteResourceSpec(), 'json', $context);
        }

        return $data;
    }

    public function getSupportedTypes(string $format = null): array
    {
        return ['App\\Service\\Docker\\Model\\GenericResourcesItem' => false];
    }
}
