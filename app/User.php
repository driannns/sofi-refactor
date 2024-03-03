<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;

use App\Models\Attendance;
use App\Models\Score;
use App\Models\Schedule;
use Auth;

class User extends Authenticatable
{
    use Notifiable;
    use LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama', 'username', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function attendances()
    {
        return $this->hasMany(\App\Models\Attendance::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function student()
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

    public function lecturer()
    {
        return $this->hasOne(\App\Models\Lecturer::class, 'user_id');
    }

    public function isAdmin()
    {
        foreach ($this->roles as $role) {
          if ($role->role_code == 'RLADM')
              return true;
        }

        return false;
    }

    public function isSuperadmin()
    {
        foreach ($this->roles as $role) {
          if ($role->role_code == 'RLSPR')
              return true;
        }

        return false;
    }

    public function isPpm()
    {
        foreach ($this->roles as $role) {
            if ($role->role_code == 'RLPPM')
                return true;
        }
        return false;
    }

    public function isPembimbing()
    {
        foreach ($this->roles as $role) {
            if ($role->role_code == 'RLPBB')
                return true;
        }
        return false;
    }

    public function isPenguji()
    {
        foreach ($this->roles as $role) {
            if ($role->role_code == 'RLPGJ')
                return true;
        }
        return false;
    }

    public function isPIC()
    {
        foreach ($this->roles as $role) {
            if ($role->role_code == 'RLPIC')
                return true;
        }
        return false;
    }

    public function isStudent()
    {
        foreach ($this->roles as $role) {
            if ($role->role_code == 'RLMHS')
                return true;
        }
        return false;
    }

    public function isDosen()
    {
        foreach ($this->roles as $role) {
            if ($role->role_code == 'RLDSN')
                return true;
        }
        return false;
    }

    public function hasRole($search_role)
    {
        foreach ($this->roles as $role) {
            if ($role->role_code == $search_role)
                return true;
        }

        return false;
    }

    public function isHadirSidang($schedule_id)
    {
      $kehadiran = Attendance::where('user_id', Auth::user()->id)
      ->where('schedule_id', $schedule_id)
      ->first();
      if ($kehadiran == null) {
        return false;
      }else{
        return true;
      }
    }

    public function isNilaiSidang($schedule_id)
    {
      if (!$this->isStudent() AND !$this->isAdmin()) {
        $nilaiSidang = Score::where('user_id', Auth::user()->lecturer->id)
        ->where('jadwal_id', $schedule_id)
        ->first();
        if ($nilaiSidang == null) {
          return false;
        }else{
          return true;
        }
      }else{
        return false;
      }

    }

    public function isPenguji1($id)
    {
        $schedule = Schedule::find($id);
        if ($schedule->penguji1 == $this->lecturer->id) {
          return true;
        }else{
          return false;
        }
    }

    public function isPenguji2($id)
    {
        $schedule = Schedule::find($id);
        if ($schedule->penguji2 == $this->lecturer->id) {
          return true;
        }else{
          return false;
        }
    }

    public function isPembimbing1($id)
    {
        $schedule = Schedule::find($id);
        if ($schedule->sidang->pembimbing1_id == $this->lecturer->id) {
          return true;
        }else{
          return false;
        }
    }

    public function isPembimbing2($id)
    {
        $schedule = Schedule::find($id);
        if ($schedule->sidang->pembimbing1_id == $this->lecturer->id) {
          return true;
        }else{
          return false;
        }
    }

}
