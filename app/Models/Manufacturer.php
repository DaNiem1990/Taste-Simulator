<?php

namespace App\Models;

use App\Builder\ManufacturerBuilder;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Manufacturer
 * @package App\Models
 *
 * @property integer $id
 * @proterty string $name
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Manufacturer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public static function query() : Builder
    {
        return parent::query();
    }

    public function newEloquentBuilder($query): Builder
    {
        return new ManufacturerBuilder($query);
    }
}
