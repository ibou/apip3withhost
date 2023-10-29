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

class CreateImageInfoNormalizer implements DenormalizerInterface, NormalizerInterface, DenormalizerAwareInterface, NormalizerAwareInterface
{
    use DenormalizerAwareTrait;
    use NormalizerAwareTrait;
    use CheckArray;
    use ValidatorTrait;

    public function supportsDenormalization($data, $type, $format = null, array $context = []): bool
    {
        return 'App\\Service\\Docker\\Model\\CreateImageInfo' === $type;
    }

    public function supportsNormalization($data, $format = null, array $context = []): bool
    {
        return is_object($data) && 'App\\Service\\Docker\\Model\\CreateImageInfo' === get_class($data);
    }

    public function denormalize($data, $class, $format = null, array $context = []): mixed
    {
        if (isset($data['$ref'])) {
            return new Reference($data['$ref'], $context['document-origin']);
        }
        if (isset($data['$recursiveRef'])) {
            return new Reference($data['$recursiveRef'], $context['document-origin']);
        }
        $object = new \App\Service\Docker\Model\CreateImageInfo();
        if (null === $data || false === \is_array($data)) {
            return $object;
        }
        if (\array_key_exists('id', $data)) {
            $object->setId($data['id']);
        }
        if (\array_key_exists('error', $data)) {
            $object->setError($data['error']);
        }
        if (\array_key_exists('errorDetail', $data)) {
            $object->setErrorDetail($this->denormalizer->denormalize($data['errorDetail'], 'App\\Service\\Docker\\Model\\ErrorDetail', 'json', $context));
        }
        if (\array_key_exists('status', $data)) {
            $object->setStatus($data['status']);
        }
        if (\array_key_exists('progress', $data)) {
            $object->setProgress($data['progress']);
        }
        if (\array_key_exists('progressDetail', $data)) {
            $object->setProgressDetail($this->denormalizer->denormalize($data['progressDetail'], 'App\\Service\\Docker\\Model\\ProgressDetail', 'json', $context));
        }

        return $object;
    }

    /**
     * @return array|string|int|float|bool|\ArrayObject|null
     */
    public function normalize($object, $format = null, array $context = [])
    {
        $data = [];
        if ($object->isInitialized('id') && null !== $object->getId()) {
            $data['id'] = $object->getId();
        }
        if ($object->isInitialized('error') && null !== $object->getError()) {
            $data['error'] = $object->getError();
        }
        if ($object->isInitialized('errorDetail') && null !== $object->getErrorDetail()) {
            $data['errorDetail'] = $this->normalizer->normalize($object->getErrorDetail(), 'json', $context);
        }
        if ($object->isInitialized('status') && null !== $object->getStatus()) {
            $data['status'] = $object->getStatus();
        }
        if ($object->isInitialized('progress') && null !== $object->getProgress()) {
            $data['progress'] = $object->getProgress();
        }
        if ($object->isInitialized('progressDetail') && null !== $object->getProgressDetail()) {
            $data['progressDetail'] = $this->normalizer->normalize($object->getProgressDetail(), 'json', $context);
        }

        return $data;
    }

    public function getSupportedTypes(string $format = null): array
    {
        return ['App\\Service\\Docker\\Model\\CreateImageInfo' => false];
    }
}
