<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Student
 * @package App\Models
 * @version April 3, 2020, 4:14 pm UTC
 *
 * @property \App\Models\Team team
 * @property \App\Models\User user
 * @property \Illuminate\Database\Eloquent\Collection sidangs
 * @property string status
 * @property string tak
 * @property string eprt
 * @property string studentscol
 * @property integer user_id
 * @property integer team_id
 */
class Student extends Model
{
    use LogsActivity;
    public $table = 'students';

    public $timestamps = false;

    protected $dates = ['deleted_at'];

    protected $primaryKey = 'nim';

    public $guarded = [
        'id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'nim' => 'integer',
        'status' => 'string',
        'tak' => 'string',
        'eprt' => 'string',
        'studentscol' => 'string',
        'user_id' => 'integer',
        'team_id' => 'integer'
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
    public function team()
    {
        return $this->belongsTo(\App\Models\Team::class, 'team_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\User::class, 'user_id');
    }

    public function peminatan()
    {
        return $this->belongsTo(\App\Models\Peminatan::class, 'peminatan_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function sidangs()
    {
        return $this->hasMany(\App\Models\Sidang::class, 'mahasiswa_id', 'nim');
    }
}
