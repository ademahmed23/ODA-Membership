<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class City10 extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $table = 'city10s';
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'age',
        'address',
        'contact_number',
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
            ->useLogName("City10");
    }
}
