<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;

class Referensi extends Model
{
    use HasFactory;

    protected $table = 'app_referensi';
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
        'parent_id',
        'referensi',
        'aktif',
    ];

    public function subReferensi()
    {
        return $this->hasMany(Referensi::class, 'parent_id', 'id');
    }

    public function scopepencarian($query, $value)
    {
        if ($value) {
            $query->where('referensi', 'like', '%' . $value . '%');
        }
    }
}
