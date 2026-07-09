<?php

namespace Tnt\Sendcloud\Model;

use dry\orm\Model;

/**
 * @property int $created
 * @property int $updated
 * @property int $sort_index
 * @property int $sendcloud_id
 * @property string $name
 * @property string $carrier
 */
class ShipmentMethod extends Model
{
    const TABLE = 'sendcloud_shipment_method';
}
