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

class ImagesNameHistoryGetResponse200ItemNormalizer implements DenormalizerInterface, NormalizerInterface, DenormalizerAwareInterface, NormalizerAwareInterface
{
    use DenormalizerAwareTrait;
    use NormalizerAwareTrait;
    use CheckArray;
    use ValidatorTrait;

    public function supportsDenormalization($data, $type, $format = null, array $context = []): bool
    {
        return 'App\\Service\\Docker\\Model\\ImagesNameHistoryGetResponse200Item' === $type;
    }

    public function supportsNormalization($data, $format = null, array $context = []): bool
    {
        return is_object($data) && 'App\\Service\\Docker\\Model\\ImagesNameHistoryGetResponse200Item' === get_class($data);
    }

    public function denormalize($data, $class, $format = null, array $context = []): mixed
    {
        if (isset($data['$ref'])) {
            return new Reference($data['$ref'], $context['document-origin']);
        }
        if (isset($data['$recursiveRef'])) {
            return new Reference($data['$recursiveRef'], $context['document-origin']);
        }
        $object = new \App\Service\Docker\Model\ImagesNameHistoryGetResponse200Item();
        if (null === $data || false === \is_array($data)) {
            return $object;
        }
        if (\array_key_exists('Id', $data)) {
            $object->setId($data['Id']);
        }
        if (\array_key_exists('Created', $data)) {
            $object->setCreated($data['Created']);
        }
        if (\array_key_exists('CreatedBy', $data)) {
            $object->setCreatedBy($data['CreatedBy']);
        }
        if (\array_key_exists('Tags', $data)) {
            $values = [];
            foreach ($data['Tags'] as $value) {
                $values[] = $value;
            }
            $object->setTags($values);
        }
        if (\array_key_exists('Size', $data)) {
            $object->setSize($data['Size']);
        }
        if (\array_key_exists('Comment', $data)) {
            $object->setComment($data['Comment']);
        }

        return $object;
    }

    /**
     * @return array|string|int|float|bool|\ArrayObject|null
     */
    public function normalize($object, $format = null, array $context = [])
    {
        $data = [];
        $data['Id'] = $object->getId();
        $data['Created'] = $object->getCreated();
        $data['CreatedBy'] = $object->getCreatedBy();
        $values = [];
        foreach ($object->getTags() as $value) {
            $values[] = $value;
        }
        $data['Tags'] = $values;
        $data['Size'] = $object->getSize();
        $data['Comment'] = $object->getComment();

        return $data;
    }

    public function getSupportedTypes(string $format = null): array
    {
        return ['App\\Service\\Docker\\Model\\ImagesNameHistoryGetResponse200Item' => false];
    }
}
