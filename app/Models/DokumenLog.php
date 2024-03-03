<?php

namespace App\Models;

use Eloquent as Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class DokumenLog
 * @package App\Models
 * @version April 4, 2020, 12:55 pm UTC
 *
 * @property \App\Models\Sidang sidang
 * @property \Illuminate\Database\Eloquent\Collection revisions
 * @property integer sidang_id
 * @property string nama
 * @property string jenis
 * @property string file_url
 * @property integer created_by
 */
class DokumenLog extends Model
{

    use LogsActivity;
    public $table = 'dokumen_logs';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /*
    jenis = draft, makalah, revisi
    */


    public $fillable = [
        'sidang_id',
        'nama',
        'jenis',
        'file_url',
        'created_by'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'sidang_id' => 'integer',
        'nama' => 'string',
        'jenis' => 'string',
        'file_url' => 'string',
        'created_by' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'sidang_id' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function sidang()
    {
        return $this->belongsTo(\App\Models\Sidang::class, 'sidang_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function revisions()
    {
        return $this->hasMany(\App\Models\Revision::class, 'dokumen_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function revisions_mahasiswa()
    {
        return $this->hasMany(\App\Models\Revision::class, 'dokumen_mhs');
    }

    public function scopeOfSidang($query, $sidang)
    {
        return $query->where('sidang_id', $sidang)->where('jenis','draft');
    }
}
