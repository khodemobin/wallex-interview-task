<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $guarded = ['id'];

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function reduceStock(int $quantity = 1): bool
    {
        if ($this->stock >= $quantity) {
            $this->stock -= $quantity;

            return $this->save();
        }

        return false;
    }
}
