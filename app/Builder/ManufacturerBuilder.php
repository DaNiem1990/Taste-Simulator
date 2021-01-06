<?php


namespace App\Builder;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class ManufacturerBuilder extends Builder
{
    public function isNameExists(string $name): Builder
    {
        $this->where('name', '=', $name);
        return $this;
    }

    public function isOtherHasName(string $name, string $id): Builder
    {
        $this->where('name', '=', $name)->where('id', '<>', $id);
        return $this;
    }
}
