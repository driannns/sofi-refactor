<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSidangRequest;
use App\Http\Requests\UpdateSidangRequest;
use App\Repositories\SidangRepository;
use App\Http\Controllers\AppBaseController;
use App\User;
use Illuminate\Http\Request;
use App\Models\Lecturer;
use App\Models\Period;
use App\Models\DokumenLog;
use App\Models\Sidang;
use App\Models\StatusLog;
use App\Models\Role;
use App\Models\Peminatan;
use App\Models\Student;
use App\Models\Team;
use App\Models\Parameter;
use Flash;
use Response;
use Auth;
use Session;
use Alert;
use DB;
use Carbon\Carbon;

class SidangController extends AppBaseController
{
    /** @var  SidangRepository */
    private $sidangRepository;

    public function __construct(SidangRepository $sidangRepo)
    {
        $this->sidangRepository = $sidangRepo;

        //Add permission for spesific method
        //Permission must add per method and you choose what role can access
        $this->middleware('checkRole:RLMHS', ['only' => ['create', 'store', 'show']]);
        $this->middleware('checkRole:RLADM,RLSPR', ['only' => ['index', 'delete', 'indexAll', 'indexSuratTugasPenguji']]);
        $this->middleware('checkRole:RLADM,RLMHS,RLPIC,RLPBB,RLPGJ', ['only' => ['edit', 'update']]);
        $this->middleware('checkRole:RLPIC', ['only' => ['indexPIC']]);
        $this->middleware('checkRole:RLPBB', ['only' => ['indexPembimbing']]);
    }

    /**
     * Display a listing of the Sidang.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $sidangs = Sidang::whereIn('status', ['ditolak oleh admin', 'belum disetujui admin', 'telah disetujui admin', 'belum dijadwalkan','tidak lulus (sudah update dokumen)'])
            ->orWhere(function ($query) {
                $query->whereHas('schedules', function ($query) {
                    $query->where('status', 'belum dilaksanakan');
                });
            })
            ->get();

        $documents = DokumenLog::all();

        activity()
            ->causedBy(Auth::user())
            ->log('Sidang:Index');

        return view('sidangs.index', compact('sidangs', 'documents'));
    }

    //untuk list upload Surat Tugas Penguji
    public function indexSuratTugasPenguji(Request $request)
    {
        $period = $request->query('period');
        $periodNowId = Period::getPeriodNowId();
        $nowPeriods = Period::getAllPeriod();
        $nowPeriods[0] = 'Semua Periode';
        $userInfo = Auth::user();
        if ($period != 0 and $period != null) {
            $sidangs = Sidang::where('period_id', $period)->get();
        } elseif ($period == 0) {
            $sidangs = Sidang::all();
        } else {
            $sidangs = Sidang::whereIn('period_id', $periodNowId)->get();
        }

        activity()
            ->causedBy(Auth::user())
            ->performedOn($sidangs)
            ->log('SuratTugasPenguji:Index');

        return view('sidangs.indexSkPenguji', compact('sidangs'));
    }

    public function indexAll(Request $request)
    {
        $period = $request->query('period');
        $periodNowId = Period::getPeriodNowId();
        $nowPeriods = Period::getAllPeriod();
//        array_unshift($nowPeriods,'Semua Periode');
        $userInfo = Auth::user();
        if ($period != 0 and $period != null) {
            $sidangs = Sidang::where('period_id', $period)->get();
//        } elseif ($period == 0) {
//            $sidangs = Sidang::all();
        } else {
            $sidangs = Sidang::whereIn('period_id', $periodNowId)->get();
        }

        activity()
            ->causedBy(Auth::user())
            ->log('Sidang:Index');


        if ($userInfo->isSuperadmin())
            return view('sidangs.indexSuperadmin', compact('sidangs', 'nowPeriods', 'period'));
        else
            return view('sidangs.indexAll', compact('sidangs'));
    }

    public function indexPembimbing()
    {
        $userInfo = Auth::user();
        $sidangs = Sidang::where('pembimbing1_id', $userInfo->lecturer->id)->orWhere('pembimbing2_id', $userInfo->lecturer->id)->get();

        $documents = DokumenLog::all();
        activity()
            ->causedBy(Auth::user())
            ->log('Sidang:IndexPembimbing');

        return view('sidangs.index', compact('sidangs', 'documents'));
    }

    public function indexPIC()
    {
        $userInfo = Auth::user();

        // $sidangs = Sidang::with('mahasiswa', 'mahasiswa.team', 'schedules')
        //     ->whereHas('mahasiswa', function ($query) use ($userInfo) {
        //         $query->where('kk', $userInfo->lecturer->kk);
        //     })
        //     ->whereIn('status', ['belum dijadwalkan', 'tidak lulus (belum dijadwalkan)'])
        //     ->get();
        $sidangs = Sidang::all();

        $documents = DokumenLog::all();
        activity()
            ->causedBy(Auth::user())
            ->log('Sidang:IndexPIC');

        // ddd($sidangs);

        return view('sidangs.index', compact('sidangs', 'documents'));
    }

    /**
     * Show the form for creating a new Sidang.
     *
     * @return Response
     */
    public function uploadSkForm($id)
    {
        $sidang = $this->sidangRepository->find($id);
        if ($sidang == null) {
            return redirect()->back()->withError('Data Sidang tidak ditemukan');
        }
        activity()
            ->causedBy(Auth::user())
            ->log('Upload_Sk_Form:FormAdmin');


        return view('sidangs.uploadSKForm', compact('sidang'));
    }

    public function storeSkPenguji($id, Request $request)
    {
        $sidang = $this->sidangRepository->find($id);
        $input = $request->all();
        $userInfo = Auth::user();

        if (empty($sidang)) {
            Flash::error('Sidang Tidak Ada');
            activity()
                ->causedBy(Auth::user())
                ->log('UploadSk:Error_NotFound');

            return redirect(route('sidangs.index'));
        }

        if ($input) {

            $this->validate($request, [
                'sk_penguji_file' => 'required|mimes:pdf|max:5120'
            ]);


            //GetFile
            if ($request->file('sk_penguji_file')) {
                if($sidang->sk_penguji_file != null)
                {
                    if(file_exists(public_path('uploads/sk_penguji/'.$sidang->sk_penguji_file)))
                        unlink(public_path('uploads/sk_penguji/'.$sidang->sk_penguji_file));
                }
                $sk_penguji = $request->file('sk_penguji_file');
                $sk_penguji_extension = $request->file('sk_penguji_file')->extension();
                $sk_penguji_name = "sk_penguji_" . $sidang->mahasiswa->nim . "_" . date('Y-m-d_H-i-s') . "." . $sk_penguji_extension;
                $sk_penguji->move('uploads/sk_penguji', $sk_penguji_name);

                $input['sk_penguji_file'] = $sk_penguji_name;
                $input_dokumen = [
                    'sidang_id' => $id,
                    'nama' => $sk_penguji_name,
                    'jenis' => 'sk penguji',
                    'file_url' => 'uploads/sk_penguji/' . $sk_penguji_name,
                    'created_by' => $userInfo->id,
                ];
                DokumenLog::create($input_dokumen);
            }

            $sidang = $this->sidangRepository->update($input, $id);

            Flash::success('SK Penguji berhasil di upload');
            activity()
                ->causedBy(Auth::user())
                ->log('Upload_Sk:Admin');

            return redirect(route('sidangs.indexSuratTugasPenguji'));

        }
    }


    /**
     * 
     *  the form for creating a new Sidang.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        $lecturers = Lecturer::with('user')->orderBy('code')->get(); //dapet output employeeID API Lecturer
        $userInfo = Auth::user()->student; // JWT SOFI Lama
        $period = Period::getPeriodNow(); //Ambil periode sekarang

        $sidang = Sidang::isExist($userInfo->nim); //API Afif
        if ($sidang != null) {
            if (in_array($sidang->status, ['pengajuan', 'ditolak oleh admin'])) {
                // dd(Flash::has('message'));
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn($sidang)
                    ->log('Sidang:Edit');
                return redirect(route('sidangs.edit', ['sidang' => $sidang->id]));
            } else
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn($sidang)
                    ->log('Sidang:Edit');
                return redirect(route('sidangs.show', ['sidang' => $sidang->id]));
        }

        $parameter = Parameter::find('periodAcademic'); // API TA Student
        // dd($parameter);
        //request data from igracias
        $client = new \GuzzleHttp\Client(['verify' => false]);
        $response = $client->request('GET', config('app.api.getAllStudents') . '/' . "2223-1" . '/' . $userInfo->nim);
        $dataStudent = json_decode($response->getBody());
        if ($dataStudent->data == null) {
            Flash::error('Anda tidak terdaftar di periode akademik ini');
            activity()
                ->causedBy(Auth::user())
                ->log('Sidang:Data_API_NotFound');
            return redirect('/home');
        }
        $bimbingan1 = $dataStudent->data[0]->totalguidance_advisor1;
        $bimbingan2 = $dataStudent->data[0]->totalguidance_advisor2;
        $sks_lulus = $dataStudent->data[0]->credit_complete;
        $sks_belum_lulus = $dataStudent->data[0]->credit_uncomplete;

        //request data form igracias -> lecturer_status
        $client = new \GuzzleHttp\Client(['verify' => false]);
        $response = $client->request('GET', config('app.api.getStatusLog') . '/' . "$parameter->value" . '/' . $userInfo->nim);
        $dataLecturer = json_decode($response->getBody());
        if ($dataLecturer->data == null) {
            Flash::error('Data anda tidak ditemukan. Silahkan hubungi admin');
            activity()
                ->causedBy(Auth::user())
                ->performedOn($sidang)
                ->log('Sidang:DATA_API_Persetujuan_NotFound');
            return redirect('/home');
        } else {
            $lecturer_status = $dataLecturer->data[0]->lecturerstatus;
        }

        $peminatans = Peminatan::where('kk', $userInfo->kk)->get();
        activity()
            ->causedBy(Auth::user())
            ->log('Sidang:Create_Form');

        return view('sidangs.create', compact('peminatans', 'sidang', 'lecturers', 'userInfo', 'period', 'bimbingan1', 'bimbingan2', 'sks_lulus', 'sks_belum_lulus', 'lecturer_status'));
    }

    /**
     * Store a newly created Sidang in storage.
     *
     * @param CreateSidangRequest $request
     *
     * @return Response
     */
    public
    function store(CreateSidangRequest $request)
    {
        $userInfo = Auth::user();
        $input = $request->all();

        //update peminatan
        Student::where('user_id', $userInfo->id)
            ->update([
                'peminatan_id' => $request->peminatan
            ]);

        //cek data sidang
        $isDataSidangExist = Sidang::where('mahasiswa_id', $userInfo->student->nim)->first();
        if ($isDataSidangExist != null) {
            activity()
                ->causedBy(Auth::user())
                ->performedOn($isDataSidangExist)
                ->log('Sidang:Create_Error_Data_Exist');
            return redirect()->back()->withErrors("Data sudah terdaftar");
        }

        if ($input) {

            //request data from igracias
            $isApproved = $request->lecturer_status;
            if ($isApproved != "APPROVED") {
                activity()
                    ->causedBy(Auth::user())
                    ->log('Sidang:Create_Error_Pembimbing_Not_Approved');
                return redirect()->back()->withInput($input)->withErrors("Pembimbing anda belum approved sidang di igracias");
            }

            if ($input['pembimbing1_id'] == $input['pembimbing2_id']) {
                activity()
                    ->causedBy(Auth::user())
                    ->log('Sidang:Create_Error_Pembimbing_Same_Person');
                return redirect()->back()->withInput($input)->withErrors("pembimbing 1 dan pembimbing 2 tidak bisa sama");
            }

            $lecturer = Lecturer::find($input['pembimbing1_id']);
            if ($lecturer->jfa == 'NJFA') {
                activity()
                    ->causedBy(Auth::user())
                    ->log('Sidang:Create_Error_Pembimbing_Choosen_Not_Eligible');
                return redirect()->back()->withInput($input)->withErrors("Pembimbing 1 harus JFA");
            }

            $this->validate($request, [
                'dokumen_ta' => 'required|mimes:pdf,doc,docx|max:5120',
                'makalah' => 'required|mimes:pdf,doc,docx|max:5120',
                'peminatan' => 'required'
            ], [
                'dokumen_ta.max' => 'Maximal ukuran file adalah 5 MB',
                'dokumen_ta.mimes' => 'Format file harus pdf/doc/docx',
                'makalah.max' => 'Maximal ukuran file adalah 5 MB',
                'makalah.mimes' => 'Format file harus pdf/doc/docx',
            ]);

            //GetFile
            $dokumen_ta = $request->file('dokumen_ta');
            $dokumen_ta_extension = $request->file('dokumen_ta')->extension();
            $dokumen_ta_name = "draft_ta_" . $userInfo->username . "_" . date('Y-m-d_H-i-s') . "." . $dokumen_ta_extension;
            $dokumen_ta->move('uploads/ta', $dokumen_ta_name);

            //GetFile
            $makalah = $request->file('makalah');
            $makalah_extension = $request->file('makalah')->extension();
            $makalah_name = "draft_makalah_" . $userInfo->username . "_" . date('Y-m-d_H-i-s') . "." . $makalah_extension;
            $makalah->move('uploads/makalah', $makalah_name);

            $input['judul'] = strtoupper($input['judul']); //Uppercase Judul TA
            $input['dokumen_ta'] = $dokumen_ta_name;
            $input['makalah'] = $makalah_name;
            $input['status'] = 'belum disetujui admin';
            $input['status_pembimbing1'] = 'disetujui oleh pembimbing1';
            $input['status_pembimbing2'] = 'disetujui oleh pembimbing2';

            $sidang = $this->sidangRepository->create($input);

            $input_dokumen = [
                'sidang_id' => $sidang->id,
                'nama' => $dokumen_ta_name,
                'jenis' => 'draft',
                'file_url' => 'uploads/ta/' . $dokumen_ta_name,
                'created_by' => $userInfo->id
            ];
            $input_makalah = [
                'sidang_id' => $sidang->id,
                'nama' => $makalah_name,
                'jenis' => 'makalah',
                'file_url' => 'uploads/makalah/' . $makalah_name,
                'created_by' => $userInfo->id
            ];
            DokumenLog::create($input_dokumen);
            DokumenLog::create($input_makalah);
            StatusLogController::addStatusLog($sidang->id, "-", "pengajuan", "pengajuan");

            activity()
                ->causedBy(Auth::user())
                ->performedOn($sidang)
                ->log('Sidang:Created');

            //Notif
            $title = "Mahasiswa daftar sidang";
            $message = "Mahasiswa dengan nim " . $userInfo->username . " telah mendaftarkan sidang";
            $url = "/sidangs/pembimbing";

            $this->sendNotification(Lecturer::find($input['pembimbing1_id'])->user->username, $title, $message, $url);
            $this->sendNotification(Lecturer::find($input['pembimbing2_id'])->user->username, $title, $message, $url);
        }

        Flash::success('Sidang Berhasil Disimpan.');

        return redirect(route('sidangs.create'));
    }

    /**
     * Display the specified Sidang.
     *
     * @param int $id
     *
     * @return Response
     */
    public
    function show($id)
    {
        $sidang = $this->sidangRepository->find($id);
        $status_logs = StatusLog::where('sidangs_id', $id)
            ->where(function ($query) {
                $query->where('workflow_type', 'pengajuan')
                    ->orWhere('workflow_type', 'penjadwalan');
            })
            ->get();
        $dataBimbingan = explode(";", $sidang->form_bimbingan);
        if (count($dataBimbingan) > 1) {
            $bimbingan1 = $dataBimbingan[0];
            $bimbingan2 = $dataBimbingan[1];
        } else {
            $bimbingan1 = "tidak ada data";
            $bimbingan2 = "tidak ada data";
        }
        if (empty($sidang)) {
            Flash::error('Sidang Tidak Ada');

            return redirect(route('sidangs.index'));
        }

        $makalah = DokumenLog::where('nama', $sidang->makalah)->first();
        $dokumen_ta = DokumenLog::where('nama', $sidang->dokumen_ta)->first();

        activity()
            ->causedBy(Auth::user())
            ->performedOn($sidang)
            ->log('Sidang:Show');

        return view('sidangs.show', compact('sidang', 'status_logs', 'bimbingan1', 'bimbingan2', 'makalah', 'dokumen_ta'));
    }

    /**
     * Show the form for editing the specified Sidang.
     *
     * @param int $id
     *
     * @return Response
     */
    public
    function edit($id)
    {
        $sidang = $this->sidangRepository->find($id);
        $lecturers = Lecturer::with('user')->orderBy('code')->get();
        $userInfo = $sidang->mahasiswa;
        $peminatans = Peminatan::where('kk', $userInfo->kk)->get();

        if (!Auth::user()->isSuperadmin()) {
            $status_logs = StatusLog::where('sidangs_id', $id)
                ->where(function ($query) {
                    $query->where('workflow_type', 'pengajuan')
                        ->orWhere('workflow_type', 'penjadwalan');
                })
                ->get();
        } else {
            $status_logs = StatusLog::where('sidangs_id', $id)
                ->get();
        }
        $period = Period::getPeriodNow();
        $allPeriod = Period::getAllPeriod();
        $languages = ['Indonesia', 'English'];
        $status_list = [
            '0' => '--Pilihan Ubah Status--',
            'ditolak oleh admin' => 'Ditolak Oleh Admin',
            'belum disetujui admin' => 'Belum Disetujui Admin',
            'telah disetujui admin' => 'Telah Disetujui Admin',
            'tidak lulus' => 'Tidak Lulus',
            'reset status' => 'Reset Status'
        ];
        $dataBimbingan = explode(";", $sidang->form_bimbingan);
        if (count($dataBimbingan) > 1) {
            $bimbingan1 = $dataBimbingan[0];
            $bimbingan2 = $dataBimbingan[1];
        } else {
            $bimbingan1 = "tidak ada data";
            $bimbingan2 = "tidak ada data";
        }
        if (empty($sidang)) {
            Flash::error('Sidang Tidak Ada');

            activity()
                ->causedBy(Auth::user())
                ->log('Sidang:Error_NotFound');

            return redirect(route('sidangs.index'));
        }

        $makalah = DokumenLog::where('nama', $sidang->makalah)->first();
        $dokumen_ta = DokumenLog::where('nama', $sidang->dokumen_ta)->first();

        if (!in_array($sidang->status, ['pengajuan', 'ditolak oleh admin']) && !Auth::user()->isSuperadmin())
            return redirect(route('sidangs.show', ['sidang' => $sidang->id]));

        activity()
            ->causedBy(Auth::user())
            ->performedOn($sidang)
            ->log('Sidang:Edit');

        return view('sidangs.edit', compact('peminatans', 'sidang', 'allPeriod', 'lecturers', 'period', 'userInfo', 'status_logs', 'bimbingan1', 'bimbingan2', 'makalah', 'dokumen_ta', 'languages', 'status_list'));
    }

    /**
     * Update the specified Sidang in storage.
     *
     * @param int $id
     * @param UpdateSidangRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSidangRequest $request)
    {
        $sidang = $this->sidangRepository->find($id);
        $input = $request->all();
        $userInfo = Auth::user();
        $student = $sidang->mahasiswa;

        //update peminatan
        Student::where('user_id', $student->id)
            ->update([
                'peminatan_id' => $request->peminatan
            ]);

        if (empty($sidang)) {
            Flash::error('Sidang Tidak Ada');

            activity()
                ->causedBy(Auth::user())
                ->log('Sidang:Error_NotFound');

            return redirect(route('sidangs.index'));
        }

        if ($input) {
            if ($input['pembimbing1_id'] == $input['pembimbing2_id']) {
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn($sidang)
                    ->log('Sidang:Error_Pembimbing_Same_Person');
                return redirect()->back()->withInput($input)->withErrors("pembimbing 1 dan pembimbing 2 tidak bisa sama");
            }

            $lecturer = Lecturer::find($input['pembimbing1_id']);
            if ($lecturer->jfa == 'NJFA') {
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn($sidang)
                    ->log('Sidang:Error_Pembimbing_Not_Eligible');
                return redirect()->back()->withInput($input)->withErrors("Pembimbing 1 harus JFA");
            }

            $this->validate($request, [
                'dokumen_ta' => 'mimes:pdf,doc,docx|max:5120',
                'makalah' => 'mimes:pdf,doc,docx|max:5120',
                'peminatan' => 'required'
            ]);

            if (!Auth::user()->isSuperadmin()) {
                //GetFile
                if ($request->file('dokumen_ta')) {
                    $dokumen_ta = $request->file('dokumen_ta');
                    $dokumen_ta_extension = $request->file('dokumen_ta')->extension();
                    $dokumen_ta_name = "draft_ta_" . $userInfo->username . "_" . date('Y-m-d_H-i-s') . "." . $dokumen_ta_extension;
                    $dokumen_ta->move('uploads/ta', $dokumen_ta_name);
                    $input['dokumen_ta'] = $dokumen_ta_name;
                    $input_dokumen = [
                        'sidang_id' => $id,
                        'nama' => $dokumen_ta_name,
                        'jenis' => 'draft',
                        'file_url' => 'uploads/ta/' . $dokumen_ta_name,
                        'created_by' => $userInfo->id,
                    ];
                    DokumenLog::create($input_dokumen);
                }

                //GetFile
                if ($request->file('makalah')) {
                    $makalah = $request->file('makalah');
                    $makalah_extension = $request->file('makalah')->extension();
                    $makalah_name = "draft_makalah_" . $userInfo->username . "_" . date('Y-m-d_H-i-s') . "." . $makalah_extension;
                    $makalah->move('uploads/makalah', $makalah_name);
                    $input['makalah'] = $makalah_name;

                    $input_makalah = [
                        'sidang_id' => $id,
                        'nama' => $makalah_name,
                        'jenis' => 'makalah',
                        'file_url' => 'uploads/makalah/' . $makalah_name,
                        'created_by' => $userInfo->id
                    ];
                    DokumenLog::create($input_makalah);
                }

                //Status kembali ke workflow awal
                $input['status'] = 'pengajuan';
                //Status pembimbing 1 dan 2 jika sudah setuju keduanya langsung ke admin saja
                if (!($sidang['status_pembimbing1'] == 'disetujui oleh pembimbing1' && $sidang['status_pembimbing2'] == 'disetujui oleh pembimbing2')) {
                    $input['status_pembimbing1'] = "";
                    $input['status_pembimbing2'] = "";

                    //Notif
                    $title = "Mahasiswa Edit Data Pengajuan Sidang";
                    $message = "Mahasiswa dengan nim " . $userInfo->username . " melakukan perubahan data daftar sidang";
                    $url = "/sidangs/pembimbing";

                    // $this->sendNotification(Lecturer::find($input['pembimbing1_id'])->code, $title, $message, $url);
                    // $this->sendNotification(Lecturer::find($input['pembimbing2_id'])->code, $title, $message, $url);

                    StatusLogController::addStatusLog($id, "Edit by Mahasiswa", "pengajuan", "pengajuan");
                } else {
                    //status by pass ke admin
                    $input['status'] = 'belum disetujui admin';
                    //Notif
                    $title = "Mahasiswa Edit Berkas Pengajuan Sidang";
                    $message = "Mahasiswa dengan nim " . $userInfo->username . " melakukan perubahan data daftar sidang";
                    $url = "/sidangs";

                    // foreach (\App\Models\User::getAdmin() as $admin) {
                    //     $this->sendNotification($admin->username, $title, $message, $url);
                    // }

                    activity()
                        ->causedBy(Auth::user())
                        ->performedOn($sidang)
                        ->log('Sidang:Update_Data');

                    StatusLogController::addStatusLog($id, "Edit by Mahasiswa", "pengajuan", "perbaikan berkas ke admin");
                }
            } else {
                //update dari superadmin
                if ($input['status'] != $sidang->status) {
                    if ($input['status'] == '0') {
                        $input['status'] = $sidang->status;
                    } elseif ($input['status'] == 'reset status') {
                        StatusLogController::addStatusLog($id, $input['komentar'], "Ubah Status", $input['status']);
                        //Notif
                        $title = "Status anda diperbaharui";
                        $message = "Status anda telah diperbaharui, silahkan lanjutkan proses revisi anda sesuai ketentuan";
                        $url = "/sidangs/show/".$sidang->id;

                        // $this->sendNotification($sidang->mahasiswa->user->username, $title, $message, $url);

                        $input['status'] = 'sudah dijadwalkan';

                        activity()
                            ->causedBy(Auth::user())
                            ->performedOn($sidang)
                            ->log('Sidang:Reset_Status');
                    } elseif ($input['status'] == 'tidak lulus') {
                        $team_id = $sidang->mahasiswa->team_id;
                        $count = Student::where('team_id', $team_id)
                            ->count();
                        Student::where('nim', $sidang->mahasiswa_id)->update([
                            'team_id' => 0,
                        ]);
                        if ($count <= 1) {
                            Team::where('id', $team_id)
                                ->delete();
                        }
                        StatusLogController::addStatusLog($id, $input['komentar'], "Ubah Status", $input['status']);
                        //Notif
                        $title = "Status anda diperbaharui";
                        $message = "Status anda telah diperbaharui, silahkan lakukan sidang ulang";
                        $url = "/sidangs/create";

                        // $this->sendNotification($sidang->mahasiswa->user->username, $title, $message, $url);

                        $input['status'] = 'tidak lulus';
                        activity()
                            ->causedBy(Auth::user())
                            ->performedOn($sidang)
                            ->log('Sidang:Change_Status_To_Tidak_Lulus');
                    }elseif ($input['status'] == 'lulus') {
                        StatusLogController::addStatusLog($id, $input['komentar'], "Ubah Status", $input['status']);
                        //Notif
                        $title = "Status anda diperbaharui";
                        $message = "Status anda telah diperbaharui menjadi lulus.";
                        $url = "/sidangs/show/".$sidang->id;

                        // $this->sendNotification($sidang->mahasiswa->user->username, $title, $message, $url);

                        $input['status'] = 'lulus';

                        activity()
                            ->causedBy(Auth::user())
                            ->performedOn($sidang)
                            ->log('Sidang:Change_Status_To_Lulus');
                    } elseif ($input['status'] == 'telah disetujui admin') {
                        $team_id = $sidang->mahasiswa->team_id;
                        $count = Student::where('team_id', $team_id)
                            ->count();
                        Student::where('nim', $sidang->mahasiswa_id)->update([
                            'team_id' => 0,
                        ]);
                        if ($count <= 1) {
                            Team::where('id', $team_id)
                                ->delete();
                        }
                        StatusLogController::addStatusLog($id, $input['komentar'], "Ubah Status", $input['status']);
                        //Notif
                        $title = "Status anda diperbaharui";
                        $message = "Status anda telah diperbaharui, silahkan lanjutkan proses dengan membuat tim";
                        $url = "/teams";

                        // $this->sendNotification($sidang->mahasiswa->user->username, $title, $message, $url);

                        activity()
                            ->causedBy(Auth::user())
                            ->performedOn($sidang)
                            ->log('Sidang:Change_Status_To_Approved');
                    } else {
                        StatusLogController::addStatusLog($id, $input['komentar'], "Ubah Status", $input['status']);
                        //Notif
                        $title = "Status anda diperbaharui";
                        $message = "Status anda telah diperbaharui menjadi " . $input['status'];
                        $url = "/sidangs/create";

                        activity()
                            ->causedBy(Auth::user())
                            ->performedOn($sidang)
                            ->log('Sidang:Change_Status');

                        // $this->sendNotification($sidang->mahasiswa->user->username, $title, $message, $url);
                    }
                }
            }


            $sidang = $this->sidangRepository->update($input, $id);
        }
        Flash::success('Sidang berhasil diedit');

        if (Auth::user()->isSuperadmin())
            return redirect(route('sidangs.indexAll'));
        else
            return redirect(route('sidangs.create'));
    }

    public function updateData($id)
    {
        $sidang = Sidang::find($id);
        $parameter = Parameter::find('periodAcademic');

        //request data from igracias
        $client = new \GuzzleHttp\Client(['verify' => false]);
        $response = $client->request('GET', config('app.api.getAllStudents') . '/' . $parameter->value . '/' . $sidang->mahasiswa_id);
        $dataStudent = json_decode($response->getBody());
        if ($dataStudent->data == null) {
            Flash::error('Mahasiswa tidak terdaftar di periode akademik ini');
            return redirect('/home');
        }

        $bimbingan1 = $dataStudent->data[0]->totalguidance_advisor1;
        $bimbingan2 = $dataStudent->data[0]->totalguidance_advisor2;
        $sks_lulus = $dataStudent->data[0]->credit_complete;
        $sks_belum_lulus = $dataStudent->data[0]->credit_uncomplete;

        if (empty($sidang)) {
            Flash::error('Sidang Tidak Ada');

            return redirect(route('sidangs.index'));
        }

        $sidang->credit_complete = $sks_lulus;
        $sidang->credit_uncomplete = $sks_belum_lulus;
        $sidang->form_bimbingan = $bimbingan1.";".$bimbingan2;

        Flash::success('Sidang berhasil diedit');

        activity()
            ->causedBy(Auth::user())
            ->log('Sidang:Updating_Data_From_Igracias');

        if (Auth::user()->isSuperadmin())
            return redirect(route('sidangs.indexAll'));
        else
            return redirect(route('sidangs.create'));
    }

    /**
     * Remove the specified Sidang from storage.
     *
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     *
     */
    public
    function destroy($id)
    {
        $sidang = $this->sidangRepository->find($id);

        if (empty($sidang)) {
            Flash::error('Sidang Tidak Ada');

            return redirect(route('sidangs.index'));
        }

        $this->sidangRepository->delete($id);

        Flash::success('Sidang Berhasil Dihapus.');

        return redirect(route('sidangs.index'));
    }

    public
    function feedbackSidang(Request $request, $id)
    {
        $feedback = $request->feedback;
        if ($feedback == null) {
            Flash::error('Feedback tidak boleh kosong');
            return redirect(route('sidangs.index'));
        }

        $sidang = Sidang::find($id);
        $sidang->update([
            'status' => 'ditolak oleh admin'
        ]);

        StatusLogController::addStatusLog($id, $feedback, 'pengajuan', 'ditolak oleh admin');

        $this->sendNotification(Sidang::find($id)->mahasiswa->nim
            , "Feedback"
            , "Berkas Anda Ditolak Admin, Silahkan Perbaiki Berkas Anda"
            , "/sidangs/create"
        );

        activity()
            ->causedBy(Auth::user())
            ->performedOn($sidang)
            ->log('Sidang:Reject_Submission');

        Flash::success('Feedback Sudah Dikirim');
        return redirect(route('sidangs.index'));
    }

    public
    function approveSidang(Request $request, $id)
    {
        $sidang = Sidang::find($id);
        $isEnglish = 0;
        if ($request->bahasa == 'inggris') {
            $isEnglish = 1;
        }
        $sidang->update([
            'status' => 'telah disetujui admin',
            'is_english' => $isEnglish
        ]);

        StatusLogController::addStatusLog($id, "-", 'pengajuan', 'telah disetujui admin');

        $this->sendNotification(Sidang::find($id)->mahasiswa->nim
            , "Approved"
            , "Sidang anda telah di approve admin, silahkan membuat team"
            , "/teams"
        );

        activity()
            ->causedBy(Auth::user())
            ->performedOn($sidang)
            ->log('Sidang:Approve_Submission');

        Flash::success('Berhasil di Disetujui');
        return redirect(route('sidangs.index'));
    }

    public
    function terimaPengajuan(Request $request, $id)
    {
        $feedback = $request->feedback;
        if ($feedback == null) {
            $feedback = "-";
        }

        $sidang = Sidang::find($id);
        $isPembimbing1 = $sidang->pembimbing1->user_id == Auth::user()->id;
        $resultAdd = StatusLogController::addStatusTerimaPengajuan($id, $feedback, 'pengajuan', $isPembimbing1); // abaikan
        if ($isPembimbing1) {
            $sidang->update([
                'status_pembimbing1' => 'disetujui oleh pembimbing1',
                'status' => $resultAdd
            ]);
        } else {
            $sidang->update([
                'status_pembimbing2' => 'disetujui oleh pembimbing2',
                'status' => $resultAdd
            ]);
        }

        $this->sendNotification(Sidang::find($id)->mahasiswa->nim
            , "Feedback"
            , "Pengajuan anda disetujui oleh Pembimbing"
            , "/sidangs/create"
        );

        //Give notification to all user as admin
        if ($resultAdd == 'belum disetujui admin') {
            $admins = Role::getAllAdmin();
            foreach ($admins as $admin) {
                $this->sendNotification($admin['username']
                    , "Pendaftaran baru"
                    , "Mahasiswa mengajukan Pendaftaran"
                    , "/sidangs/index"
                );
            }
        }

        Flash::success('Pengajuan Berhasil Disetujui');
        return redirect(route('sidangs.pembimbing'));
    }

    public
    function tolakPengajuan(Request $request, $id)
    {
        $feedback = $request->feedback;
        if ($feedback == null) {
            Flash::error('Komentar tidak boleh kosong');
            return redirect(route('sidangs.index'));
        }

        $sidang = Sidang::find($id);
        $isPembimbing1 = $sidang->pembimbing1->user_id == Auth::user()->id;
        $resultAdd = StatusLogController::addStatusTolakPengajuan($id, $feedback, 'pengajuan', $isPembimbing1);
        if ($isPembimbing1) {
            $sidang->update([
                'status' => 'pengajuan',
                'status_pembimbing1' => 'ditolak oleh pembimbing1',
            ]);
        } else {
            $sidang->update([
                'status' => 'pengajuan',
                'status_pembimbing2' => 'ditolak oleh pembimbing2',
            ]);
        }

        $this->sendNotification(Sidang::find($id)->mahasiswa->nim
            , "Pengajuan Sidang"
            , "Pengajuan anda ditolak oleh Pembimbing"
            , "/sidangs/create"
        );

        Flash::success('Pengajuan Berhasil Ditolak');
        return redirect(route('sidangs.pembimbing'));
    }

    public
    function updateSidangUlang(Request $request, $id)
    {
        $sidang = $this->sidangRepository->find($id);
        $input = $request->all();
        $userInfo = Auth::user();

        if (empty($sidang)) {
            Flash::error('Sidang Tidak Ada');
            return redirect(route('sidangs.index'));
        }

        if ($input) {
            $this->validate($request, [
                'dokumen_ta' => 'mimes:pdf,doc,docx|max:5120',
                'makalah' => 'mimes:pdf,doc,docx|max:5120',
                'period_id' => 'required'
            ]);
            //GetFile
            if ($request->file('dokumen_ta')) {
                $dokumen_ta = $request->file('dokumen_ta');
                $dokumen_ta_extension = $request->file('dokumen_ta')->extension();
                $dokumen_ta_name = "draft_ta_" . $userInfo->username . "_" . date('Y-m-d_H-i-s') . "." . $dokumen_ta_extension;
                $dokumen_ta->move('uploads/ta', $dokumen_ta_name);
                $input['dokumen_ta'] = $dokumen_ta_name;
                $input_dokumen = [
                    'sidang_id' => $id,
                    'nama' => $dokumen_ta_name,
                    'jenis' => 'draft',
                    'file_url' => 'uploads/ta/' . $dokumen_ta_name,
                    'created_by' => $userInfo->id,
                ];
                DokumenLog::create($input_dokumen);
            }

            //GetFile
            if ($request->file('makalah')) {
                $makalah = $request->file('makalah');
                $makalah_extension = $request->file('makalah')->extension();
                $makalah_name = "draft_makalah_" . $userInfo->username . "_" . date('Y-m-d_H-i-s') . "." . $makalah_extension;
                $makalah->move('uploads/makalah', $makalah_name);
                $input['makalah'] = $makalah_name;

                $input_makalah = [
                    'sidang_id' => $id,
                    'nama' => $makalah_name,
                    'jenis' => 'makalah',
                    'file_url' => 'uploads/makalah/' . $makalah_name,
                    'created_by' => $userInfo->id
                ];
                DokumenLog::create($input_makalah);
            }

            if ($sidang->status == 'tidak lulus' || $sidang->status == "tidak lulus (sudah update dokumen)") {
                $input['status'] = "tidak lulus (sudah update dokumen)";
            } else {
                $input['status'] = "tidak lulus (belum dijadwalkan)";
            }

            $sidang = $this->sidangRepository->update($input, $id);
            StatusLogController::addStatusLog($id, "-", "pengajuan", "tidak lulus (sudah update dokumen)");
        }

        activity()
            ->causedBy(Auth::user())
            ->log('Sidang:Create_Sidang_Ulang');

        Flash::success('Sidang berhasil diedit, jangan lupa update slide dan membuat team baru');
        return redirect(route('slides.index'));
    }

}
