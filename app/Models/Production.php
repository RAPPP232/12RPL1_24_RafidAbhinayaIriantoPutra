<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    protected $fillable = [
        'part_id',
        'operator_id',
        'production_date',
        'quantity',
        'status',
        'notes',
    ];

    protected $casts = [
        'production_date' => 'date',
    ];

    public function part()
    {
        return $this->belongsTo(Part::class);
    }

    public function operator()
    {
        return $this->belongsTo(User::class, 'operator_id');
    }

    public function qcInspection()
    {
        return $this->hasOne(QCInspection::class);
    }
}
