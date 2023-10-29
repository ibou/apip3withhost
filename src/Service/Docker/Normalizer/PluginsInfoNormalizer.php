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

class PluginsInfoNormalizer implements DenormalizerInterface, NormalizerInterface, DenormalizerAwareInterface, NormalizerAwareInterface
{
    use DenormalizerAwareTrait;
    use NormalizerAwareTrait;
    use CheckArray;
    use ValidatorTrait;

    public function supportsDenormalization($data, $type, $format = null, array $context = []): bool
    {
        return 'App\\Service\\Docker\\Model\\PluginsInfo' === $type;
    }

    public function supportsNormalization($data, $format = null, array $context = []): bool
    {
        return is_object($data) && 'App\\Service\\Docker\\Model\\PluginsInfo' === get_class($data);
    }

    public function denormalize($data, $class, $format = null, array $context = []): mixed
    {
        if (isset($data['$ref'])) {
            return new Reference($data['$ref'], $context['document-origin']);
        }
        if (isset($data['$recursiveRef'])) {
            return new Reference($data['$recursiveRef'], $context['document-origin']);
        }
        $object = new \App\Service\Docker\Model\PluginsInfo();
        if (null === $data || false === \is_array($data)) {
            return $object;
        }
        if (\array_key_exists('Volume', $data)) {
            $values = [];
            foreach ($data['Volume'] as $value) {
                $values[] = $value;
            }
            $object->setVolume($values);
        }
        if (\array_key_exists('Network', $data)) {
            $values_1 = [];
            foreach ($data['Network'] as $value_1) {
                $values_1[] = $value_1;
            }
            $object->setNetwork($values_1);
        }
        if (\array_key_exists('Authorization', $data)) {
            $values_2 = [];
            foreach ($data['Authorization'] as $value_2) {
                $values_2[] = $value_2;
            }
            $object->setAuthorization($values_2);
        }
        if (\array_key_exists('Log', $data)) {
            $values_3 = [];
            foreach ($data['Log'] as $value_3) {
                $values_3[] = $value_3;
            }
            $object->setLog($values_3);
        }

        return $object;
    }

    /**
     * @return array|string|int|float|bool|\ArrayObject|null
     */
    public function normalize($object, $format = null, array $context = [])
    {
        $data = [];
        if ($object->isInitialized('volume') && null !== $object->getVolume()) {
            $values = [];
            foreach ($object->getVolume() as $value) {
                $values[] = $value;
            }
            $data['Volume'] = $values;
        }
        if ($object->isInitialized('network') && null !== $object->getNetwork()) {
            $values_1 = [];
            foreach ($object->getNetwork() as $value_1) {
                $values_1[] = $value_1;
            }
            $data['Network'] = $values_1;
        }
        if ($object->isInitialized('authorization') && null !== $object->getAuthorization()) {
            $values_2 = [];
            foreach ($object->getAuthorization() as $value_2) {
                $values_2[] = $value_2;
            }
            $data['Authorization'] = $values_2;
        }
        if ($object->isInitialized('log') && null !== $object->getLog()) {
            $values_3 = [];
            foreach ($object->getLog() as $value_3) {
                $values_3[] = $value_3;
            }
            $data['Log'] = $values_3;
        }

        return $data;
    }

    public function getSupportedTypes(string $format = null): array
    {
        return ['App\\Service\\Docker\\Model\\PluginsInfo' => false];
    }
}
