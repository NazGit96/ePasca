<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefBencanaNegeri extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_bencana', 'id_negeri', 'status_bencana_negeri', 'tarikh_cipta', 'id_pengguna_cipta', 'tarikh_kemaskini', 'id_pengguna_kemaskini', 
    ];

    protected $table = 'ref_bencana_negeri';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
