<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProsesData extends Model
{
    use HasFactory;

    protected $table = 'app_proccess_data';

    protected $fillable = [
        'source',
        'queue'
    ];
}
