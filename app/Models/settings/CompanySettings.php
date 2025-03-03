<?php

namespace App\Models\settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanySettings extends Model
{
 
    use HasFactory;
    protected $table = 'org_company';
    protected $primaryKey = 'company_id';
    public $incrementing = true;
    protected $fillable = [
        'company_name',
        'short_name',
        'address_line1',
        'address_line2',
        'city',
        'province',
        'postal_code',
        'country',
        'tel_num',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at'
    ];
}
