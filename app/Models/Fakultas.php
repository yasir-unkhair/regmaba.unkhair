<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
    use HasFactory;

    protected $table = 'app_fakultas';
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'nama_fakultas',
        'status'
    ];

    public function prodi()
    {
        return $this->hasMany(Prodi::class, 'fakultas_id', 'id');
    }

    public function scopepencarian($query, $value)
    {
        if ($value) {
            $query->where('nama_fakultas', 'like', '%' . $value . '%');
        }
    }
}
