<?php

namespace App\Models;

use Eloquent as Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Peminatan
 * @package App\Models
 * @version April 27, 2020, 3:58 am WIB
 *
 * @property string nama
 * @property string kk
 */
class Peminatan extends Model
{
    use LogsActivity;

    public $table = 'peminatans';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public $fillable = [
        'nama',
        'kk'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'nama' => 'string',
        'kk' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'nama' => 'required',
        'kk' => 'required'
    ];

    public function peminatan()
    {
        return $this->hasOne(\App\Models\Student::class, 'peminatan_id');
    }

}
