<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class connect_model extends Model
{
    use HasFactory;
    protected $table = 'connect';
    protected $primaryKey = 'connect_id';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'email',
        'purpose',
        'message',
        'is_read'
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->created_at = now();
        });
    }
}
