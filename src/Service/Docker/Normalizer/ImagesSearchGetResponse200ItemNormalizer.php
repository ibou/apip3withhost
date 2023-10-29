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

class ImagesSearchGetResponse200ItemNormalizer implements DenormalizerInterface, NormalizerInterface, DenormalizerAwareInterface, NormalizerAwareInterface
{
    use DenormalizerAwareTrait;
    use NormalizerAwareTrait;
    use CheckArray;
    use ValidatorTrait;

    public function supportsDenormalization($data, $type, $format = null, array $context = []): bool
    {
        return 'App\\Service\\Docker\\Model\\ImagesSearchGetResponse200Item' === $type;
    }

    public function supportsNormalization($data, $format = null, array $context = []): bool
    {
        return is_object($data) && 'App\\Service\\Docker\\Model\\ImagesSearchGetResponse200Item' === get_class($data);
    }

    public function denormalize($data, $class, $format = null, array $context = []): mixed
    {
        if (isset($data['$ref'])) {
            return new Reference($data['$ref'], $context['document-origin']);
        }
        if (isset($data['$recursiveRef'])) {
            return new Reference($data['$recursiveRef'], $context['document-origin']);
        }
        $object = new \App\Service\Docker\Model\ImagesSearchGetResponse200Item();
        if (null === $data || false === \is_array($data)) {
            return $object;
        }
        if (\array_key_exists('description', $data)) {
            $object->setDescription($data['description']);
        }
        if (\array_key_exists('is_official', $data)) {
            $object->setIsOfficial($data['is_official']);
        }
        if (\array_key_exists('is_automated', $data)) {
            $object->setIsAutomated($data['is_automated']);
        }
        if (\array_key_exists('name', $data)) {
            $object->setName($data['name']);
        }
        if (\array_key_exists('star_count', $data)) {
            $object->setStarCount($data['star_count']);
        }

        return $object;
    }

    /**
     * @return array|string|int|float|bool|\ArrayObject|null
     */
    public function normalize($object, $format = null, array $context = [])
    {
        $data = [];
        if ($object->isInitialized('description') && null !== $object->getDescription()) {
            $data['description'] = $object->getDescription();
        }
        if ($object->isInitialized('isOfficial') && null !== $object->getIsOfficial()) {
            $data['is_official'] = $object->getIsOfficial();
        }
        if ($object->isInitialized('isAutomated') && null !== $object->getIsAutomated()) {
            $data['is_automated'] = $object->getIsAutomated();
        }
        if ($object->isInitialized('name') && null !== $object->getName()) {
            $data['name'] = $object->getName();
        }
        if ($object->isInitialized('starCount') && null !== $object->getStarCount()) {
            $data['star_count'] = $object->getStarCount();
        }

        return $data;
    }

    public function getSupportedTypes(string $format = null): array
    {
        return ['App\\Service\\Docker\\Model\\ImagesSearchGetResponse200Item' => false];
    }
}
