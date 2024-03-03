<?php

namespace App\Http\Controllers;

use App\Exports\RevisionMultiplesExport;
use App\Http\Requests\CreateRevisionRequest;
use App\Http\Requests\UpdateRevisionRequest;
use App\Models\Revision;
use App\Models\Schedule;
use App\Models\DokumenLog;
use App\Models\RevisionLog;
use App\Models\Lecturer;
use Auth;
use Illuminate\Http\Request;
use Flash;
use Response;
use DB;
use Carbon\Carbon;
use Log;
use Excel;

class RevisionController extends AppBaseController
{
  public function __construct()
  {
    //Add permission for spesific method
    //Permission must add per method and you choose what role can access
    $this->middleware('checkRole:RLMHS', ['only' => ['indexMahasiswa']]);
    $this->middleware('checkRole:RLPGJ,RLPBB', ['only' => ['indexDosen', 'showRevisionLog', 'create', 'edit', 'update', 'destroy', 'show']]);
  }

  /**
   * Display a listing of the Revision.
   *
   * @param Request $request
   *
   * @return Response
   */
  public function index(Request $request)
  {
    /** @var Revision $revisions */
    $revisions = Revision::all();

    if (Auth::user()->isStudent()) {
      return redirect('/revision/mahasiswa');
    }

    abort('401');

    return view('revisions.index')
      ->with('revisions', $revisions);
  }

  public function indexMahasiswa(Request $request)
  {

    $revisions = Revision::whereHas('schedule.sidang', function ($query) {
      $query->where('mahasiswa_id', Auth::user()->student->nim);
    })->get();
    $cek_sidang = Schedule::whereHas('sidang', function ($query) {
      $query->where('mahasiswa_id', Auth::user()->student->nim);
    })->get();
    // echo "<pre>";
    // print_r($cek_sidang);
    if ($revisions == "[]") {
      if ($cek_sidang != "[]") {
        if ($cek_sidang[0]->keputusan == "lulus") {
          Flash::success('Selamat anda <b>LULUS</b> tanpa revisi');
        } else {
          Flash::warning('Dosen belum memberikan revisi, harap menghubungi dosen yang bersangkutan dalam <b>1x24 jam</b>');
        }
      } else {
        Flash::warning('Tidak ada revisi, pastikan anda sudah mendaftar sidang');
      }
    }

    return view('revisions.index')
      ->with('revisions', $revisions);
  }

  public function indexDosen(Request $request)
  {

    $schedules = Schedule::whereHas('revisions', function ($query) {
      $query->where('lecturer_id', Auth::user()->lecturer->id)
        ->whereIn('status', ['sudah dikirim', 'sedang dikerjakan']);
    })
      ->where('status', '<>', 'belum dilaksanakan')
      ->whereHas('sidang', function ($query) {
        $query->whereNotIn('status', ['sidang ulang', 'lulus', 'tidak lulus']);
      })
      ->where(function ($query) {
        $query->where('keputusan', '<>', 'tidak lulus')
          ->orWhere('keputusan', '=', null);
      })

      ->orderBy('updated_at', 'desc')

      ->get();

    return view('revisions.index')
      ->with('schedules', $schedules);
  }

  /**
   * Show the form for creating a new Revision.
   *
   * @return Response
   */
  public function create($schedule_id)
  {
    // penambahan penguji dan pembimbing

    $penguji = Schedule::with('detailpenguji2')->where('id', '=', $schedule_id)->first();
    $penguji1 = Lecturer::with('user')->where('id', '=', $penguji->penguji1)->first();
    $penguji2 = Lecturer::with('user')->where('id', '=', $penguji->penguji2)->first();
    $pembimbing = schedule::with('sidang')->where('id', '=', $schedule_id)->first();
    $pembimbing1 = Lecturer::with('user')->where('id', '=', $pembimbing->sidang->pembimbing1_id)->first();
    $pembimbing2 = Lecturer::with('user')->where('id', '=', $pembimbing->sidang->pembimbing2_id)->first();

    $npembimbing1 = Schedule::getCountPembimbing($schedule_id, $pembimbing->sidang->pembimbing1_id);
    // join('revisions','revisions.schedule_id','=','schedules.id')
    // ->where('schedules.id','=',$schedule_id)
    // ->where('revisions.lecturer_id','=',$pembimbing->sidang->pembimbing1_id)
    // ->count();
    $npembimbing2 = Schedule::getCountPembimbing($schedule_id, $pembimbing->sidang->pembimbing2_id);
    // join('revisions','revisions.schedule_id','=','schedules.id')
    // ->where('schedules.id','=',$schedule_id)
    // ->where('revisions.lecturer_id','=',$pembimbing->sidang->pembimbing2_id)
    // ->count();
    $npenguji1 = Schedule::getCountPenguji($schedule_id, $penguji->penguji1);
    // join('revisions','revisions.schedule_id','=','schedules.id')
    // ->where('schedules.id','=',$schedule_id)
    // ->where('revisions.lecturer_id','=',$penguji->penguji1)
    // ->count();
    $npenguji2 = Schedule::getCountPenguji($schedule_id, $penguji->penguji2);
    // join('revisions','revisions.schedule_id','=','schedules.id')
    // ->where('schedules.id','=',$schedule_id)
    // ->where('revisions.lecturer_id','=',$penguji->penguji2)
    // ->count();
    //end tambahan

    $schedule = Schedule::find($schedule_id);

    $revisions = Revision::with('dokumen')
      ->where('schedule_id', $schedule_id)
      ->where('lecturer_id', Auth::user()->lecturer->id)
      ->get();

    if ($revisions != '[]') {
      return redirect(route('revisions.edit', $schedule_id));
    }
    $revisions = null;
    $isLate = false;
    $currentDateTime = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d', strtotime($schedule->date)) . " " . $schedule->time);
    if (Carbon::now() > ($currentDateTime->add(1, 'day'))) {
      $isLate = true;
    }

    if ($schedule->flag_add_revision)
      $isLate = false;

    return view('revisions.create', compact(
      'penguji1',
      'penguji2',
      'pembimbing1',
      'pembimbing2',
      'npenguji1',
      'npenguji2',
      'npembimbing1',
      'npembimbing2',
      'schedule',
      'isLate'
    ))->with([
      'revisions' => null,
    ]);
  }
  /**
   * Store a newly created Revision in storage.
   *
   * @param CreateRevisionRequest $request
   *
   * @return Response
   */
  public function store(CreateRevisionRequest $request)
  {
    // return $request;
    $userInfo = Auth::user();

    if ($request->hasFile('file')) {
      $this->validate($request, [
        'file' => 'required|mimes:pdf|max:5120',
      ], [
        'file.required' => 'pilih dokumen dahulu',
        'file.mimes' => 'File yang dimasukkan harus PDF',
        'file.max' => 'Ukuran tidak boleh lebih dari 15mb'
      ]);
      DB::beginTransaction();
      // return $document;
      $dokumen_ta = $request->file('file');
      $dokumen_ta_extension = $request->file('file')->extension();
      $dokumen_ta_name = "draft_revisi_" . Auth::user()->lecturer->id . "_" . date('Y-m-d_H-i-s') . "." . $dokumen_ta_extension;
      $dokumen_ta->move('uploads/file', $dokumen_ta_name);

      $schedule = Schedule::find($request->schedule_id);
      $document = $this->getDocumentRevision($request, $schedule);

      $input_dokumen = [
        'sidang_id' => $schedule->sidang_id,
        'nama' => $dokumen_ta_name,
        'jenis' => 'revisi',
        'file_url' => 'uploads/file/' . $dokumen_ta_name,
        'created_by' => $userInfo->id
      ];
      for ($i = 0; $i < count($request->deskripsi); $i++) {
        $documents = DokumenLog::create($input_dokumen);
        Revision::create([
          'schedule_id' => $request->schedule_id,
          'status' => 'sedang dikerjakan',
          'dokumen_id' => $documents->id,
          'lecturer_id' => Auth::user()->lecturer->id,
          'file' => 'uploads/file/' . $dokumen_ta_name,
          'deskripsi' => $request->deskripsi[$i] ?? '-',
          'hal' => $request->hal[$i] ?? '-',
        ]);

        DB::commit();
      }
    } elseif ($request->dokumen_ta == null) {
      $this->validate($request, [
        'deskripsi.*' => 'required',
      ], [
        'deskripsi.*.required' => 'Minimal ada satu deskirpsi revisi sebelum disubmit atau upload dokumen',
      ]);
      $schedule = Schedule::find($request->schedule_id);
      $document = $this->getDocumentRevision($request, $schedule);
      for ($i = 0; $i < count($request->deskripsi); $i++) {
        if ($schedule->keputusan != "tidak lulus") {
          $revision = Revision::create([
            'schedule_id' => $request->schedule_id,
            'deskripsi' => $request->deskripsi[$i] ?? '-',
            'hal' => $request->hal[$i] ?? '-',
            'status' => 'sedang dikerjakan',
            'dokumen_id' => $document->id,
            'lecturer_id' => Auth::user()->lecturer->id,
          ]);
        } else {
          $revision = Revision::create([
            'schedule_id' => $request->schedule_id,
            'deskripsi' => $request->deskripsi[$i] ?? '-',
            'hal' => $request->hal[$i] ?? '-',
            'status' => 'sedang dikerjakan',
            'dokumen_id' => $document->id,
            'lecturer_id' => Auth::user()->lecturer->id,
            'status' => 'disetujui',
          ]);
        }
      }
      $title = "Revisi Sidang";
      $message = "Selamat, Anda mendapatkan revisi baru!";
      $url = "/revisions";
      $this->sendNotification($schedule->sidang->mahasiswa->nim, $title, $message, $url);
    }

    DB::commit();

    Flash::success('Berhasil membuat revisi');
    return redirect(route('revisions.edit', $schedule->id));
  }

  private function getDocumentRevision($request, $schedule)
  {
    /*
      kalau form create revisi tidak melampirkan dokumen, maka dianggap dokumen
      draft terakhir dijadikan sebagai inputan ke table revision
      di update per 23 Juli 2021:
      jika form tidak melampirkan revisi maka dianggap tidak ada file terlampir
      */
      $document = null;
      if ($request->dokumen_ta == null) {
        $revisions = $schedule->revisions
                              ->where('lecturer_id', Auth::user()->lecturer->id);
        if (count($revisions)==0) {
            $document = DokumenLog::where('sidang_id', $schedule->sidang->id)
            ->where('jenis', 'draft')
            ->orderBy('created_at', 'desc')
            ->first();
        }else{
            $key = key(reset($revisions));
            $document = (object)['id'=>$revisions[$key]->dokumen_id];
        }
      }else{
        $dokumen_ta = $request->file('dokumen_ta');
        $dokumen_ta_extension = $request->file('dokumen_ta')->extension();
        $dokumen_ta_name = "draft_ta_".$schedule->sidang->mahasiswa_id."_".date('Y-m-d_H-i-s').".".$dokumen_ta_extension;
        $dokumen_ta->move('uploads/ta', $dokumen_ta_name);

        $document = DokumenLog::create([
            'sidang_id' => $schedule->sidang->id,
            'nama' => $dokumen_ta_name,
            'jenis' => 'revisi',
            'file_url' => 'uploads/ta/'.$dokumen_ta_name,
            'created_by' => Auth::user()->id
        ]);
      }
      return $document;
    }


    /**
     * Display the specified Revision.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($schedule_id)
    {

        $schedule = Schedule::find($schedule_id);

        if(!Auth::user()->isAdmin()){
          //cek apakah yang request merupakan pembimbing
          if ($schedule->sidang->pembimbing1_id != Auth::user()->lecturer->id AND
              $schedule->sidang->pembimbing2_id != Auth::user()->lecturer->id) {
              abort(401);
          }

          //cek status schedulenya
          if ($schedule->status != 'telah dilaksanakan') {
              Flash::error('Mahasiswa NIM '.$schedule->sidang->mahasiswa_id.' belum melaksanakan sidang');
              return redirect()->back();
          }
        }

        $revisions = Revision::where('schedule_id', $schedule_id)->get();

        if (empty($revisions)) {
            Flash::error('Revision not found');
            return redirect()->back();
        }

        return view('revisions.show')->with('revisions', $revisions);
    }

    /**
     * Show the form for editing the specified Revision.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($schedule_id)
    {
        // penambahan penguji dan pembimbing
        $penguji = Schedule::with('detailpenguji2')->where('id', '=', $schedule_id)->first();
        $penguji1 = Lecturer::with('user')->where('id', '=', $penguji->penguji1)->first();
        $penguji2 = Lecturer::with('user')->where('id', '=', $penguji->penguji2)->first();
        $pembimbing = schedule::with('sidang')->where('id', '=', $schedule_id)->first();
        $pembimbing1 = Lecturer::with('user')->where('id', '=', $pembimbing->sidang->pembimbing1_id)->first();
        $pembimbing2 = Lecturer::with('user')->where('id', '=', $pembimbing->sidang->pembimbing2_id)->first();


        $npembimbing1 = Schedule::join('revisions', 'revisions.schedule_id', '=', 'schedules.id')
          ->where('schedules.id', '=', $schedule_id)
          ->where('revisions.lecturer_id', '=', $pembimbing->sidang->pembimbing1_id)
          ->count();
        $npembimbing2 = Schedule::join('revisions', 'revisions.schedule_id', '=', 'schedules.id')
          ->where('schedules.id', '=', $schedule_id)
          ->where('revisions.lecturer_id', '=', $pembimbing->sidang->pembimbing2_id)
          ->count();
        $npenguji1 = Schedule::join('revisions', 'revisions.schedule_id', '=', 'schedules.id')
          ->where('schedules.id', '=', $schedule_id)
          ->where('revisions.lecturer_id', '=', $penguji->penguji1)
          ->count();
        $npenguji2 = Schedule::join('revisions', 'revisions.schedule_id', '=', 'schedules.id')
          ->where('schedules.id', '=', $schedule_id)
          ->where('revisions.lecturer_id', '=', $penguji->penguji2)
          ->count();
        // end tambahan
        // return $schedule_id;
        // $s = Schedule::where('id','=',$schedule_id)->first();
        $schedule = Schedule::where('id', '=', $schedule_id)->first();

        $revisions = Revision::with('dokumen')
          ->where('schedule_id', $schedule_id)
          ->where('lecturer_id', Auth::user()->lecturer->id)
          ->get();
        // return $revisions;

        if (empty($revisions)) {
          Flash::error('Revision not found');
          return redirect(route('revisions.index.dosen'));
        }

        //Get status dokumen yang tidak di upload oleh dosen. jika dokumen sama dengan draft mahasiswa, maka tidak perlu di tampilkan
        $document = DokumenLog::where('sidang_id', $schedule->sidang->id)
            ->where('jenis', 'draft')
            ->orderBy('created_at', 'desc')
            ->first();
        $isDocumentMahasiswa = false;
        $key = key(reset($revisions));
        if($document->id == $revisions[$key]->document_id)
        {
            $isDocumentMahasiswa = true;
        }

        $isLate = false;
        $currentDateTime = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d', strtotime($schedule->date)) . " " . $schedule->time);
        if (Carbon::now() > ($currentDateTime->add(1, 'day'))) {
          $isLate = true;
        }

        if ($schedule->flag_add_revision)
          $isLate = false;

        return view('revisions.edit', compact(
          'penguji1',
          'penguji2',
          'pembimbing1',
          'pembimbing2',
          'npenguji1',
          'npenguji2',
          'npembimbing1',
          'npembimbing2',
          'schedule',
          'revisions',
          'isLate',
          'isDocumentMahasiswa'
        ));
    }


  /**
   * Update the specified Revision in storage.
   *
   * @param int $id
   * @param UpdateRevisionRequest $request
   *
   * @return Response
   */
  public function update($schedule_id, Request $request)
  {

    $this->validate($request, [
      'deskripsi.*' => ['required'],
      'hal.*' => ['required'],
    ], [
      'deskripsi.*.required' => 'Harus ada Deskripsi',
      'hal.*.required' => 'Harus ada Halaman',
    ]);
    // pembimbing memberi revisi
    $a = count($request->deskripsi) - 1;
    $userInfo = Auth::user();
    $schedule = Schedule::find($schedule_id);
    $document = $this->getDocumentRevision($request, $schedule);
    if ($request->hasFile('file')) {
      $this->validate($request, [
        'file' => 'required|mimes:pdf|max:5120',
      ], [
        'file.required' => 'pilih dokumen dahulu',
        'file.mimes' => 'File yang dimasukkan harus PDF',
        'file.max' => 'Ukuran tidak boleh lebih dari 5mb'
      ]);

      DB::beginTransaction();

      // return $document;
      $dokumen_ta = $request->file('file');
      $dokumen_ta_extension = $request->file('file')->extension();
      $dokumen_ta_name = "draft_revisi_" . Auth::user()->lecturer->id . "_" . date('Y-m-d_H-i-s') . "." . $dokumen_ta_extension;
      $dokumen_ta->move('uploads/file', $dokumen_ta_name);

      $input_dokumen = [
        'sidang_id' => $schedule->sidang_id,
        'nama' => $dokumen_ta_name,
        'jenis' => 'revisi',
        'file_url' => 'uploads/file/' . $dokumen_ta_name,
        'created_by' => $userInfo->id
      ];
      for ($i = count($request->revision_id); $i < count($request->deskripsi); $i++) {
        $documents = DokumenLog::create($input_dokumen);
        Revision::create([
          'schedule_id' => $schedule_id,
          'status' => 'sedang dikerjakan',
          'dokumen_id' => $documents->id,
          'lecturer_id' => Auth::user()->lecturer->id,
          'deskripsi' => $request->deskripsi[$i] ?? '-',
          'hal' => $request->hal[$i] ?? '-',
        ]);

        DB::commit();
      }
    } elseif ($request->dokumen_ta == null) {
      //tambah revisi
      for ($i = 0; $i < count($request->deskripsi); $i++) {

        if (!empty($request->revision_id[$i])) {
          Revision::where('id',$request->revision_id[$i])
          ->update([
            'schedule_id' => $schedule_id,
            'deskripsi' => $request->deskripsi[$i],
            'hal' => $request->hal[$i] ?? '-',
            'status' => 'sedang dikerjakan',
            'dokumen_id' => $request->dokumen_id[$i] ?? $document->id,
            'lecturer_id' => Auth::user()->lecturer->id,
          ]);
        }else{
			$schedule = Schedule::find($request->schedule_id);
			// $document = $this->getDocumentRevision($request, $schedule);

            $document = DokumenLog::where('sidang_id', $schedule->sidang->id)
            ->where('jenis', 'draft')
            ->orderBy('created_at', 'desc')
            ->first();

			Revision::create([
				'schedule_id' => $schedule_id,
				'status' => 'sedang dikerjakan',
				'dokumen_id' => $document->id,
				'lecturer_id' => Auth::user()->lecturer->id,
				'deskripsi' => $request->deskripsi[$i] ?? '-',
				'hal' => $request->hal[$i] ?? '-',
			]);
        }
    }

      $this->sendNotification(
        $schedule->sidang->mahasiswa->nim,
        "Revisi",
        "Revisi anda ada yang diubah oleh kode dosen " . Auth::user()->lecturer->code,
        "revision/mahasiswa"
      );

      DB::commit();
    }
    Flash::success('Revision berhasil diupdate.');
    return redirect(route('revisions.edit', $schedule));
  }

  /**
   * Remove the specified Revision from storage.
   *
   * @param int $id
   *
   * @throws \Exception
   *
   * @return Response
   */
  public function destroy($id)
  {
    $revision = Revision::find($id);

    if (empty($revision)) {
      Flash::error('Revision not found');
      return redirect(route('revisions.index.dosen'));
    }

    $revision->delete();
    $this->sendNotification(
      $revision->schedule->sidang->mahasiswa->nim,
      "Revisi",
      "Revisi anda ada yang dihapus oleh kode dosen " . Auth::user()->lecturer->code,
      "revision/mahasiswa"
    );

    Flash::success('Berhasil menghapus revisi');
    return redirect(route('revisions.index.dosen'));
  }

  public function ajukanRevisi(Request $request)
  {
    // mahasiswa revisi
    // return $request;

    $this->validate(
      $request,
      [
        'dokumen_ta' => 'required|mimes:pdf|max:5120',
        'revision_id' => 'required',
        'hal.*' => 'required'
      ],
      [
        'revision_id.required' => 'Anda belum memilih revisi yang mana',
        'dokumen_ta.required' => 'Anda belum update dokumen TA',
        'hal.*.required' => 'Anda belum memasukkan halaman',
        'dokumen_ta.mimes' => 'File yang dimasukkan harus PDF',
        'dokumen_ta.max' => 'Ukuran tidak boleh lebih dari 5mb'
      ]
    );

    $userInfo = Auth::user();

    //cek status schedule
    $statusPelaksanaan = Revision::find($request->revision_id[0])->schedule->status;
    if ($statusPelaksanaan != 'telah dilaksanakan') {
      Flash::error('Maaf revisi tidak bisa dikumpulkan, karena status pelaksanaan sidang anda belum selesai. Silahkan hubungi dosen penguji 1 agar menyelesaikan pelaksanaan sidang');
      return redirect(route("revisions.index.mahasiswa"));
    }

    DB::beginTransaction();

    $dokumen_ta = $request->file('dokumen_ta');
    $dokumen_ta_extension = $request->file('dokumen_ta')->extension();
    $dokumen_ta_name = "draft_ta_" . $userInfo->student->nim . "_" . date('Y-m-d_H-i-s') . "." . $dokumen_ta_extension;
    $dokumen_ta->move('uploads/ta', $dokumen_ta_name);

    $input_dokumen = [
      'sidang_id' => $request->sidang_id,
      'nama' => $dokumen_ta_name,
      'jenis' => 'revisi',
      'file_url' => 'uploads/ta/' . $dokumen_ta_name,
      'created_by' => $userInfo->id
    ];

    $document = DokumenLog::create($input_dokumen);

    $statusKelulusan = Revision::find($request->revision_id[0])->schedule->keputusan;
    if ($statusKelulusan == "lulus") {
      for ($i = 0; $i < count($request->revision_id); $i++) {
        $revision = Revision::find($request->revision_id[$i]);
        $revision->update([
          'status' => 'disetujui',
          'hal' => $request->hal[$request->revision_id[$i]],
          'dokumen_mhs' => $document->id,
          // 'dokumen_id' => $document->id,
        ]);
        // echo "<pre>";
        // print_r([
        //   'status' => 'disetujui',
        //   'hal' => $request->hal[$request->revision_id[$i]],
        //   'dokumen_mhs' => $document->id,
        //   // 'dokumen_id' => $document->id,
        // ]);
        StatusLogController::addStatusLog(
          $revision->schedule->sidang->id,
          "-",
          'revisi',
          'disetujui'
        );
      }
    } else {
      for ($i = 0; $i < count($request->revision_id); $i++) {
        $revision = Revision::find($request->revision_id[$i]);
        $revision->update([
          'status' => 'sudah dikirim',
          'hal' => $request->hal[$request->revision_id[$i]],
          // 'dokumen_id' => $document->id,
          'dokumen_mhs' => $document->id,
        ]);
      }
    }
    DB::commit();

    Flash::success('Berhasil mengirimkan revisi');
    return redirect(route("revisions.index.mahasiswa"));
  }

  public function approve(Request $request, $revision_id)
  {
    DB::beginTransaction();
    $revision = Revision::find($revision_id);
    $revision->update([
      'status' => 'disetujui'
    ]);
    StatusLogController::addStatusLog(
      $revision->schedule->sidang->id,
      "-",
      'revisi',
      'disetujui'
    );
    $this->sendNotification(
      $revision->schedule->sidang->mahasiswa->nim,
      "Approve Revisi",
      "Revisi anda berhasil di approve",
      "revision/mahasiswa"
    );
    //Cek apabila semua revisi telah disetujui
    if(Revision::where([['schedule_id',$revision->schedule_id],['status','<>','disetujui']])->count()<1)
    {
      $revision->schedule->sidang()->update([
        'status' => 'lulus',
        'updated_at' => now()
      ]);
      StatusLogController::addStatusLog(
        $revision->schedule->sidang->id,
        "-",
        'lulus',
        'lulus'
      );
      $this->sendNotification(
        $revision->schedule->sidang->mahasiswa->nim,
        "Lulus",
        "Selamat Revisi anda semua telah disetujui",
        "revision/mahasiswa"
      );
    }
    DB::commit();
    Flash::success('Berhasil disetujui');
    return redirect()->to(url()->previous() . '#user_' . $revision->schedule->id)->with('current', $revision->schedule->id);
  }

  public function tolak(Request $request, $revision_id)
  {
    DB::beginTransaction();
    $revision = Revision::find($revision_id);
    $revision->update([
      'status' => 'sedang dikerjakan',
      'feedback' => $request->feedback
    ]);

    RevisionLog::insert([
      'revision_id' => $revision_id,
      'feedback' => $request->feedback,
      'created_at' => Carbon::now(),
      'updated_at' => Carbon::now(),
    ]);

    StatusLogController::addStatusLog(
      $revision->schedule->sidang->id,
      "-",
      'revisi',
      'dikembalikan'
    );
    StatusLogController::addStatusLog(
      $revision->schedule->sidang->id,
      "-",
      'revisi',
      'sedang dikerjakan'
    );
    $this->sendNotification(
      $revision->schedule->sidang->mahasiswa->nim,
      "Revisi Ditolak",
      "Revisi anda ditolak, silahkan kerjakan revisi ulang",
      "revision/mahasiswa"
    );
    DB::commit();
    Flash::success('Berhasil ditolak');
    return redirect()->to(url()->previous() . '#user_' . $revision->schedule->id)->with('current', $revision->schedule->id);
  }

  public function getLastDoc()
  {
    $revisions = Revision::where('status', 'sudah dikirim')->orWhere('status', 'disetujui')->get();
    foreach ($revisions as $revision) {
      $sidang_id = $revision->schedule->sidang_id;
      $document_last = DokumenLog::ofSidang($sidang_id)->orderBy('created_at', 'desc')->first();
      $revision->dokumen_id = $document_last->id;
      $result = $revision->update();
      //  dd($result." : ".$revision->id." : ".$document_last->id);
    }
    //    dd('berhasil');
  }

  public function showRevisionLog($revision_id)
  {
    $revisionLogs = RevisionLog::where('revision_id', $revision_id)->get();
    return view('revisions.show_logsEmbed', compact('revisionLogs'));
  }

    public function export($period_id)
    {
        return Excel::download(new RevisionMultiplesExport($period_id), 'revisions_each_lecturer.xlsx');
    }

}
