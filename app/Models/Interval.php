<?php

namespace App\Models;

use Eloquent as Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Interval
 * @package App\Models
 * @version April 17, 2020, 12:08 am WIB
 *
 * @property \App\Models\Component component
 * @property integer value
 * @property integer ekuivalensi
 * @property string unsur_penilaian
 * @property integer component_id
 */
class Interval extends Model
{

    use LogsActivity;
    public $table = 'intervals';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public $timestamps = false;

    public $fillable = [
        'value',
        'ekuivalensi',
        'unsur_penilaian',
        'component_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'value' => 'integer',
        'ekuivalensi' => 'double',
        'unsur_penilaian' => 'string',
        'component_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'component_id' => 'required',
        'value' => 'required',
        'ekuivalensi' => 'required',
        'unsur_penilaian' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function component()
    {
        return $this->belongsTo(\App\Models\Component::class, 'component_id');
    }
}
