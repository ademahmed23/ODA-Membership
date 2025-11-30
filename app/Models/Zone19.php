<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class Zone19 extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $table = 'zone19s';
    protected $fillable = [
         'member_id',
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'age',
        'education_level',
        'address',
        'contact_number',
        'woreda',
        'email',
        'position',
        'membership_type',
        'membership_fee',
    ];

    protected static $logAttributes = ['*'];

    protected static $logOnlyDirty = true;

    public function getDescriptionForEvent(string $eventName): string
    {
        //$user = Auth::user()->name;
        //return "{$user} has {$eventName} user {$this->name}";

        return "user has {$eventName} user {$this->name}";
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->useLogName("Zone19");
    }
}
