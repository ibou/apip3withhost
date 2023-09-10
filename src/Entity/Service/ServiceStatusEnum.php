<?php

declare(strict_types=1);

namespace App\Entity\Service;

use App\ApiResource\ServiceStatusEnumTrait;

/**
 * @method static self CREATING()
 * @method static self STARTING()
 * @method static self RUNNING()
 * @method static self STOPPING()
 * @method static self STOPPED()
 */
enum ServiceStatusEnum: string
{
    use ServiceStatusEnumTrait;

    case STATUS_CREATING = 'creating';
    case STATUS_STARTING = 'starting';
    case STATUS_RUNNING = 'running';
    case STATUS_STOPPING = 'stopping';
    case STATUS_STOPPED = 'stopped';
}
