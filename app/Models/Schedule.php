<?php

namespace App\Models;

use Eloquent as Model;
use Carbon\Carbon;
use Log;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Schedule
 * @package App\Models
 * @version April 10, 2020, 3:53 pm WIB
 *
 * @property \App\Models\Lecturer penguji1
 * @property \App\Models\Lecturer penguji2
 * @property \App\Models\Sidang sidang
 * @property \Illuminate\Database\Eloquent\Collection attendances
 * @property \Illuminate\Database\Eloquent\Collection revisions
 * @property \Illuminate\Database\Eloquent\Collection scores
 * @property integer sidang_id
 * @property string date
 * @property time time
 * @property string ruang
 * @property integer penguji1
 * @property integer penguji2
 * @property string presentasi_file
 * @property string status
 * @property string keputusan
 */
class Schedule extends Model
{

    use LogsActivity;
    public $table = 'schedules';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public $fillable = [
        'sidang_id',
        'date',
        'time',
        'ruang',
        'penguji1',
        'penguji2',
        'presentasi_file',
        'status',
        'keputusan',
        'durasi_revisi',
        'flag_add_revision',
        'flag_change_scores'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'sidang_id' => 'integer',
        'date' => 'date',
        'ruang' => 'string',
        'penguji1' => 'integer',
        'penguji2' => 'integer',
        'presentasi_file' => 'string',
        'status' => 'string',
        'keputusan' => 'string',
        'durasi_revisi' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'penguji1' => 'required',
        'penguji2' => 'required',
        'date' => 'required',
        'time' => 'required',
        'ruang' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function detailpenguji1()
    {
        return $this->belongsTo(\App\Models\Lecturer::class, 'penguji1');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function detailpenguji2()
    {
        return $this->belongsTo(\App\Models\Lecturer::class, 'penguji2');
    }

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
    public function attendances()
    {
        return $this->hasMany(\App\Models\Attendance::class, 'schedule_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function revisions()
    {
        return $this->hasMany(\App\Models\Revision::class, 'schedule_id')
            ->orderByRaw("FIELD(status,'sudah dikirim','sedang dikerjakan','disetujui') ASC");
    }

    public function revisions_penguji1()
    {
        return $this->hasMany(\App\Models\Revision::class, 'schedule_id')
            ->where('lecturer_id',$this->penguji1);
    }

    public function revisions_penguji2()
    {
        return $this->hasMany(\App\Models\Revision::class, 'schedule_id')
            ->where('lecturer_id',$this->penguji2);
    }

    public function revisions_pembimbing1()
    {
        return $this->hasMany(\App\Models\Revision::class, 'schedule_id')
            ->where('lecturer_id',$this->sidang->pembimbing1_id);
    }
    public function revisions_pembimbing2()
    {
        return $this->hasMany(\App\Models\Revision::class, 'schedule_id')
            ->where('lecturer_id',$this->sidang->pembimbing2_id);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function scores()
    {
        return $this->hasMany(\App\Models\Score::class, 'jadwal_id');
    }

    public function masalah()
    {
        $errors = [];
        $errors = array_merge($errors, $this->scoreBermasalah());
        $errors = array_merge($errors, $this->pelaksanaanBermasalah());
        $errors = array_merge($errors, $this->revisiBermasalah());

        return $errors;
    }

    private function scoreBermasalah()
    {
        $errors = [];
        $scorePenguji1 = $this->scores->where('user_id', '=', $this->penguji1);
        $scorePenguji2 = $this->scores->where('user_id', '=', $this->penguji2);
        $scorePembimbing1 = $this->scores->where('user_id', '=', $this->sidang->pembimbing1_id);
        $scorePembimbing2 = $this->scores->where('user_id', '=', $this->sidang->pembimbing2_id);

        if (count($scorePenguji1) == 0)
            $errors[] = 'Penguji 1 belum memberikan nilai';
        if (count($scorePenguji2) == 0)
            $errors[] = 'Penguji 2 belum memberikan nilai';
        if (count($scorePembimbing1) == 0)
            $errors[] = 'Pembimbing 1 belum memberikan nilai';
        if (count($scorePembimbing2) == 0)
            $errors[] = 'Pembimbing 2 belum memberikan nilai';

        return $errors;
    }

    private function pelaksanaanBermasalah()
    {
        $errors = [];

        if ($this->keputusan == null)
            $errors[] = 'Penguji 1 belum melakukan simpulan nilai';
        if ($this->status == 'sedang dilaksanakan' and $this->keputusan != null)
            $errors[] = 'Penguji 1 belum cetak BAP';

        return $errors;
    }

    private function revisiBermasalah()
    {
        $errors = [];

        if ($this->durasi_revisi == null)
            $durasi = 14;
        else
            $durasi = (int) $this->durasi_revisi;

        $warningToDeadline = Carbon::parse($this->date)->addDays($durasi - 2) <= now();

        $isLate = false;
        $currentDateTime = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d', strtotime($this->date)) . " " . $this->time);
        if (Carbon::now() > ($currentDateTime->add(1, 'day'))) {
            $isLate = true;
        }

        if ($isLate and $this->keputusan == 'lulus bersyarat') {
            if ($this->revisions->count() == 0)
                $errors[] = 'Keputusan lulus bersyarat tetapi Penguji belum menambahkan revisi.';
        }

        if ($warningToDeadline) {

            $countRevisiNotCompleteByPenguji1 = $this->revisions->whereIn('status', ['sudah dikirim'])
                ->where('lecturer_id', '=', $this->penguji1)->count();
            $countRevisiNotCompleteByPenguji2 = $this->revisions->whereIn('status', ['sudah dikirim'])
                ->where('lecturer_id', '=', $this->penguji2)->count();
            $countRevisiNotCompleteByPembimbing1 = $this->revisions->whereIn('status', ['sudah dikirim'])
                ->where('lecturer_id', '=', $this->sidang->pembimbing1_id)->count();
            $countRevisiNotCompleteByPembimbing2 = $this->revisions->whereIn('status', ['sudah dikirim'])
                ->where('lecturer_id', '=', $this->sidang->pembimbing2_id)->count();
            $countRevisiPenguji1NotCompleteByMahasiswa = $this->revisions->whereIn('status', ['sedang dikerjakan'])
                ->where('lecturer_id', '=', $this->penguji1)->count();
            $countRevisiPenguji2NotCompleteByMahasiswa = $this->revisions->whereIn('status', ['sedang dikerjakan'])
                ->where('lecturer_id', '=', $this->penguji2)->count();
            $countRevisiPembimbing1NotCompleteByMahasiswa = $this->revisions->whereIn('status', ['sedang dikerjakan'])
                ->where('lecturer_id', '=', $this->sidang->pembimbing1_id)->count();
            $countRevisiPembimbing2NotCompleteByMahasiswa = $this->revisions->whereIn('status', ['sedang dikerjakan'])
                ->where('lecturer_id', '=', $this->sidang->pembimbing2_id)->count();

            if ($countRevisiPenguji1NotCompleteByMahasiswa > 0)
                $errors[] = 'Mahasiswa belum mengumpulkan semua revisi dari Penguji 1';
            if ($countRevisiPenguji2NotCompleteByMahasiswa > 0)
                $errors[] = 'Mahasiswa belum mengumpulkan semua revisi dari Penguji 2';
            if ($countRevisiPembimbing1NotCompleteByMahasiswa > 0)
                $errors[] = 'Mahasiswa belum mengumpulkan semua revisi dari Pembimbing 1';
            if ($countRevisiPembimbing2NotCompleteByMahasiswa > 0)
                $errors[] = 'Mahasiswa belum mengumpulkan semua revisi dari Pembimbing 2';
            if ($countRevisiNotCompleteByPenguji1 > 0)
                $errors[] = 'Penguji 1 belum melakukan approval';
            if ($countRevisiNotCompleteByPenguji2 > 0)
                $errors[] = 'Penguji 2 belum melakukan approval';
            if ($countRevisiNotCompleteByPembimbing1 > 0)
                $errors[] = 'Pembimbing 1 belum melakukan approval';
            if ($countRevisiNotCompleteByPembimbing2 > 0)
                $errors[] = 'Pembimbing 2 belum melakukan approval';
        }

        return $errors;
    }
    public static function getCountPembimbing($schedule_id, $pembimbing_id)
    {
        return Schedule::join('revisions', 'revisions.schedule_id', '=', 'schedules.id')
            ->where('schedules.id', '=', $schedule_id)
            ->where('revisions.lecturer_id', '=', $pembimbing_id)
            ->count();
    }
    public static function getCountPenguji($schedule_id, $penguji_id)
    {
        return Schedule::join('revisions', 'revisions.schedule_id', '=', 'schedules.id')
            ->where('schedules.id', '=', $schedule_id)
            ->where('revisions.lecturer_id', '=', $penguji_id)
            ->count();
    }
}
