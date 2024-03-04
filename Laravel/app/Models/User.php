<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Traits\HasPermissionsTrait;

class User extends Authenticatable implements JWTSubject
{
    use HasPermissionsTrait, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

        'nama', 'id_kementerian', 'id_agensi', 'no_kp', 'jawatan', 'alamat_1', 'alamat_2', 'telefon_pejabat',
        'telefon_bimbit', 'fax', 'emel', 'kata_laluan', 'gambar', 'status_pengguna', 'id_peranan', 'login_terakhir',
        'login_semasa', 'remember_token', 'tarikh_daftar', 'id_pengguna_lulus', 'status_kemaskini', 'tarikh_kemaskini',
        'id_pengguna_kemaskini', 'kod_akses', 'tarikh_kod_akses', 'poskod', 'id_daerah', 'id_negeri', 'tukar_kata_laluan', 'catatan', 'hapus'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'kata_laluan',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    ];

    protected $table = 'tbl_pengguna';
    protected $primaryKey = 'id';
    public $timestamps = false;

    /**
     * Get JWT identifier.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getAuthPassword()
    {
        return $this->kata_laluan;
    }
}
