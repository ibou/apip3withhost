<?php

declare(strict_types=1);

namespace App\Message\SteamAuthorizeCommand;

use App\ApiResource\SteamAuthParameters;
use InvalidArgumentException;

class DataFactory
{
    public function createFromArray(array $parameters): Data
    {
        $filtered = [];
        foreach (SteamAuthParameters::PARAMETERS as $param)
        {
            $shortName = substr($param['name'], 7);
            $name = 'openid_' . $shortName;

            if (!array_key_exists($name, $parameters)) {
                throw new InvalidArgumentException(sprintf('Parameter [%s] is missing.', $name));
            }

            $filtered[$shortName] = $parameters[$name];
        }

        return new Data(...$filtered);
    }
}