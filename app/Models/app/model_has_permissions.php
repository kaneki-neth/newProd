<?php

namespace App\Models\app;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class model_has_permissions extends Model
{
    use HasFactory;
    protected $table = 'model_has_permissions';
    protected $primaryKey = 'permission_id';
}
