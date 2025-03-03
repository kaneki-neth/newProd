<?php

namespace App\Models\app;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class org_user_bu extends Model
{
    use HasFactory;
    protected $table = 'org_user_bu';
    protected $fillable = [
        'user_id', 
        'bu_id',
    ];
}
