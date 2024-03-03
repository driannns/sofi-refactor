<?php

namespace App\Models;

use Eloquent as Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Revision
 * @package App\Models
 * @version April 24, 2020, 5:02 pm WIB
 *
 * @property \App\Models\DokumenLog dokumen
 * @property \App\Models\Schedule schedule
 * @property integer schedule_id
 * @property string deskripsi
 * @property string hal
 * @property string status
 * @property integer dokumen_id
 * @property integer dokumen_mhs
 */
class Revision extends Model
{

    use LogsActivity;
    public $table = 'revisions';

    public $timestamps = false;

    public $fillable = [
        'schedule_id',
        'deskripsi',
        'hal',
        'status',
        'dokumen_id',
        'lecturer_id',
        'dokumen_mhs',
        'feedback'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'schedule_id' => 'integer',
        'deskripsi' => 'string',
        'hal' => 'string',
        'status' => 'string',
        'dokumen_id' => 'integer',
        'dokumen_mhs' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'schedule_id' => 'required',
        'deskripsi' => 'required',
        'hal' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function dokumen()
    {
        return $this->belongsTo(\App\Models\DokumenLog::class, 'dokumen_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function dokumen_mahasiswa()
    {
        // return $this->join('document_logs','document_logs.id','=', 'dokumen_mhs');
        return $this->belongsTo(\App\Models\DokumenLog::class, 'dokumen_mhs');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function schedule()
    {
        return $this->belongsTo(\App\Models\Schedule::class, 'schedule_id');
    }

    public function lecturer()
    {
        return $this->belongsTo(\App\Models\Lecturer::class, 'lecturer_id');
    }

    public function revision_logs()
    {
        return $this->hasMany(\App\Models\RevisionLog::class, 'revision_id');
    }

    public function isPenguji1()
    {
        if ($this->lecturer_id == $this->schedule->penguji1) {
          return true;
        }else{
          return false;
        }
    }

    public function isPenguji2()
    {
        if ($this->lecturer_id == $this->schedule->penguji2) {
          return true;
        }else{
          return false;
        }
    }

    public function isPembimbing1()
    {
        if ($this->lecturer_id == $this->schedule->sidang->pembimbing1_id) {
          return true;
        }else{
          return false;
        }
    }

    public function isPembimbing2()
    {
        if ($this->lecturer_id == $this->schedule->sidang->pembimbing2_id) {
          return true;
        }else{
          return false;
        }
    }
}
