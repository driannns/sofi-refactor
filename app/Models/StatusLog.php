<?php

namespace App\Models;

use Eloquent as Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class StatusLog
 * @package App\Models
 * @version April 6, 2020, 11:30 am WIB
 *
 * @property \App\Models\Sidang sidangs
 * @property string feedback
 * @property integer created_by
 * @property integer sidangs_id
 * @property string workflow_type
 * @property string name
 */
class StatusLog extends Model
{
    use LogsActivity;

    public $table = 'status_logs';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public $fillable = [
        'feedback',
        'created_by',
        'sidangs_id',
        'workflow_type',
        'name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'feedback' => 'string',
        'created_by' => 'integer',
        'sidangs_id' => 'integer',
        'workflow_type' => 'string',
        'name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'sidangs_id' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function sidangs()
    {
        return $this->belongsTo(\App\Models\Sidang::class, 'sidangs_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }
}
