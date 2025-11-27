<?php

namespace App\Models\Organization;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class ShawaakLixaa extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $table = 'sh_k_lixaa';
    protected $fillable = [
        'member_id',
        'organization_name',
        'organization_type',
        'woreda',
        'phone_number',
        'email',
        'payment_period',
        'member_started',
        'paymemt',
        
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
            ->useLogName("sh_k_lixaa");
    }
}
