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

class EndpointSettingsNormalizer implements DenormalizerInterface, NormalizerInterface, DenormalizerAwareInterface, NormalizerAwareInterface
{
    use DenormalizerAwareTrait;
    use NormalizerAwareTrait;
    use CheckArray;
    use ValidatorTrait;

    public function supportsDenormalization($data, $type, $format = null, array $context = []): bool
    {
        return 'App\\Service\\Docker\\Model\\EndpointSettings' === $type;
    }

    public function supportsNormalization($data, $format = null, array $context = []): bool
    {
        return is_object($data) && 'App\\Service\\Docker\\Model\\EndpointSettings' === get_class($data);
    }

    public function denormalize($data, $class, $format = null, array $context = []): mixed
    {
        if (isset($data['$ref'])) {
            return new Reference($data['$ref'], $context['document-origin']);
        }
        if (isset($data['$recursiveRef'])) {
            return new Reference($data['$recursiveRef'], $context['document-origin']);
        }
        $object = new \App\Service\Docker\Model\EndpointSettings();
        if (null === $data || false === \is_array($data)) {
            return $object;
        }
        if (\array_key_exists('IPAMConfig', $data) && null !== $data['IPAMConfig']) {
            $object->setIPAMConfig($this->denormalizer->denormalize($data['IPAMConfig'], 'App\\Service\\Docker\\Model\\EndpointIPAMConfig', 'json', $context));
        } elseif (\array_key_exists('IPAMConfig', $data) && null === $data['IPAMConfig']) {
            $object->setIPAMConfig(null);
        }
        if (\array_key_exists('Links', $data)) {
            $values = [];
            foreach ($data['Links'] as $value) {
                $values[] = $value;
            }
            $object->setLinks($values);
        }
        if (\array_key_exists('Aliases', $data)) {
            $values_1 = [];
            foreach ($data['Aliases'] as $value_1) {
                $values_1[] = $value_1;
            }
            $object->setAliases($values_1);
        }
        if (\array_key_exists('NetworkID', $data)) {
            $object->setNetworkID($data['NetworkID']);
        }
        if (\array_key_exists('EndpointID', $data)) {
            $object->setEndpointID($data['EndpointID']);
        }
        if (\array_key_exists('Gateway', $data)) {
            $object->setGateway($data['Gateway']);
        }
        if (\array_key_exists('IPAddress', $data)) {
            $object->setIPAddress($data['IPAddress']);
        }
        if (\array_key_exists('IPPrefixLen', $data)) {
            $object->setIPPrefixLen($data['IPPrefixLen']);
        }
        if (\array_key_exists('IPv6Gateway', $data)) {
            $object->setIPv6Gateway($data['IPv6Gateway']);
        }
        if (\array_key_exists('GlobalIPv6Address', $data)) {
            $object->setGlobalIPv6Address($data['GlobalIPv6Address']);
        }
        if (\array_key_exists('GlobalIPv6PrefixLen', $data)) {
            $object->setGlobalIPv6PrefixLen($data['GlobalIPv6PrefixLen']);
        }
        if (\array_key_exists('MacAddress', $data)) {
            $object->setMacAddress($data['MacAddress']);
        }
        if (\array_key_exists('DriverOpts', $data) && null !== $data['DriverOpts']) {
            $values_2 = new \ArrayObject([], \ArrayObject::ARRAY_AS_PROPS);
            foreach ($data['DriverOpts'] as $key => $value_2) {
                $values_2[$key] = $value_2;
            }
            $object->setDriverOpts($values_2);
        } elseif (\array_key_exists('DriverOpts', $data) && null === $data['DriverOpts']) {
            $object->setDriverOpts(null);
        }

        return $object;
    }

    /**
     * @return array|string|int|float|bool|\ArrayObject|null
     */
    public function normalize($object, $format = null, array $context = [])
    {
        $data = [];
        if ($object->isInitialized('iPAMConfig') && null !== $object->getIPAMConfig()) {
            $data['IPAMConfig'] = $this->normalizer->normalize($object->getIPAMConfig(), 'json', $context);
        }
        if ($object->isInitialized('links') && null !== $object->getLinks()) {
            $values = [];
            foreach ($object->getLinks() as $value) {
                $values[] = $value;
            }
            $data['Links'] = $values;
        }
        if ($object->isInitialized('aliases') && null !== $object->getAliases()) {
            $values_1 = [];
            foreach ($object->getAliases() as $value_1) {
                $values_1[] = $value_1;
            }
            $data['Aliases'] = $values_1;
        }
        if ($object->isInitialized('networkID') && null !== $object->getNetworkID()) {
            $data['NetworkID'] = $object->getNetworkID();
        }
        if ($object->isInitialized('endpointID') && null !== $object->getEndpointID()) {
            $data['EndpointID'] = $object->getEndpointID();
        }
        if ($object->isInitialized('gateway') && null !== $object->getGateway()) {
            $data['Gateway'] = $object->getGateway();
        }
        if ($object->isInitialized('iPAddress') && null !== $object->getIPAddress()) {
            $data['IPAddress'] = $object->getIPAddress();
        }
        if ($object->isInitialized('iPPrefixLen') && null !== $object->getIPPrefixLen()) {
            $data['IPPrefixLen'] = $object->getIPPrefixLen();
        }
        if ($object->isInitialized('iPv6Gateway') && null !== $object->getIPv6Gateway()) {
            $data['IPv6Gateway'] = $object->getIPv6Gateway();
        }
        if ($object->isInitialized('globalIPv6Address') && null !== $object->getGlobalIPv6Address()) {
            $data['GlobalIPv6Address'] = $object->getGlobalIPv6Address();
        }
        if ($object->isInitialized('globalIPv6PrefixLen') && null !== $object->getGlobalIPv6PrefixLen()) {
            $data['GlobalIPv6PrefixLen'] = $object->getGlobalIPv6PrefixLen();
        }
        if ($object->isInitialized('macAddress') && null !== $object->getMacAddress()) {
            $data['MacAddress'] = $object->getMacAddress();
        }
        if ($object->isInitialized('driverOpts') && null !== $object->getDriverOpts()) {
            $values_2 = [];
            foreach ($object->getDriverOpts() as $key => $value_2) {
                $values_2[$key] = $value_2;
            }
            $data['DriverOpts'] = $values_2;
        }

        return $data;
    }

    public function getSupportedTypes(string $format = null): array
    {
        return ['App\\Service\\Docker\\Model\\EndpointSettings' => false];
    }
}
