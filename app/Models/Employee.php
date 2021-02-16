<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;

    protected $table="employees";
    public static $Type = "employees";

    const CREATED_AT = 'dateCreated';
    const UPDATED_AT = 'dateUpdated';
    const DELETED_AT = 'dateDeleted';

    protected $fillable = [
        'company_id',
        'firstName',
        'lastName',
        'email',
        'phone'
    ];

    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }
}
