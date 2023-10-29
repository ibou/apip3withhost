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

class SwarmSpecNormalizer implements DenormalizerInterface, NormalizerInterface, DenormalizerAwareInterface, NormalizerAwareInterface
{
    use DenormalizerAwareTrait;
    use NormalizerAwareTrait;
    use CheckArray;
    use ValidatorTrait;

    public function supportsDenormalization($data, $type, $format = null, array $context = []): bool
    {
        return 'App\\Service\\Docker\\Model\\SwarmSpec' === $type;
    }

    public function supportsNormalization($data, $format = null, array $context = []): bool
    {
        return is_object($data) && 'App\\Service\\Docker\\Model\\SwarmSpec' === get_class($data);
    }

    public function denormalize($data, $class, $format = null, array $context = []): mixed
    {
        if (isset($data['$ref'])) {
            return new Reference($data['$ref'], $context['document-origin']);
        }
        if (isset($data['$recursiveRef'])) {
            return new Reference($data['$recursiveRef'], $context['document-origin']);
        }
        $object = new \App\Service\Docker\Model\SwarmSpec();
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
        if (\array_key_exists('Orchestration', $data) && null !== $data['Orchestration']) {
            $object->setOrchestration($this->denormalizer->denormalize($data['Orchestration'], 'App\\Service\\Docker\\Model\\SwarmSpecOrchestration', 'json', $context));
        } elseif (\array_key_exists('Orchestration', $data) && null === $data['Orchestration']) {
            $object->setOrchestration(null);
        }
        if (\array_key_exists('Raft', $data)) {
            $object->setRaft($this->denormalizer->denormalize($data['Raft'], 'App\\Service\\Docker\\Model\\SwarmSpecRaft', 'json', $context));
        }
        if (\array_key_exists('Dispatcher', $data) && null !== $data['Dispatcher']) {
            $object->setDispatcher($this->denormalizer->denormalize($data['Dispatcher'], 'App\\Service\\Docker\\Model\\SwarmSpecDispatcher', 'json', $context));
        } elseif (\array_key_exists('Dispatcher', $data) && null === $data['Dispatcher']) {
            $object->setDispatcher(null);
        }
        if (\array_key_exists('CAConfig', $data) && null !== $data['CAConfig']) {
            $object->setCAConfig($this->denormalizer->denormalize($data['CAConfig'], 'App\\Service\\Docker\\Model\\SwarmSpecCAConfig', 'json', $context));
        } elseif (\array_key_exists('CAConfig', $data) && null === $data['CAConfig']) {
            $object->setCAConfig(null);
        }
        if (\array_key_exists('EncryptionConfig', $data)) {
            $object->setEncryptionConfig($this->denormalizer->denormalize($data['EncryptionConfig'], 'App\\Service\\Docker\\Model\\SwarmSpecEncryptionConfig', 'json', $context));
        }
        if (\array_key_exists('TaskDefaults', $data)) {
            $object->setTaskDefaults($this->denormalizer->denormalize($data['TaskDefaults'], 'App\\Service\\Docker\\Model\\SwarmSpecTaskDefaults', 'json', $context));
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
        if ($object->isInitialized('orchestration') && null !== $object->getOrchestration()) {
            $data['Orchestration'] = $this->normalizer->normalize($object->getOrchestration(), 'json', $context);
        }
        if ($object->isInitialized('raft') && null !== $object->getRaft()) {
            $data['Raft'] = $this->normalizer->normalize($object->getRaft(), 'json', $context);
        }
        if ($object->isInitialized('dispatcher') && null !== $object->getDispatcher()) {
            $data['Dispatcher'] = $this->normalizer->normalize($object->getDispatcher(), 'json', $context);
        }
        if ($object->isInitialized('cAConfig') && null !== $object->getCAConfig()) {
            $data['CAConfig'] = $this->normalizer->normalize($object->getCAConfig(), 'json', $context);
        }
        if ($object->isInitialized('encryptionConfig') && null !== $object->getEncryptionConfig()) {
            $data['EncryptionConfig'] = $this->normalizer->normalize($object->getEncryptionConfig(), 'json', $context);
        }
        if ($object->isInitialized('taskDefaults') && null !== $object->getTaskDefaults()) {
            $data['TaskDefaults'] = $this->normalizer->normalize($object->getTaskDefaults(), 'json', $context);
        }

        return $data;
    }

    public function getSupportedTypes(string $format = null): array
    {
        return ['App\\Service\\Docker\\Model\\SwarmSpec' => false];
    }
}
