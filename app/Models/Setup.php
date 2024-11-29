<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Setup extends Model
{
    use HasFactory;

    protected $table = 'app_setup';
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    public $incrementing = false;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tahun',

        'registrasi_snbp',
        'pengisian_snbp',
        'pembayaran_snbp',

        'registrasi_snbt',
        'pengisian_snbt',
        'pembayaran_snbt',

        'registrasi_mandiri',
        'pengisian_mandiri',
        'pembayaran_mandiri',

        'aktif',
        'tampil',
    ];
}
