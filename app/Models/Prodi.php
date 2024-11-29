<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    use HasFactory;

    protected $table = 'app_prodi';
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'fakultas_id',
        'kode_prodi',
        'nama_prodi',
        'status',
        'jenjang_prodi'
    ];

    public function fakultas()
    {
        return $this->hasOne(Fakultas::class, 'id', 'fakultas_id');
    }

    public function scopepencarian($query, $value)
    {
        if ($value) {
            $query->where('kode_prodi', 'like', '%' . $value . '%')
                ->orWhere('nama_prodi', 'like', '%' . $value . '%')
                ->orWhere('jenjang_prodi', 'like', '%' . $value . '%');
        }
    }

    public function biayastudi()
    {
        return $this->hasMany(ProdiBiayastudi::class, 'prodi_id', 'id');
    }

    public function scopebyFakultas($query, $value)
    {
        if ($value) {
            $query->where('fakultas_id', '=', $value);
        }
    }
}
