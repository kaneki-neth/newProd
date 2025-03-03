<?php

namespace App\Models\settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessUnit extends Model
{
    use HasFactory;
    protected $table = 'org_business_units';
    protected $primaryKey = 'bu_id';
    public $incrementing = true;
    protected $fillable = [
        'bu_code',
        'bu_name',
        'address_line1',
        'address_line2',
        'city',
        'province',
        'postal_code',
        'country',
        'tel_num',
        'enabled',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at'
    ];
}
