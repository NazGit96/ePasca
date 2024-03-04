<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefNegeri extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_negeri', 'kod_negeri', 'status_negeri', 
    ];

    protected $table = 'ref_negeri';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
