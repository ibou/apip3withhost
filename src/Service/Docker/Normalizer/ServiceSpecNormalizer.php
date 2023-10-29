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

class ServiceSpecNormalizer implements DenormalizerInterface, NormalizerInterface, DenormalizerAwareInterface, NormalizerAwareInterface
{
    use DenormalizerAwareTrait;
    use NormalizerAwareTrait;
    use CheckArray;
    use ValidatorTrait;

    public function supportsDenormalization($data, $type, $format = null, array $context = []): bool
    {
        return 'App\\Service\\Docker\\Model\\ServiceSpec' === $type;
    }

    public function supportsNormalization($data, $format = null, array $context = []): bool
    {
        return is_object($data) && 'App\\Service\\Docker\\Model\\ServiceSpec' === get_class($data);
    }

    public function denormalize($data, $class, $format = null, array $context = []): mixed
    {
        if (isset($data['$ref'])) {
            return new Reference($data['$ref'], $context['document-origin']);
        }
        if (isset($data['$recursiveRef'])) {
            return new Reference($data['$recursiveRef'], $context['document-origin']);
        }
        $object = new \App\Service\Docker\Model\ServiceSpec();
        if (null === $data || false === \is_array($data)) {
            return $object;
        }
        if (\array_key_exists('Name', $data)) {
            $object->setName($data['Name']);
        }
        if (\array_key_exists('Labels', $data)) {
            $values = new \ArrayObject([], \ArrayObject::ARRAY_AS_PROPS);
            foreach ($data['Labels'] as $key => $value) {
                $values[$key] = $value;
            }
            $object->setLabels($values);
        }
        if (\array_key_exists('TaskTemplate', $data)) {
            $object->setTaskTemplate($this->denormalizer->denormalize($data['TaskTemplate'], 'App\\Service\\Docker\\Model\\TaskSpec', 'json', $context));
        }
        if (\array_key_exists('Mode', $data)) {
            $object->setMode($this->denormalizer->denormalize($data['Mode'], 'App\\Service\\Docker\\Model\\ServiceSpecMode', 'json', $context));
        }
        if (\array_key_exists('UpdateConfig', $data)) {
            $object->setUpdateConfig($this->denormalizer->denormalize($data['UpdateConfig'], 'App\\Service\\Docker\\Model\\ServiceSpecUpdateConfig', 'json', $context));
        }
        if (\array_key_exists('RollbackConfig', $data)) {
            $object->setRollbackConfig($this->denormalizer->denormalize($data['RollbackConfig'], 'App\\Service\\Docker\\Model\\ServiceSpecRollbackConfig', 'json', $context));
        }
        if (\array_key_exists('Networks', $data)) {
            $values_1 = [];
            foreach ($data['Networks'] as $value_1) {
                $values_1[] = $this->denormalizer->denormalize($value_1, 'App\\Service\\Docker\\Model\\NetworkAttachmentConfig', 'json', $context);
            }
            $object->setNetworks($values_1);
        }
        if (\array_key_exists('EndpointSpec', $data)) {
            $object->setEndpointSpec($this->denormalizer->denormalize($data['EndpointSpec'], 'App\\Service\\Docker\\Model\\EndpointSpec', 'json', $context));
        }

        return $object;
    }

    /**
     * @return array|string|int|float|bool|\ArrayObject|null
     */
    public function normalize($object, $format = null, array $context = [])
    {
        $data = [];
        if ($object->isInitialized('name') && null !== $object->getName()) {
            $data['Name'] = $object->getName();
        }
        if ($object->isInitialized('labels') && null !== $object->getLabels()) {
            $values = [];
            foreach ($object->getLabels() as $key => $value) {
                $values[$key] = $value;
            }
            $data['Labels'] = $values;
        }
        if ($object->isInitialized('taskTemplate') && null !== $object->getTaskTemplate()) {
            $data['TaskTemplate'] = $this->normalizer->normalize($object->getTaskTemplate(), 'json', $context);
        }
        if ($object->isInitialized('mode') && null !== $object->getMode()) {
            $data['Mode'] = $this->normalizer->normalize($object->getMode(), 'json', $context);
        }
        if ($object->isInitialized('updateConfig') && null !== $object->getUpdateConfig()) {
            $data['UpdateConfig'] = $this->normalizer->normalize($object->getUpdateConfig(), 'json', $context);
        }
        if ($object->isInitialized('rollbackConfig') && null !== $object->getRollbackConfig()) {
            $data['RollbackConfig'] = $this->normalizer->normalize($object->getRollbackConfig(), 'json', $context);
        }
        if ($object->isInitialized('networks') && null !== $object->getNetworks()) {
            $values_1 = [];
            foreach ($object->getNetworks() as $value_1) {
                $values_1[] = $this->normalizer->normalize($value_1, 'json', $context);
            }
            $data['Networks'] = $values_1;
        }
        if ($object->isInitialized('endpointSpec') && null !== $object->getEndpointSpec()) {
            $data['EndpointSpec'] = $this->normalizer->normalize($object->getEndpointSpec(), 'json', $context);
        }

        return $data;
    }

    public function getSupportedTypes(string $format = null): array
    {
        return ['App\\Service\\Docker\\Model\\ServiceSpec' => false];
    }
}
