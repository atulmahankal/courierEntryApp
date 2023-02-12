<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class courier extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'date',
        'direction',    //dropdown [inward,outward]
        'type',
        'party',
        'courier_name',
        'courier_contact',
        'person_name',
        'person_contact',
        'remarks',
        'status',
    ];
}