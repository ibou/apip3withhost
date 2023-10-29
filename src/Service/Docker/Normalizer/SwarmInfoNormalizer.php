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

class SwarmInfoNormalizer implements DenormalizerInterface, NormalizerInterface, DenormalizerAwareInterface, NormalizerAwareInterface
{
    use DenormalizerAwareTrait;
    use NormalizerAwareTrait;
    use CheckArray;
    use ValidatorTrait;

    public function supportsDenormalization($data, $type, $format = null, array $context = []): bool
    {
        return 'App\\Service\\Docker\\Model\\SwarmInfo' === $type;
    }

    public function supportsNormalization($data, $format = null, array $context = []): bool
    {
        return is_object($data) && 'App\\Service\\Docker\\Model\\SwarmInfo' === get_class($data);
    }

    public function denormalize($data, $class, $format = null, array $context = []): mixed
    {
        if (isset($data['$ref'])) {
            return new Reference($data['$ref'], $context['document-origin']);
        }
        if (isset($data['$recursiveRef'])) {
            return new Reference($data['$recursiveRef'], $context['document-origin']);
        }
        $object = new \App\Service\Docker\Model\SwarmInfo();
        if (null === $data || false === \is_array($data)) {
            return $object;
        }
        if (\array_key_exists('NodeID', $data)) {
            $object->setNodeID($data['NodeID']);
        }
        if (\array_key_exists('NodeAddr', $data)) {
            $object->setNodeAddr($data['NodeAddr']);
        }
        if (\array_key_exists('LocalNodeState', $data)) {
            $object->setLocalNodeState($data['LocalNodeState']);
        }
        if (\array_key_exists('ControlAvailable', $data)) {
            $object->setControlAvailable($data['ControlAvailable']);
        }
        if (\array_key_exists('Error', $data)) {
            $object->setError($data['Error']);
        }
        if (\array_key_exists('RemoteManagers', $data) && null !== $data['RemoteManagers']) {
            $values = [];
            foreach ($data['RemoteManagers'] as $value) {
                $values[] = $this->denormalizer->denormalize($value, 'App\\Service\\Docker\\Model\\PeerNode', 'json', $context);
            }
            $object->setRemoteManagers($values);
        } elseif (\array_key_exists('RemoteManagers', $data) && null === $data['RemoteManagers']) {
            $object->setRemoteManagers(null);
        }
        if (\array_key_exists('Nodes', $data) && null !== $data['Nodes']) {
            $object->setNodes($data['Nodes']);
        } elseif (\array_key_exists('Nodes', $data) && null === $data['Nodes']) {
            $object->setNodes(null);
        }
        if (\array_key_exists('Managers', $data) && null !== $data['Managers']) {
            $object->setManagers($data['Managers']);
        } elseif (\array_key_exists('Managers', $data) && null === $data['Managers']) {
            $object->setManagers(null);
        }
        if (\array_key_exists('Cluster', $data) && null !== $data['Cluster']) {
            $object->setCluster($this->denormalizer->denormalize($data['Cluster'], 'App\\Service\\Docker\\Model\\ClusterInfo', 'json', $context));
        } elseif (\array_key_exists('Cluster', $data) && null === $data['Cluster']) {
            $object->setCluster(null);
        }

        return $object;
    }

    /**
     * @return array|string|int|float|bool|\ArrayObject|null
     */
    public function normalize($object, $format = null, array $context = [])
    {
        $data = [];
        if ($object->isInitialized('nodeID') && null !== $object->getNodeID()) {
            $data['NodeID'] = $object->getNodeID();
        }
        if ($object->isInitialized('nodeAddr') && null !== $object->getNodeAddr()) {
            $data['NodeAddr'] = $object->getNodeAddr();
        }
        if ($object->isInitialized('localNodeState') && null !== $object->getLocalNodeState()) {
            $data['LocalNodeState'] = $object->getLocalNodeState();
        }
        if ($object->isInitialized('controlAvailable') && null !== $object->getControlAvailable()) {
            $data['ControlAvailable'] = $object->getControlAvailable();
        }
        if ($object->isInitialized('error') && null !== $object->getError()) {
            $data['Error'] = $object->getError();
        }
        if ($object->isInitialized('remoteManagers') && null !== $object->getRemoteManagers()) {
            $values = [];
            foreach ($object->getRemoteManagers() as $value) {
                $values[] = $this->normalizer->normalize($value, 'json', $context);
            }
            $data['RemoteManagers'] = $values;
        }
        if ($object->isInitialized('nodes') && null !== $object->getNodes()) {
            $data['Nodes'] = $object->getNodes();
        }
        if ($object->isInitialized('managers') && null !== $object->getManagers()) {
            $data['Managers'] = $object->getManagers();
        }
        if ($object->isInitialized('cluster') && null !== $object->getCluster()) {
            $data['Cluster'] = $this->normalizer->normalize($object->getCluster(), 'json', $context);
        }

        return $data;
    }

    public function getSupportedTypes(string $format = null): array
    {
        return ['App\\Service\\Docker\\Model\\SwarmInfo' => false];
    }
}
