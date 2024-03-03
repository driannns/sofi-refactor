<?php

namespace App\Models;

use Eloquent as Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class ScorePortion
 * @package App\Models
 * @version May 6, 2023, 4:50 pm WIB
 *
 * @property \App\Models\Period $period
 * @property \App\Models\StudyProgram $studyProgram
 * @property integer $period_id
 * @property integer $study_program_id
 * @property number $pembimbing
 * @property number $penguji
 */
class ScorePortion extends Model
{

    use LogsActivity;
    public $table = 'score_portions';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'period_id',
        'study_program_id',
        'pembimbing',
        'penguji'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'period_id' => 'integer',
        'study_program_id' => 'integer',
        'pembimbing' => 'float',
        'penguji' => 'float'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'period_id' => 'required|integer',
        'study_program_id' => 'required',
        'pembimbing' => 'required|numeric',
        'penguji' => 'required|numeric',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function period()
    {
        return $this->belongsTo(\App\Models\Period::class, 'period_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function studyProgram()
    {
        return $this->belongsTo(\App\Models\StudyProgram::class, 'study_program_id');
    }
}
