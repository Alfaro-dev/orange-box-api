<?php

namespace App\Models;

use App\Models\Traits\FilterableAndSortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, FilterableAndSortable, SoftDeletes;

    protected $fillable = [
        'name', 
        'price', 
        'stock',
        'description', 
        'provider_id'
    ];

    public function getSearchableColumns() : array
    {
        return [
            'id',
            'name', 
            'price', 
            'stock', 
            'description',
            'provider_name' => 'provider.name'
        ];
    }

    public function getFilterableColumns() : array
    {
        return [
            'id',
            'name', 
            'price', 
            'stock', 
            'description',
            'provider_name' => 'provider.name'
        ];
    }

    public function getSortableColumns() : array
    {
        return [
            'id' => 'id',
            'name' => 'name', 
            'price' => 'price', 
            'stock' => 'stock',
            'description' => 'description',
            'provider_name' => 'provider.name'
        ];
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }
}
