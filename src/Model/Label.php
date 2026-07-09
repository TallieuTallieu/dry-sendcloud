<?php

namespace Tnt\Sendcloud\Model;

use dry\orm\Model;
use dry\orm\special\JSON;

/**
 * @property int $created
 * @property int $updated
 * @property array<string, mixed> $normal_printer
 * @property string $label_printer
 */
class Label extends Model
{
    const TABLE = 'sendcloud_label';

    public static $special_fields = [
        'normal_printer' => JSON::class,
    ];
}
