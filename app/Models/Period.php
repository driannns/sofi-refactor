<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Period
 * @package App\Models
 * @version April 4, 2020, 10:13 am UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection clos
 * @property \Illuminate\Database\Eloquent\Collection sidangs
 * @property string start_date
 * @property string end_date
 * @property string description
 * @property string|\Carbon\Carbon created_at
 * @property string|\Carbon\Carbon updated_at
 */
class Period extends Model
{
    use LogsActivity;
    // use SoftDeletes;

    public $table = 'periods';

    public $timestamps = true;


    // protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'start_date',
        'end_date',
        'description',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'start_date' => 'date',
        'end_date' => 'date',
        'description' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
      'name' => 'required',
      'start_date' => 'required',
      'end_date' => 'required',
      'description' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function clos()
    {
        return $this->hasMany(\App\Models\Clo::class, 'period_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function sidangs()
    {
        return $this->hasMany(\App\Models\Sidang::class, 'period_id');
    }

    public static function getPeriodNow()
    {
        $nowDate = date('Y-m-d');
        return Period::where([
            ['start_date','<=',$nowDate],
            ['end_date','>=',$nowDate]
        ])->pluck('name','id');
    }

    public static function getPeriodNowId()
    {
        $nowDate = date('Y-m-d');
        return Period::where([
            ['start_date','<=',$nowDate],
            ['end_date','>=',$nowDate]
        ])->pluck('id');
    }

    public static function getAllPeriod()
    {
      return Period::all()->pluck('name','id')->toArray();
    }

    public static function isPeriodSame($tgl_awal,$tgl_akhir)
    {
        $data = Period::where([
           ['start_date','=',$tgl_awal],
           ['end_date','=',$tgl_akhir]
        ])->get();
        if(count($data)==0)
            return false;
        else
            return true;
    }

    public static function isPeriodSameDescription($nama)
    {
        $data = Period::where([
            ['name','=',$nama]
        ])->get();
        if(count($data)==0)
            return false;
        else
            return true;
    }
}
