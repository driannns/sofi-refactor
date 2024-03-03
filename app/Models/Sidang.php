<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Sidang
 * @package App\Models
 * @version April 4, 2020, 8:51 am UTC
 *
 * @property \App\Models\Student mahasiswa
 * @property \App\Models\Lecturer pembimbing1
 * @property \App\Models\Lecturer pembimbing2
 * @property \App\Models\Period period
 * @property \Illuminate\Database\Eloquent\Collection dokumenLogs
 * @property \Illuminate\Database\Eloquent\Collection schedules
 * @property \Illuminate\Database\Eloquent\Collection statusLogs
 * @property integer mahasiswa_id
 * @property integer pembimbing1_id
 * @property integer pembimbing2_id
 * @property string judul
 * @property string form_bimbingan
 * @property string eprt
 * @property string dokumen_ta
 * @property string makalah
 * @property string tak
 * @property string status
 * @property string|\Carbon\Carbon created_at
 * @property string|\Carbon\Carbon updated_at
 * @property boolean is_english
 * @property integer period_id
 */
class Sidang extends Model
{
    use LogsActivity;
    // use SoftDeletes;

    public $table = 'sidangs';

    public $timestamps = true;

    protected $dates = ['deleted_at'];



    public $fillable = [
        'mahasiswa_id',
        'pembimbing1_id',
        'pembimbing2_id',
        'judul',
        'form_bimbingan',
        'eprt',
        'dokumen_ta',
        'makalah',
        'tak',
        'status',
        'created_at',
        'updated_at',
        'is_english',
        'period_id',
        'status_pembimbing1',
        'status_pembimbing2',
        'credit_complete',
        'credit_uncomplete',
        'sk_penguji_file',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'mahasiswa_id' => 'integer',
        'pembimbing1_id' => 'integer',
        'pembimbing2_id' => 'integer',
        'judul' => 'string',
        'form_bimbingan' => 'string',
        'eprt' => 'string',
        'dokumen_ta' => 'string',
        'makalah' => 'string',
        'tak' => 'string',
        'status' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'is_english' => 'boolean',
        'period_id' => 'integer',
        'status_pembimbing1' => 'string',
        'status_pembimbing2' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'mahasiswa_id' => 'required',
        'pembimbing1_id' => 'required',
        'pembimbing2_id' => 'required',
        'period_id' => 'required',
        'judul' => 'required',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function mahasiswa()
    {
        return $this->belongsTo(\App\Models\Student::class, 'mahasiswa_id', 'nim');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function pembimbing1()
    {
        return $this->belongsTo(\App\Models\Lecturer::class, 'pembimbing1_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function pembimbing2()
    {
        return $this->belongsTo(\App\Models\Lecturer::class, 'pembimbing2_id');
    }

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
    public function dokumenLogs()
    {
        return $this->hasMany(\App\Models\DokumenLog::class, 'sidang_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function schedules()
    {
        return $this->hasMany(\App\Models\Schedule::class, 'sidang_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function statusLogs()
    {
        return $this->hasMany(\App\Models\StatusLog::class, 'sidangs_id');
    }

    public static function isExist($id)
    {
        return Sidang::where('mahasiswa_id','=',$id)->orderBy('created_at','desc')->first();
    }

    public function pembimbingBelumSetuju()
    {
        $user_id = Auth::user()->id;
        if($this->pembimbing1->user_id == $user_id)
        {
            return ($this->status == 'disetujui oleh pembimbing2' || $this->status == 'pengajuan') ? true:false;
        }

        return ($this->status == 'disetujui oleh pembimbing1' || $this->status == 'pengajuan') ? true:false;
    }

    public function isSudahDijadwalkan($nim)
    {
      $isSudah = true;
      $sidang = Sidang::where('mahasiswa_id', $nim)->latest('created_at')->first();
        if ($sidang->status == "belum dijadwalkan" || $sidang->status == "tidak lulus (belum dijadwalkan)" || $sidang->status == "telah disetujui admin") {
          $isSudah = false;
        }

      return $isSudah;
    }
}
