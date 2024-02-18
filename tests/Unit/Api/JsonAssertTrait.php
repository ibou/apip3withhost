<?php

declare(strict_types=1);

namespace App\Tests\Unit\Api;

use Exception;
use InvalidArgumentException;
use JsonSchema\Validator;
use stdClass;

trait JsonAssertTrait
{
    protected function assertJsonSchema(array $expectedSchema, string $json): void
    {
        $schema = $this->normalize($expectedSchema);
        $validator = new Validator();
        $body = json_decode($json, false, 32, JSON_THROW_ON_ERROR);

        $validator->validate($body, $schema);
        if ($validator->isValid()) {
            return;
        }

        throw new Exception(json_encode($validator->getErrors(), JSON_PRETTY_PRINT));
    }

    private function normalize(mixed $schema): stdClass
    {
        if (is_string($schema)) {
            return (object) ['type' => $schema];
        }
        if (!is_array($schema)) {
            throw new InvalidArgumentException('Schema entry may be only string or array.');
        }
        if (array_key_exists('oneOf', $schema)) {
            return $this->normalizeOneOf($schema);
        }
        if (!array_key_exists('type', $schema)) {
            throw new InvalidArgumentException('Missing type for non string representation.');
        }
        if ('object' === $schema['type']) {
            return $this->normalizeObject($schema);
        }
        if ('array' === $schema['type']) {
            return $this->normalizeArray($schema);
        }

        return (object) $schema;
    }

    private function normalizeOneOf(array $oneOf): stdClass
    {
        if (!is_array($oneOf['oneOf'])) {
            throw new InvalidArgumentException('Parameter [oneOf] should be an array.');
        }
        $entry = [];
        foreach ($oneOf['oneOf'] as $item) {
            $entry[] = $this->normalize($item);
        }

        return (object) ['oneOf' => $entry];
    }

    private function normalizeArray(array $array): stdClass
    {
        if (!array_key_exists('items', $array)) {
            throw new InvalidArgumentException('Parameter [items] for array type schema is missing.');
        }

        return (object) ['type' => 'array', 'items' => $this->normalize($array['items'])];
    }

    private function normalizeObject(array $schema): stdClass
    {
        if (!array_key_exists('properties', $schema)) {
            throw new InvalidArgumentException('Parameter [properties] for object type schema is missing.');
        }
        $entry = ['type' => 'object', 'properties' => []];
        foreach ($schema['properties'] as $name => $property) {
            $entry['properties'][$name] = $this->normalize($property);
        }
        $entry['required'] = $schema['required'] ?? array_keys($schema['properties']);
        $entry['additionalProperties'] = $schema['additionalProperties'] ?? false;

        return (object) $entry;
    }
}
