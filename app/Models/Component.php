<?php

namespace App\Models;

use Eloquent as Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Component
 * @package App\Models
 * @version April 17, 2020, 12:08 am WIB
 *
 * @property \App\Models\Clo clo
 * @property \Illuminate\Database\Eloquent\Collection intervals
 * @property \Illuminate\Database\Eloquent\Collection scores
 * @property string code
 * @property string description
 * @property number percentage
 * @property string unsur_penilaian
 * @property boolean pembimbing
 * @property boolean penguji
 * @property integer clo_id
 */
class Component extends Model
{

    use LogsActivity;
    public $table = 'components';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public $timestamps = false;

    public $fillable = [
        'code',
        'description',
        'percentage',
        'unsur_penilaian',
        'pembimbing',
        'penguji',
        'clo_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'code' => 'string',
        'description' => 'string',
        'percentage' => 'float',
        'unsur_penilaian' => 'string',
        'pembimbing' => 'boolean',
        'penguji' => 'boolean',
        'clo_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'clo_id' => 'required',
        'code' => 'required',
        'description' => 'required',
        'percentage' => 'required',
        'unsur_penilaian' => 'required',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function clo()
    {
        return $this->belongsTo(\App\Models\CLO::class, 'clo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function intervals()
    {
        return $this->hasMany(\App\Models\Interval::class, 'component_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function scores()
    {
        return $this->hasMany(\App\Models\Score::class, 'component_id');
    }
}
