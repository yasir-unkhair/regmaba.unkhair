<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Postingan extends Model
{
    use HasFactory;

    protected $table = 'app_postingan';
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
        'user_id',
        'judul',
        'konten',
        'slug',
        'berkas_id',
        'publish',
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['user', 'banner'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function banner()
    {
        return $this->hasOne(Berkas::class, 'id', 'berkas_id');
    }

    public function scopepencarian($query, $value)
    {
        if ($value) {
            $query->where('judul', 'like', '%' . $value . '%');
        }
    }
}
