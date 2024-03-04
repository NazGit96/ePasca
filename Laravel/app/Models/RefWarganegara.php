<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefWarganegara extends Model
{
    use HasFactory;
    protected $fillable = [
        'kod_warganegara', 'nama_warganegara', 'status_warganegara', 
    ];

    protected $table = 'ref_warganegara';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
