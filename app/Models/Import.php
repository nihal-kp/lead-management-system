<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    protected $fillable = [
        'file_name', 
        'status', 
        'errors',
    ];

    protected $casts = [
        'errors' => 'array',  // Make sure errors is stored as an array
    ];

    public function leads()
    {
        return $this->hasMany(Lead::class); 
    }
}
