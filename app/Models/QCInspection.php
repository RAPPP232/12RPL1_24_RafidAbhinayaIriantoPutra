<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QCInspection extends Model
{
    protected $table = 'qc_inspections';
    protected $fillable = [
        'production_id',
        'inspector_id',
        'result',
        'damage_type',
        'notes',
        'recommendation',
        'passed_quantity',
        'failed_quantity',
    ];

    public function production()
    {
        return $this->belongsTo(Production::class);
    }

    public function inspector()
    {
        return $this->belongsTo(User::class, 'inspector_id');
    }
}