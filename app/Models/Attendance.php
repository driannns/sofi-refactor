<?php

namespace App\Models;

use Eloquent as Model;
use Spatie\Activitylog\Traits\LogsActivity;
/**
 * Class Attendance
 * @package App\Models
 * @version April 16, 2020, 12:34 am WIB
 *
 * @property \App\Models\Schedule schedule
 * @property \App\Models\User user
 * @property integer schedule_id
 * @property integer user_id
 * @property string role_sidang
 */
class Attendance extends Model
{
    use LogsActivity;
    public $table = 'attendances';
    public $timestamps = false;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public $fillable = [
        'schedule_id',
        'user_id',
        'role_sidang'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'schedule_id' => 'integer',
        'user_id' => 'integer',
        'role_sidang' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'schedule_id' => 'required',
        'user_id' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function schedule()
    {
        return $this->belongsTo(\App\Models\Schedule::class, 'schedule_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function users()
    {
        return $this->belongsTo(\App\User::class, 'user_id');
    }

    public static function hadir($schedule_id,$user_id,$role)
    {
      return Attendance::firstOrCreate([
        'user_id' => $user_id,
        'schedule_id' => $schedule_id,
        'role_sidang' => $role
      ]);
    }

}
