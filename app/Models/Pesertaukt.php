<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pesertaukt extends Model
{
    use HasFactory;

    protected $table = 'app_peserta';
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
            foreach ($model->kondisikeluarga as $row) {
                $row->delete();
            }

            foreach ($model->pembiayaanstudi as $row) {
                $row->delete();
            }

            foreach ($model->dokumen as $row) {
                $row->delete();
            }

            foreach ($model->verifikasiberkas as $row) {
                $row->delete();
            }

            foreach ($model->pembayaran as $row) {
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
        'prodi_id',
        'fakultas_id',
        'setup_id',
        'user_id',
        'email',
        'nama_peserta',
        'jk',
        'golongan_darah',
        'agama',
        'tpl_lahir',
        'tgl_lahir',
        'nik',
        'thn_lulus',
        'jalur',
        'jpeserta',
        'nomor_peserta',
        'nisn',
        'npsn',
        'sekolah_asal',
        'alamat_asal',
        'alamat_tte',
        'hp',
        'hportu',
        'kip',
        'update_data_diri',
        'update_kondisi_keluarga',
        'update_pembiayaan_studi',
        'status',
        'registrasi',
        'npm',
        'tgl_generate',
        'created_at',
        'updated_at',
    ];

    public function scopepencarian($query, $value)
    {
        if ($value) {
            $query->where('nama_peserta', 'like', '%' . $value . '%')
                ->orWhere('nomor_peserta', 'like', '%' . $value . '%');
        }
    }

    public function scopeprodi($query, $value)
    {
        if ($value) {
            $query->where('prodi_id', '=', $value);
        }
    }

    public function scoperegistrasi($query, $value)
    {
        if ($value) {
            $query->where('registrasi', '=', $value);
        }
    }

    public function scopesetup($query, $value)
    {
        if ($value) {
            $query->where('setup_id', '=', $value);
        }
    }

    public function scopestatus($query, $value)
    {
        if ($value) {
            $query->whereIn('status', $value);
        }
    }


    public function fakultas()
    {
        return $this->hasOne(Fakultas::class, 'id', 'fakultas_id');
    }

    public function prodi()
    {
        return $this->hasOne(Prodi::class, 'id', 'prodi_id');
    }

    public function setup()
    {
        return $this->hasOne(Setup::class, 'id', 'setup_id');
    }

    public function kondisikeluarga()
    {
        return $this->hasOne(PesertauktKondisiKeluarga::class, 'peserta_id', 'id');
    }

    public function pembiayaanstudi()
    {
        return $this->hasOne(PesertauktPembiayaanStudi::class, 'peserta_id', 'id');
    }

    public function berkasdukung()
    {
        return $this->hasOne(PesertauktDokumen::class, 'peserta_id', 'id');
    }

    public function verifikasiberkas()
    {
        return $this->hasOne(PesertauktVerifikasiBerkas::class, 'peserta_id', 'id');
    }

    public function pembayaran()
    {
        return $this->hasOne(PesertauktPembayaran::class, 'peserta_id', 'id');
    }

    public function prosesdata()
    {
        return $this->hasMany(ProsesData::class, 'source', 'id');
    }
}
