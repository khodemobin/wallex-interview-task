<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property int $machine_id
 * @property int $stock
 * @property int $price
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Machine $machine
 *
 * @method static Builder<static>|Product newModelQuery()
 * @method static Builder<static>|Product newQuery()
 * @method static Builder<static>|Product query()
 * @method static Builder<static>|Product whereCreatedAt($value)
 * @method static Builder<static>|Product whereId($value)
 * @method static Builder<static>|Product whereMachineId($value)
 * @method static Builder<static>|Product whereName($value)
 * @method static Builder<static>|Product wherePrice($value)
 * @method static Builder<static>|Product whereStock($value)
 * @method static Builder<static>|Product whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
class Product extends Model
{
    protected $guarded = ['id'];

    public function machine(): BelongsTo
    {
        return $this->belongsTo(Machine::class);
    }
}
