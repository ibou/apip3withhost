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

class ServiceSpecRollbackConfigNormalizer implements DenormalizerInterface, NormalizerInterface, DenormalizerAwareInterface, NormalizerAwareInterface
{
    use DenormalizerAwareTrait;
    use NormalizerAwareTrait;
    use CheckArray;
    use ValidatorTrait;

    public function supportsDenormalization($data, $type, $format = null, array $context = []): bool
    {
        return 'App\\Service\\Docker\\Model\\ServiceSpecRollbackConfig' === $type;
    }

    public function supportsNormalization($data, $format = null, array $context = []): bool
    {
        return is_object($data) && 'App\\Service\\Docker\\Model\\ServiceSpecRollbackConfig' === get_class($data);
    }

    public function denormalize($data, $class, $format = null, array $context = []): mixed
    {
        if (isset($data['$ref'])) {
            return new Reference($data['$ref'], $context['document-origin']);
        }
        if (isset($data['$recursiveRef'])) {
            return new Reference($data['$recursiveRef'], $context['document-origin']);
        }
        $object = new \App\Service\Docker\Model\ServiceSpecRollbackConfig();
        if (\array_key_exists('MaxFailureRatio', $data) && \is_int($data['MaxFailureRatio'])) {
            $data['MaxFailureRatio'] = (float) $data['MaxFailureRatio'];
        }
        if (null === $data || false === \is_array($data)) {
            return $object;
        }
        if (\array_key_exists('Parallelism', $data)) {
            $object->setParallelism($data['Parallelism']);
        }
        if (\array_key_exists('Delay', $data)) {
            $object->setDelay($data['Delay']);
        }
        if (\array_key_exists('FailureAction', $data)) {
            $object->setFailureAction($data['FailureAction']);
        }
        if (\array_key_exists('Monitor', $data)) {
            $object->setMonitor($data['Monitor']);
        }
        if (\array_key_exists('MaxFailureRatio', $data)) {
            $object->setMaxFailureRatio($data['MaxFailureRatio']);
        }
        if (\array_key_exists('Order', $data)) {
            $object->setOrder($data['Order']);
        }

        return $object;
    }

    /**
     * @return array|string|int|float|bool|\ArrayObject|null
     */
    public function normalize($object, $format = null, array $context = [])
    {
        $data = [];
        if ($object->isInitialized('parallelism') && null !== $object->getParallelism()) {
            $data['Parallelism'] = $object->getParallelism();
        }
        if ($object->isInitialized('delay') && null !== $object->getDelay()) {
            $data['Delay'] = $object->getDelay();
        }
        if ($object->isInitialized('failureAction') && null !== $object->getFailureAction()) {
            $data['FailureAction'] = $object->getFailureAction();
        }
        if ($object->isInitialized('monitor') && null !== $object->getMonitor()) {
            $data['Monitor'] = $object->getMonitor();
        }
        if ($object->isInitialized('maxFailureRatio') && null !== $object->getMaxFailureRatio()) {
            $data['MaxFailureRatio'] = $object->getMaxFailureRatio();
        }
        if ($object->isInitialized('order') && null !== $object->getOrder()) {
            $data['Order'] = $object->getOrder();
        }

        return $data;
    }

    public function getSupportedTypes(string $format = null): array
    {
        return ['App\\Service\\Docker\\Model\\ServiceSpecRollbackConfig' => false];
    }
}
