<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PesertauktKondisiKeluarga extends Model
{
    use HasFactory;

    protected $table = 'app_peserta_has_kondisikeluarga';
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
        'nama_ayah',
        'nama_ibu',
        'nama_wali',
        'keberadaan_ortu',
        'jml_kakak',
        'jml_adik',
        'jml_kuliah',
        'jml_sekolah',
        'pekerjaan_ayah',
        'pangkat_ayah',
        'penghasilan_ayah',
        'pekerjaan_ibu',
        'pangkat_ibu',
        'penghasilan_ibu',
        'pebanding_penghasilan_ayah',
        'pebanding_penghasilan_ibu',
        'luas_lahan',
        'aset_ortu',
        'kepemilikan_rumah',
        'kondisi_rumah',
        'lokasi_rumah',
        'daya_listrik',
        'bantuan_siswa_miskin'
    ];

    public function peserta()
    {
        return $this->hasOne(Pesertaukt::class, 'id', 'peserta_id');
    }
}
