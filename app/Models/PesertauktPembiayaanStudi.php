<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PesertauktPembiayaanStudi extends Model
{
    use HasFactory;

    protected $table = 'app_peserta_has_pembiayaanstudi';
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
        'peserta_id',
        'biaya_studi',
        'pekerjaan_sendiri',
        'detail_pekerjaan_sendiri',
        'pangkat_sendiri',
        'lahan_sendiri',
        'aset_sendiri',
        'aset_lainnya',
        'penghasilan_sendiri',
        'wali',
        'pekerjaan_wali',
        'pangkat_wali',
        'lahan_wali',
        'aset_wali',
        'aset_wali_lainnya',
        'penghasilan_wali'
    ];

    public function peserta()
    {
        return $this->hasOne(Pesertaukt::class, 'id', 'peserta_id');
    }
}
