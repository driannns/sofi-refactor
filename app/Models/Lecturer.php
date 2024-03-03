<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Lecturer
 * @package App\Models
 * @version April 4, 2020, 5:34 am UTC
 *
 * @property \App\Models\User user
 * @property \Illuminate\Database\Eloquent\Collection schedules
 * @property \Illuminate\Database\Eloquent\Collection schedule1s
 * @property \Illuminate\Database\Eloquent\Collection sidangs
 * @property \Illuminate\Database\Eloquent\Collection sidang2s
 * @property string nip
 * @property string code
 * @property string jfa
 * @property string kk
 * @property integer user_id
 */
class Lecturer extends Model
{
    use LogsActivity;

    public $table = 'lecturers';

    public $timestamps = false;


    protected $dates = ['deleted_at'];



    public $fillable = [
        'nip',
        'code',
        'jfa',
        'kk',
        'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'nip' => 'string',
        'code' => 'string',
        'jfa' => 'string',
        'kk' => 'string',
        'user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function schedules()
    {
        return $this->hasMany(\App\Models\Schedule::class, 'penguji1');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function schedule1s()
    {
        return $this->hasMany(\App\Models\Schedule::class, 'penguji2');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function sidangs()
    {
        return $this->hasMany(\App\Models\Sidang::class, 'pembimbing1_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function sidang2s()
    {
        return $this->hasMany(\App\Models\Sidang::class, 'pembimbing2_id');
    }

    public function revisions()
    {
        return $this->hasMany(\App\Models\Revision::class, 'lecturer_id');
    }
}
