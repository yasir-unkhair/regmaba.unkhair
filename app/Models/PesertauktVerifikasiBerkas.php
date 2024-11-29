<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PesertauktVerifikasiBerkas extends Model
{
    use HasFactory;

    protected $table = 'app_peserta_has_verifikasiberkas';
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
        'verifikator_id',
        'catatan',
        'rekomendasi',
        'verifies_id',
        'tgl_verifikasi',
        'vonis_ukt',
        'nominal_ukt',
        'vonis_ipi',
        'nominal_ipi',
        'tgl_vonis',
        'user_id_vonis',
        'bayar_ukt',
        'bayar_ipi'
    ];

    public static function listRekomendasi($field, $key = NULL)
    {
        $instance = new static;
        $type = DB::select(DB::raw('SHOW COLUMNS FROM ' . $instance->getTable() . ' WHERE Field = "' . $field . '"')->getValue(DB::connection()->getQueryGrammar()))[0]->Type;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $values = array();
        foreach (explode(',', $matches[1]) as $value) {
            $data = trim($value, "'");
            $values[] = $data;
        }

        if ($key) {
            $valueOne = [];
            foreach ($values as $row) {
                if ($row == $key) {
                    $valueOne[] = $row;
                }
            }
            return $valueOne;
        }

        return $values;
    }

    public function peserta()
    {
        return $this->hasOne(Pesertaukt::class, 'id', 'peserta_id');
    }

    public function verifikator()
    {
        return $this->hasOne(User::class, 'id', 'verifikator_id');
    }

    public function userverifies()
    {
        return $this->hasOne(User::class, 'id', 'verifies_id');
    }

    public function uservonis()
    {
        return $this->hasOne(User::class, 'id', 'user_id_vonis');
    }
}
