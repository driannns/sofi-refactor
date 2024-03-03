<?php

namespace App\Models;

use Eloquent as Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class CLO
 * @package App\Models
 * @version April 17, 2020, 12:07 am WIB
 *
 * @property \App\Models\Period period
 * @property \Illuminate\Database\Eloquent\Collection components
 * @property string code
 * @property number precentage
 * @property string description
 * @property integer period_id
 */
class CLO extends Model
{
    use LogsActivity;

    public $table = 'clos';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'code',
        'precentage',
        'description',
        'period_id',
        'study_program_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'code' => 'string',
        'precentage' => 'float',
        'description' => 'string',
        'period_id' => 'integer',
        'study_program_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'period_id' => 'required',
        'code' => 'required',
        'description' => 'required',
        'precentage' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function period()
    {
        return $this->belongsTo(\App\Models\Period::class, 'period_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function components()
    {
        return $this->hasMany(\App\Models\Component::class, 'clo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function study_program()
    {
        return $this->belongsTo(\App\Models\StudyProgram::class, 'study_program_id');
    }
}
