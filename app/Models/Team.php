<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Team
 * @package App\Models
 * @version April 3, 2020, 4:13 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property string name
 */
class Team extends Model
{
    use LogsActivity;

    public $table = 'teams';

    public $timestamps = false;


    protected $dates = ['deleted_at'];

    public $incrementing = true;

    public $fillable = [
        'id',
        'name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
      'name' => 'unique:teams|required'
      ,[
        'unique' => 'Minimal ada satu deskirpsi revisi sebelum disubmit atau upload dokumen',
      ],
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function users()
    {
        return $this->belongsToMany(\App\Models\User::class, 'students');
    }

    public function isIndividu($nim)
    {
        $individu = false;
        $team = Team::where('name', $nim." Sidang Individu")->get();
        if ($team != "[]") {
          $individu = true;
        }
        return $individu;
    }
}
