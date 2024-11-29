<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProdiBiayastudi extends Model
{
    use HasFactory;

    protected $table = 'app_biayastudi';
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'prodi_id',
        'jenis_biaya',
        'nominal',
        'kategori'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    public function scopebyprodi($query, $value)
    {
        if ($value) {
            $query->where('prodi_id', '=', $value);
        }
    }

    public function scopejenisbiaya($query, $value)
    {
        if ($value) {
            $query->where('jenis_biaya', '=', $value);
        }
    }

    public function prodi()
    {
        return $this->hasOne(Prodi::class, 'id', 'prodi_id');
    }
}
