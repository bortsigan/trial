<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function structure()
    {
        return $this->hasOne(ProductStructure::class);
    }

    public function subscriptionSelection()
    {
        return $this->hasMany(SubscriptionSelection::class);
    }
}
