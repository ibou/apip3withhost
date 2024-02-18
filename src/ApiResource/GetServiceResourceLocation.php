<?php

declare(strict_types=1);

namespace App\ApiResource;

use App\Entity\Location\LocationCountryEnum;
use App\Entity\Location\LocationTypeEnum;

class GetServiceResourceLocation
{
    public string $name;

    public LocationCountryEnum $country;

    public LocationTypeEnum $type;
}