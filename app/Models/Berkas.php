<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;

class Berkas extends Model
{
    use HasFactory;

    protected $table = 'app_berkas';
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

    public function hapus($id_berkas)
    {
        return Berkas::destroy($id_berkas);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name_berkas', 'path_berkas', 'url_berkas', 'type_berkas', 'size_berkas', 'penyimpanan'];
}
