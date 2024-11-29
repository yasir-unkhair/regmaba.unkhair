<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'user_simak',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function peserta()
    {
        return $this->hasOne(Pesertaukt::class, 'user_id', 'id');
    }

    public function formulirukt_selesai_input()
    {
        $update_data_diri = $this->peserta->update_data_diri;
        $update_kondisi_keluarga = $this->peserta->update_kondisi_keluarga;
        $update_pembiayaan_studi = $this->peserta->update_pembiayaan_studi;

        if ($update_data_diri && $update_kondisi_keluarga && $update_pembiayaan_studi) {
            return TRUE;
        }
        return FALSE;
    }

    public function status_peserta()
    {
        return $this->peserta->status;
    }

    public function akses_formulirukt()
    {
        $setup = get_setup();
        $jalur = strtoupper($this->peserta->jalur);

        if ($jalur == 'SNMP') {
            if ($setup && $setup->pengisian_snbp) {
                if (!status_jadwal($setup->pengisian_snbp)) {
                    return FALSE;
                }
            }
        }

        // jalur SNBT
        elseif ($jalur == 'SNBT') {
            if ($setup && $setup->pengisian_snbt) {
                if (!status_jadwal($setup->pengisian_snbt)) {
                    return FALSE;
                }
            }
        }

        // jalur Mandiri
        elseif ($jalur == 'MANDIRI') {
            if ($setup && $setup->pengisian_mandiri) {
                if (!status_jadwal($setup->pengisian_mandiri)) {
                    return FALSE;
                }
            }
        }

        return TRUE;
    }

    public function scopepencarian($query, $value)
    {
        if ($value) {
            $query->where('name', 'like', '%' . $value . '%')
                ->orWhere('email', 'like', '%' . $value . '%');
        }
    }

    public function verifikasipeserta()
    {
        return $this->hasMany(PesertauktVerifikasiBerkas::class, 'verifikator_id', 'id')
            ->leftJoin('app_peserta', 'app_peserta_has_verifikasiberkas.peserta_id', '=', 'app_peserta.id')
            ->leftJoin('app_prodi', 'app_peserta.prodi_id', '=', 'app_prodi.id');
    }
}
