<?php

declare(strict_types=1);

namespace App\Service;

use App\Service\SimpleMapper\DifferentPropertyType;
use App\Service\SimpleMapper\MissingSourceProperty;
use InvalidArgumentException;
use Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionNamedType;
use ReflectionObject;
use ReflectionProperty;
use ReflectionType;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class SimpleMapper
{
    /**
     * @var array<string, ReflectionClass>
     */
    private array $reflectionClasses = [];
    /**
     * @var array<string, ReflectionObject>
     */
    private array $reflectionObjects = [];

    public function __construct(
        #[Autowire('@service_container')] private ContainerInterface $container,
    ) {
    }

    public function mapToEntity(object $source, string $targetClass): object
    {
        return new $targetClass(...$this->parseArguments($source, $targetClass));
    }

    public function mapToResourceApi(object $source, string $targetClass): object
    {
        $sourceReflection = $this->getReflectionObject($source);
        $targetReflection = $this->getReflectionClass($targetClass);

        $sourceParent = $sourceReflection->getParentClass();

        if (
            $sourceReflection->name === $targetReflection->name
            || ($sourceParent && $sourceParent->name === $targetReflection->name)
        ) {
            return $source;
        }

        $target = $targetReflection->newInstance();

        foreach ($targetReflection->getProperties() as $targetProperty)
        {
            $targetType = $targetReflection->getProperty($targetProperty->name)->getType();

            $value = $this->getValue(
                $source,
                $targetClass,
                $sourceReflection,
                $targetProperty,
                $targetType,
            );

            if (
                $targetProperty->getType()->isBuiltin()
                && !$this->isTheSameType($value, $targetType)
                && (
                    !$targetType->allowsNull()
                    && is_null($value)
                )
            ) {
                throw new DifferentPropertyType(
                    $targetProperty->name,
                    $sourceReflection->name,
                    $targetReflection->name,
                );
            }

            $target->{$targetProperty->name} = $value;
        }

        return  $target;
    }

    protected function getReflectionClass(string $class): ReflectionClass
    {
        return $this->reflectionClasses[$class] = $this->reflectionClasses[$class] ?? new ReflectionClass($class);
    }

    protected function getReflectionObject(object $object): ReflectionObject
    {
        return $this->reflectionObjects[$object::class] = $this->reflectionObjects[$object::class] ?? new ReflectionObject($object);
    }

    protected function parseArguments(object $source, string $targetClass): array
    {
        $rc = $this->getReflectionClass($targetClass);
        $method = $rc->getMethod('__construct');
        $parameters = $method->getParameters();

        $arguments = [];

        foreach($parameters as $parameter)
        {
            $name = $parameter->getName();
            if (property_exists($source, $name)) {
                $arguments[] = $source->$name;
                continue;
            }

            $parameterType = $parameter->getType();
            $parameterName = $parameterType->getName();
            if (strpos($parameterName, '\\')) {
                $arguments[] = $this->container->get($parameterName);
                continue;
            }

            if ($parameter->isDefaultValueAvailable()) {
                $arguments[] = $parameter->getDefaultValue();
                continue;
            }

            throw new InvalidArgumentException(sprintf(
                'Cannot instantiate class [%s] using arguments properties from [%s]. Unable to resolve [%s] argument.',
                $targetClass,
                get_class($source),
                $parameterName
            ));
        }

        return $arguments;
    }

    private function makeGetterName(string $propertyName): string
    {
        return 'get' . ucfirst($propertyName);
    }

    private function getValueFromProperty(
        object $source,
        ReflectionProperty $sourceProperty,
        ReflectionType $targetType
    ): mixed
    {
        if ($targetType->isBuiltin() || interface_exists((string)$targetType, false)) {
            return $sourceProperty->getValue($source);
        }

        return $this->mapToResourceApi($sourceProperty->getValue($source), $targetType->getName());
    }

    private function getValue(
        mixed $source,
        string $targetClass,
        ReflectionObject $sourceReflection,
        ReflectionProperty $targetProperty,
        ReflectionType $targetType,
    ): mixed
    {
        if ($sourceReflection->hasProperty($targetProperty->name))
        {
            $sourceProperty = $sourceReflection->getProperty($targetProperty->name);

            return $this->getValueFromProperty(
                $source,
                $sourceProperty,
                $targetType
            );
        }

        $getterName = $this->makeGetterName($targetProperty->name);
        if ($sourceReflection->hasMethod($getterName)) {
            return call_user_func([$source, $getterName]);
        }

        throw new MissingSourceProperty($targetProperty->name, $sourceReflection->name, $targetClass);
    }

    private function isTheSameType(mixed $value, ReflectionNamedType $targetType): bool
    {
        $valueType = gettype($value);
        if ('boolean' === $valueType) {
            $valueType = 'bool';
        }
        return $valueType === $targetType->getName();
    }
}