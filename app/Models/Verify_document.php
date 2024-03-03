<?php

namespace App\Models;

use Eloquent as Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Verify_document
 * @package App\Models
 * @version May 4, 2020, 12:39 pm WIB
 *
 * @property string $serial_number
 * @property string $perihal
 * @property string $nim
 * @property integer $created_by
 */
class Verify_document extends Model
{
    use LogsActivity;

    public $table = 'verify_documents';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'serial_number',
        'perihal',
        'nim',
        'created_by'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'serial_number' => 'string',
        'perihal' => 'string',
        'nim' => 'string',
        'created_by' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'serial_number' => 'required',
        'perihal' => 'required',
        'nim' => 'required',
        'created_by' => 'required'
    ];

    
}
