<?php

namespace Tnt\Sendcloud\Model;

use dry\orm\Model;
use dry\orm\relationship\HasMany;

/**
 * @property int $created
 * @property int $updated
 * @property int $sendcloud_id
 * @property string $name
 * @property string $address
 * @property string $city
 * @property string $postal_code
 * @property string $telephone
 * @property string $email
 * @property string $tracking_number
 * @property int $status
 * @property string $country
 * @property int $is_return
 * @property Label|null $label
 * @property ShipmentMethod|null $shipment_method
 */
class Parcel extends Model
{
    const TABLE = 'sendcloud_parcel';

    public static $special_fields = [
      'label' => Label::class,
      'shipment_method' => ShipmentMethod::class,
    ];

    public function getLabels(): HasMany
    {
        return $this->has_many(Label::class, 'parcel');
    }

    /**
     * @return void
     */
    public function delete()
    {
        foreach ($this->getLabels() as $label) {
            $label->delete();
        }

        parent::delete();
    }
}
