<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    protected $fillable = ['code', 'name', 'description'];

    public function productions()
    {
        return $this->hasMany(Production::class);
    }
}
