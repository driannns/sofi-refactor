<?php

namespace App\Models;

use Eloquent as Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class StudyProgram
 * @package App\Models
 * @version February 2, 2022, 8:46 am WIB
 *
 * @property string $name
 */
class StudyProgram extends Model
{
    use LogsActivity;

    public $table = 'study_programs';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
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
        'name' => 'required|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public static function getAllProdi()
    {
        return StudyProgram::all()->pluck('name','id');
    }
}
