<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $machine_id
 * @property int|null $product_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Machine $machine
 * @property-read Product|null $product
 *
 * @method static Builder<static>|SelectedProduct newModelQuery()
 * @method static Builder<static>|SelectedProduct newQuery()
 * @method static Builder<static>|SelectedProduct query()
 * @method static Builder<static>|SelectedProduct whereCreatedAt($value)
 * @method static Builder<static>|SelectedProduct whereId($value)
 * @method static Builder<static>|SelectedProduct whereMachineId($value)
 * @method static Builder<static>|SelectedProduct whereProductId($value)
 * @method static Builder<static>|SelectedProduct whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
class SelectedProduct extends Model
{
    protected $guarded = ['id'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function machine(): BelongsTo
    {
        return $this->belongsTo(Machine::class);
    }
}
