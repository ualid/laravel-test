<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Number extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'numbers';

    protected $fillable = [
        'number',
        'customer_id',
        'status_id',

    ];
    public function numberPreference()
    {
        return $this->hasMany(NumberPreference::class);
    }

    protected static $relations_to_cascade = ['numberPreference'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function($resource) {
            foreach (static::$relations_to_cascade as $relation) {
                foreach ($resource->{$relation}()->get() as $item) {
                    $item->delete();
                }
            }
        });
    }
}
