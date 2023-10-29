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

class NodeDescriptionNormalizer implements DenormalizerInterface, NormalizerInterface, DenormalizerAwareInterface, NormalizerAwareInterface
{
    use DenormalizerAwareTrait;
    use NormalizerAwareTrait;
    use CheckArray;
    use ValidatorTrait;

    public function supportsDenormalization($data, $type, $format = null, array $context = []): bool
    {
        return 'App\\Service\\Docker\\Model\\NodeDescription' === $type;
    }

    public function supportsNormalization($data, $format = null, array $context = []): bool
    {
        return is_object($data) && 'App\\Service\\Docker\\Model\\NodeDescription' === get_class($data);
    }

    public function denormalize($data, $class, $format = null, array $context = []): mixed
    {
        if (isset($data['$ref'])) {
            return new Reference($data['$ref'], $context['document-origin']);
        }
        if (isset($data['$recursiveRef'])) {
            return new Reference($data['$recursiveRef'], $context['document-origin']);
        }
        $object = new \App\Service\Docker\Model\NodeDescription();
        if (null === $data || false === \is_array($data)) {
            return $object;
        }
        if (\array_key_exists('Hostname', $data)) {
            $object->setHostname($data['Hostname']);
        }
        if (\array_key_exists('Platform', $data)) {
            $object->setPlatform($this->denormalizer->denormalize($data['Platform'], 'App\\Service\\Docker\\Model\\Platform', 'json', $context));
        }
        if (\array_key_exists('Resources', $data)) {
            $object->setResources($this->denormalizer->denormalize($data['Resources'], 'App\\Service\\Docker\\Model\\ResourceObject', 'json', $context));
        }
        if (\array_key_exists('Engine', $data)) {
            $object->setEngine($this->denormalizer->denormalize($data['Engine'], 'App\\Service\\Docker\\Model\\EngineDescription', 'json', $context));
        }
        if (\array_key_exists('TLSInfo', $data)) {
            $object->setTLSInfo($this->denormalizer->denormalize($data['TLSInfo'], 'App\\Service\\Docker\\Model\\TLSInfo', 'json', $context));
        }

        return $object;
    }

    /**
     * @return array|string|int|float|bool|\ArrayObject|null
     */
    public function normalize($object, $format = null, array $context = [])
    {
        $data = [];
        if ($object->isInitialized('hostname') && null !== $object->getHostname()) {
            $data['Hostname'] = $object->getHostname();
        }
        if ($object->isInitialized('platform') && null !== $object->getPlatform()) {
            $data['Platform'] = $this->normalizer->normalize($object->getPlatform(), 'json', $context);
        }
        if ($object->isInitialized('resources') && null !== $object->getResources()) {
            $data['Resources'] = $this->normalizer->normalize($object->getResources(), 'json', $context);
        }
        if ($object->isInitialized('engine') && null !== $object->getEngine()) {
            $data['Engine'] = $this->normalizer->normalize($object->getEngine(), 'json', $context);
        }
        if ($object->isInitialized('tLSInfo') && null !== $object->getTLSInfo()) {
            $data['TLSInfo'] = $this->normalizer->normalize($object->getTLSInfo(), 'json', $context);
        }

        return $data;
    }

    public function getSupportedTypes(string $format = null): array
    {
        return ['App\\Service\\Docker\\Model\\NodeDescription' => false];
    }
}
