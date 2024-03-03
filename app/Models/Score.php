<?php

namespace App\Models;

use Eloquent as Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Score
 * @package App\Models
 * @version April 17, 2020, 12:05 am WIB
 *
 * @property \App\Models\Schedule jadwal
 * @property \App\Models\Component component
 * @property number value
 * @property number percentage
 * @property integer component_id
 * @property integer jadwal_id
 */
class Score extends Model
{

    use LogsActivity;
    public $table = 'scores';

    public $timestamps = false;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public $fillable = [
        'value',
        'percentage',
        'component_id',
        'jadwal_id',
        'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'value' => 'float',
        'percentage' => 'float',
        'component_id' => 'integer',
        'jadwal_id' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'component_id' => 'required',
        'jadwal_id' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function jadwal()
    {
        return $this->belongsTo(\App\Models\Schedule::class, 'jadwal_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function component()
    {
        return $this->belongsTo(\App\Models\Component::class, 'component_id');
    }

    public function isPenguji1()
    {
        if ($this->user_id == $this->jadwal->penguji1) {
          return true;
        }else{
          return false;
        }
    }

    public function isPenguji2()
    {
        if ($this->user_id == $this->jadwal->penguji2) {
          return true;
        }else{
          return false;
        }
    }

    public function isPembimbing1()
    {
        if ($this->user_id == $this->jadwal->sidang->pembimbing1_id) {
          return true;
        }else{
          return false;
        }
    }

    public function isPembimbing2()
    {
        if ($this->user_id == $this->jadwal->sidang->pembimbing2_id) {
          return true;
        }else{
          return false;
        }
    }

}
