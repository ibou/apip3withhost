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

class EndpointIPAMConfigNormalizer implements DenormalizerInterface, NormalizerInterface, DenormalizerAwareInterface, NormalizerAwareInterface
{
    use DenormalizerAwareTrait;
    use NormalizerAwareTrait;
    use CheckArray;
    use ValidatorTrait;

    public function supportsDenormalization($data, $type, $format = null, array $context = []): bool
    {
        return 'App\\Service\\Docker\\Model\\EndpointIPAMConfig' === $type;
    }

    public function supportsNormalization($data, $format = null, array $context = []): bool
    {
        return is_object($data) && 'App\\Service\\Docker\\Model\\EndpointIPAMConfig' === get_class($data);
    }

    public function denormalize($data, $class, $format = null, array $context = []): mixed
    {
        if (isset($data['$ref'])) {
            return new Reference($data['$ref'], $context['document-origin']);
        }
        if (isset($data['$recursiveRef'])) {
            return new Reference($data['$recursiveRef'], $context['document-origin']);
        }
        $object = new \App\Service\Docker\Model\EndpointIPAMConfig();
        if (null === $data || false === \is_array($data)) {
            return $object;
        }
        if (\array_key_exists('IPv4Address', $data)) {
            $object->setIPv4Address($data['IPv4Address']);
        }
        if (\array_key_exists('IPv6Address', $data)) {
            $object->setIPv6Address($data['IPv6Address']);
        }
        if (\array_key_exists('LinkLocalIPs', $data)) {
            $values = [];
            foreach ($data['LinkLocalIPs'] as $value) {
                $values[] = $value;
            }
            $object->setLinkLocalIPs($values);
        }

        return $object;
    }

    /**
     * @return array|string|int|float|bool|\ArrayObject|null
     */
    public function normalize($object, $format = null, array $context = [])
    {
        $data = [];
        if ($object->isInitialized('iPv4Address') && null !== $object->getIPv4Address()) {
            $data['IPv4Address'] = $object->getIPv4Address();
        }
        if ($object->isInitialized('iPv6Address') && null !== $object->getIPv6Address()) {
            $data['IPv6Address'] = $object->getIPv6Address();
        }
        if ($object->isInitialized('linkLocalIPs') && null !== $object->getLinkLocalIPs()) {
            $values = [];
            foreach ($object->getLinkLocalIPs() as $value) {
                $values[] = $value;
            }
            $data['LinkLocalIPs'] = $values;
        }

        return $data;
    }

    public function getSupportedTypes(string $format = null): array
    {
        return ['App\\Service\\Docker\\Model\\EndpointIPAMConfig' => false];
    }
}
