<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class Project extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $table = 'projects';
    protected $fillable = [
        'name',
        'zone',
        'woreda_or_city',
        'type',
        'site',
        'numbers',
        'started_year',
        'address',
        'progression',
        'budget',
        'community_participation',
        'deployed_budget',
        'total_budget',
        'benefitiary',
        'how_many_get_job'
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
            ->useLogName("Zone2");
    }
}
