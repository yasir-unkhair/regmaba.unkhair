<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PesertauktDokumen extends Model
{
    use HasFactory;

    protected $table = 'app_peserta_has_dokumen';
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    public $incrementing = false;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid();
        });

        static::deleting(function ($model) {
            foreach ($model->berkas as $row) {
                $row->delete();
            }
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'peserta_id',
        'urutan',
        'dokumen',
        'berkas_id'
    ];

    public function peserta()
    {
        return $this->hasOne(Pesertaukt::class, 'id', 'peserta_id');
    }

    public function berkas()
    {
        return $this->hasOne(Berkas::class, 'id', 'berkas_id');
    }
}
