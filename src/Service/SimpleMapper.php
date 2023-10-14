<?php

declare(strict_types=1);

namespace App\Service;

use InvalidArgumentException;
use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

readonly class SimpleMapper
{
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
        $target = new $targetClass;
        foreach (get_object_vars($source) as $name => $value)
        {
            if (!property_exists($target, $name)) {
                continue;
            }
            $target->$name = $value;
        }

        return  $target;
    }

    protected function parseArguments(object $source, string $targetClass): array
    {
        $rc = new \ReflectionClass($targetClass);
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
}