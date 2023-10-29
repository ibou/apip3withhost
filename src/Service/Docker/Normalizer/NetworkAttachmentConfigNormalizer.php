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

class NetworkAttachmentConfigNormalizer implements DenormalizerInterface, NormalizerInterface, DenormalizerAwareInterface, NormalizerAwareInterface
{
    use DenormalizerAwareTrait;
    use NormalizerAwareTrait;
    use CheckArray;
    use ValidatorTrait;

    public function supportsDenormalization($data, $type, $format = null, array $context = []): bool
    {
        return 'App\\Service\\Docker\\Model\\NetworkAttachmentConfig' === $type;
    }

    public function supportsNormalization($data, $format = null, array $context = []): bool
    {
        return is_object($data) && 'App\\Service\\Docker\\Model\\NetworkAttachmentConfig' === get_class($data);
    }

    public function denormalize($data, $class, $format = null, array $context = []): mixed
    {
        if (isset($data['$ref'])) {
            return new Reference($data['$ref'], $context['document-origin']);
        }
        if (isset($data['$recursiveRef'])) {
            return new Reference($data['$recursiveRef'], $context['document-origin']);
        }
        $object = new \App\Service\Docker\Model\NetworkAttachmentConfig();
        if (null === $data || false === \is_array($data)) {
            return $object;
        }
        if (\array_key_exists('Target', $data)) {
            $object->setTarget($data['Target']);
        }
        if (\array_key_exists('Aliases', $data)) {
            $values = [];
            foreach ($data['Aliases'] as $value) {
                $values[] = $value;
            }
            $object->setAliases($values);
        }
        if (\array_key_exists('DriverOpts', $data)) {
            $values_1 = new \ArrayObject([], \ArrayObject::ARRAY_AS_PROPS);
            foreach ($data['DriverOpts'] as $key => $value_1) {
                $values_1[$key] = $value_1;
            }
            $object->setDriverOpts($values_1);
        }

        return $object;
    }

    /**
     * @return array|string|int|float|bool|\ArrayObject|null
     */
    public function normalize($object, $format = null, array $context = [])
    {
        $data = [];
        if ($object->isInitialized('target') && null !== $object->getTarget()) {
            $data['Target'] = $object->getTarget();
        }
        if ($object->isInitialized('aliases') && null !== $object->getAliases()) {
            $values = [];
            foreach ($object->getAliases() as $value) {
                $values[] = $value;
            }
            $data['Aliases'] = $values;
        }
        if ($object->isInitialized('driverOpts') && null !== $object->getDriverOpts()) {
            $values_1 = [];
            foreach ($object->getDriverOpts() as $key => $value_1) {
                $values_1[$key] = $value_1;
            }
            $data['DriverOpts'] = $values_1;
        }

        return $data;
    }

    public function getSupportedTypes(string $format = null): array
    {
        return ['App\\Service\\Docker\\Model\\NetworkAttachmentConfig' => false];
    }
}
