<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Example extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'value'
    ];

    public $timestamps = false;
    protected $table = "example_data";
}
