<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class User
 * @package App\Models
 * @version April 4, 2020, 5:31 am UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection attendances
 * @property \Illuminate\Database\Eloquent\Collection lecturers
 * @property \Illuminate\Database\Eloquent\Collection students
 * @property \Illuminate\Database\Eloquent\Collection roles
 * @property string username
 * @property string nama
 * @property string password
 * @property string|\Carbon\Carbon email_verified_at
 * @property string|\Carbon\Carbon created_at
 * @property string|\Carbon\Carbon updated_at
 */
class User extends Model
{

    use LogsActivity;
    public $table = 'users';

    public $timestamps = true;


    protected $dates = ['deleted_at'];



    public $fillable = [
        'username',
        'nama',
        'password',
        'email_verified_at',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'username' => 'string',
        'nama' => 'string',
        'password' => 'string',
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'username' => 'unique:users|required|min:3',
        'nama' => 'required',
        'password' => 'min:8'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function attendances()
    {
        return $this->hasMany(\App\Models\Attendance::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function lecturers()
    {
        return $this->hasOne(\App\Models\Lecturer::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function students()
    {
        return $this->hasOne(\App\Models\Student::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function roles()
    {
        return $this->belongsToMany(\App\Models\Role::class, 'user_has_role');
    }

    public static function getAdmin()
    {
        return User::whereHas('roles', function($q){
            $q->where('role_code', 'RLADM');
        })->get();
    }

    public function isPenguji1($id)
    {
        $schedule = Schedule::find($id);
        if ($schedule->penguji1 == $this->lecturers->id) {
          return true;
        }else{
          return false;
        }
    }

    public function isPenguji2($id)
    {
        $schedule = Schedule::find($id);
        if ($schedule->penguji2 == $this->lecturers->id) {
          return true;
        }else{
          return false;
        }
    }

    public function isPembimbing1($id)
    {
        $schedule = Schedule::find($id);
        if ($schedule->sidang->pembimbing1_id == $this->lecturers->id) {
          return true;
        }else{
          return false;
        }
    }

    public function isPembimbing2($id)
    {
        $schedule = Schedule::find($id);
        if ($schedule->sidang->pembimbing1_id == $this->lecturers->id) {
          return true;
        }else{
          return false;
        }
    }

    public function isAdmin()
    {
        $admin = false;
        foreach ($this->roles as $role) {
            $admin = ( $role->role_code == 'RLADM' ? true : false );
        }

        return $admin;
    }
}
