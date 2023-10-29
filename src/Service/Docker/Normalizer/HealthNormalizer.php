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

class HealthNormalizer implements DenormalizerInterface, NormalizerInterface, DenormalizerAwareInterface, NormalizerAwareInterface
{
    use DenormalizerAwareTrait;
    use NormalizerAwareTrait;
    use CheckArray;
    use ValidatorTrait;

    public function supportsDenormalization($data, $type, $format = null, array $context = []): bool
    {
        return 'App\\Service\\Docker\\Model\\Health' === $type;
    }

    public function supportsNormalization($data, $format = null, array $context = []): bool
    {
        return is_object($data) && 'App\\Service\\Docker\\Model\\Health' === get_class($data);
    }

    public function denormalize($data, $class, $format = null, array $context = []): mixed
    {
        if (isset($data['$ref'])) {
            return new Reference($data['$ref'], $context['document-origin']);
        }
        if (isset($data['$recursiveRef'])) {
            return new Reference($data['$recursiveRef'], $context['document-origin']);
        }
        $object = new \App\Service\Docker\Model\Health();
        if (null === $data || false === \is_array($data)) {
            return $object;
        }
        if (\array_key_exists('Status', $data)) {
            $object->setStatus($data['Status']);
        }
        if (\array_key_exists('FailingStreak', $data)) {
            $object->setFailingStreak($data['FailingStreak']);
        }
        if (\array_key_exists('Log', $data)) {
            $values = [];
            foreach ($data['Log'] as $value) {
                $values[] = $this->denormalizer->denormalize($value, 'App\\Service\\Docker\\Model\\HealthcheckResult', 'json', $context);
            }
            $object->setLog($values);
        }

        return $object;
    }

    /**
     * @return array|string|int|float|bool|\ArrayObject|null
     */
    public function normalize($object, $format = null, array $context = [])
    {
        $data = [];
        if ($object->isInitialized('status') && null !== $object->getStatus()) {
            $data['Status'] = $object->getStatus();
        }
        if ($object->isInitialized('failingStreak') && null !== $object->getFailingStreak()) {
            $data['FailingStreak'] = $object->getFailingStreak();
        }
        if ($object->isInitialized('log') && null !== $object->getLog()) {
            $values = [];
            foreach ($object->getLog() as $value) {
                $values[] = $this->normalizer->normalize($value, 'json', $context);
            }
            $data['Log'] = $values;
        }

        return $data;
    }

    public function getSupportedTypes(string $format = null): array
    {
        return ['App\\Service\\Docker\\Model\\Health' => false];
    }
}
