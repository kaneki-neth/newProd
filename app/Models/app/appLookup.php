<?php

namespace App\Models\app;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class appLookup extends Model
{
    use HasFactory;
    protected $table = 'app_lookup';
    protected $primaryKey = 'lookup_code';
    public $incrementing = false;
}
