<?php

namespace App\Models;

use App\Models\Traits\FilterableAndSortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Provider extends Model
{
    use HasFactory, FilterableAndSortable, SoftDeletes;

    protected $fillable = [
        'name', 
        'address', 
        'phone', 
        'description'
    ];

    public function getSearchableColumns() : array
    {
        return [
            'id',
            'name', 
            'address', 
            'phone', 
            'description'
        ];
    }

    public function getFilterableColumns() : array
    {
        return [
            'id',
            'name', 
            'address', 
            'phone', 
            'description'
        ];
    }

    public function getSortableColumns() : array
    {
        return [
            'id' => 'id',
            'name' => 'name', 
            'address' => 'address', 
            'phone' => 'phone',
            'description' => 'description'
        ];
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
