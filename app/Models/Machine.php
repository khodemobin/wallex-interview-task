<?php

namespace App\Models;

use App\States\CoinInsertedState;
use App\States\DispensingState;
use App\States\IdleState;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * @property int $id
 * @property string|null $name
 * @property int $balance
 * @property string $state
 * @property int $version
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Product> $products
 * @property-read int|null $products_count
 * @property-read SelectedProduct|null $selectedProduct
 *
 * @method static Builder<static>|Machine newModelQuery()
 * @method static Builder<static>|Machine newQuery()
 * @method static Builder<static>|Machine query()
 * @method static Builder<static>|Machine whereBalance($value)
 * @method static Builder<static>|Machine whereCreatedAt($value)
 * @method static Builder<static>|Machine whereId($value)
 * @method static Builder<static>|Machine whereName($value)
 * @method static Builder<static>|Machine whereState($value)
 * @method static Builder<static>|Machine whereUpdatedAt($value)
 * @method static Builder<static>|Machine whereVersion($value)
 *
 * @mixin Eloquent
 */
class Machine extends Model
{
    protected $guarded = ['id'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function selectedProduct(): HasOne
    {
        return $this->hasOne(SelectedProduct::class);
    }

    /**
     * @return mixed
     *
     * use optimistic locking to prevent race condition
     *
     * @throws Throwable
     */
    public static function updateState(Machine $machine, $newState): mixed
    {
        return DB::transaction(static function () use ($machine, $newState) {
            if (! Machine::canTransition($machine->state, $newState)) {
                return false;
            }

            $updated = Machine::query()
                ->where('id', $machine->id)
                ->where('version', $machine->version)
                ->update([
                    'state' => $newState,
                    'version' => $machine->version + 1,
                ]);

            return $updated ? Machine::query()->find($machine->id) : false;
        });
    }

    public static function canTransition($state, $newState): bool
    {
        return match ($state) {
            IdleState::class => $newState === CoinInsertedState::class,
            CoinInsertedState::class => $newState === DispensingState::class,
            DispensingState::class => $newState === IdleState::class,
            default => false,
        };
    }
}
