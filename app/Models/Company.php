<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;

    protected $table="companies";
    public static $Type = "companies";

    const CREATED_AT = 'dateCreated';
    const UPDATED_AT = 'dateUpdated';
    const DELETED_AT = 'dateDeleted';

    protected $fillable = [
        'name',
        'email',
        'logo',
        'website'
    ];

    public function employees()
    {
        return $this->hasMany('App\Models\Employee');
    }
}
