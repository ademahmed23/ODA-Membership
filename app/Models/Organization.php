<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Organization extends Model
{
    protected $table = 'organizations';

    protected $fillable = [
        'organization_name',
        'address',
        'phone',
        'email',
        'website',
        'contact_person',
        'payment_details',


    ];
}




