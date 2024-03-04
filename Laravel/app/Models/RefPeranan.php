<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefPeranan extends Model
{
    use HasFactory;
    protected $fillable = [
        'peranan', 'status_peranan'
    ];

    protected $table = 'ref_peranan';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
