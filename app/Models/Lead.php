<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'import_id', 'first_name', 'last_name', 'email', 'mobile_number', 
        'street_1', 'street_2', 'city', 'state', 'country', 'lead_source', 'status'
    ];

    public function import()
    {
        return $this->belongsTo(Import::class);
    }
}
