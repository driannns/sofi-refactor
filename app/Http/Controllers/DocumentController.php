<?php

namespace App\Http\Controllers;

use App\Exports\CumlaudeExport;
use App\Exports\JadwalSidangExport;
use App\Exports\LulusTepatWaktuExport;
use App\Http\Controllers\AppBaseController;
use App\Exports\PendaftarSidangExport;
use App\Exports\YudisiumExport;
use App\Models\Revision;
use App\Models\ScorePortion;
use App\Models\StudyProgram;
use App\Models\Verify_document;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\CLO;
use App\Models\Score;
use App\Models\Attendance;
use App\Models\Lecturer;
use App\Models\Sidang;
use App\Models\DokumenLog;
use App\Models\Period;
use Carbon\Carbon;
use Excel;
use Illuminate\Database\Eloquent\Collection;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

//pdf
use PDF;
use Illuminate\Support\Facades\Storage;

class DocumentController extends AppBaseController
{
    public $onlyGetData = false; //buat get data cetak_semua

    public function index()
    {
        $sidangs = Sidang::whereIn('status', ['lulus', 'tidak lulus', 'lulus bersyarat'])
            ->orWhere(function ($query) {
                $query->whereHas('schedules', function ($query) {
                    $query->whereIn('status', ['telah dilaksanakan', 'lulus']);
                });
            })
            ->get();

        $documents = DokumenLog::all();

        return view('documents.index', compact('sidangs', 'documents'));
    }

    public function berita_acara($schedule_id, Request $request)
    {
        $isPrint = !empty($request->query('print'));
        $schedule = Schedule::find($schedule_id);
        $sn_document = $this->generateSN($schedule->sidang->mahasiswa->nim);
        $inputData = [
            'serial_number' => $sn_document,
            'perihal' => 'berita acara',
            'nim' => $schedule->sidang->mahasiswa->nim,
            'created_by' => Auth()->user()->id
        ];
        $verify_doc = Verify_documentController::simpanData($inputData);
        if ($this->onlyGetData) {
            return compact('sn_document');
        } else {
            return view('documents.berita_acara', ['schedule' => $schedule, 'isPrint' => $isPrint, 'sn_document' => $sn_document]);
        }

    }
    //berita_acara_unduh
    //berita_acara_unduh
    public function berita_acara_unduh($schedule_id, Request $request)
    {
        $isPrint = !empty($request->query('print'));
        $schedule = Schedule::find($schedule_id);
        $sn_document = $this->generateSN($schedule->sidang->mahasiswa->nim);
        $inputData = [
            'serial_number' => $sn_document,
            'perihal' => 'berita acara',
            'nim' => $schedule->sidang->mahasiswa->nim,
            'created_by' => Auth()->user()->id
        ];
        $verify_doc = Verify_documentController::simpanData($inputData);
        if ($this->onlyGetData) {
            return compact('sn_document');
        } else {
            $path = 'images/telkom.png';
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $logo = 'data:image/' . $type . ';base64,' . base64_encode($data);
            // return view('documents.berita_acara',['schedule'=>$schedule,'isPrint'=>$isPrint,'sn_document' => $sn_document]);
            $qrcode = QrCode::size(100)->generate(\Illuminate\Support\Facades\URL::to('/doc_verify/' . $sn_document));
            // $gbrqrcode = 'data:image/' . $type . ';base64,' .$qrcode2;

            $pdf = PDF::loadView('documents.download_berita_acara', compact('schedule', 'isPrint', 'sn_document', 'logo', 'qrcode'))->setOptions(['defaultFont' => 'sans-serif']);
            $pdf->setPaper('legal', 'potrait');
            // Render the HTML as PDF
            // $pdf->render();
            $pdf->stream();
            //  return $pdf->stream('pdfview.pdf');

            return $pdf->download('berita-acara.pdf');

            //   $pdf = PDF::loadView('admin.order.download-invoice',[
            //     'order'=> $order,
            //     'customer'=>$customer,
            //     'shipping'=>$shipping,
            //     'orderDetails'=>$orderDetails
            // ]);
        }

    }

    public function nilai_sidang($schedule_id, Request $request)
    {
        $isPrint = !empty($request->query('print'));
        $schedule = Schedule::find($schedule_id);
        $studyProgram = $schedule->sidang->mahasiswa->study_program;
        $studyProgramId = StudyProgram::where('name', $studyProgram)->first()->id;
        $nilaiPenguji1 = 0;
        $nilaiPenguji2 = 0;
        $nilaiPembimbing1 = 0;
        $nilaiPembimbing2 = 0;
        $totalPercentagePenguji1 = 0;
        $totalPercentagePenguji2 = 0;
        $totalPercentagePembimbing1 = 0;
        $totalPercentagePembimbing2 = 0;
        foreach ($schedule->scores as $score) {
            if ($score->isPenguji1()) {
                $nilaiPenguji1 = $nilaiPenguji1 + ($score->percentage * ($score->value));
                $totalPercentagePenguji1 = $totalPercentagePenguji1 + $score->percentage;
            } else if ($score->isPenguji2()) {
                $nilaiPenguji2 = $nilaiPenguji2 + ($score->percentage * ($score->value));
                $totalPercentagePenguji2 = $totalPercentagePenguji2 + $score->percentage;
            } else if ($score->isPembimbing1()) {
                $nilaiPembimbing1 = $nilaiPembimbing1 + ($score->percentage * ($score->value));
                $totalPercentagePembimbing1 = $totalPercentagePembimbing1 + $score->percentage;
            } else if ($score->isPembimbing2()) {
                $nilaiPembimbing2 = $nilaiPembimbing2 + ($score->percentage * ($score->value));
                $totalPercentagePembimbing2 = $totalPercentagePembimbing2 + $score->percentage;
            }
        }
        if ($totalPercentagePenguji1 != 0 and $totalPercentagePenguji2 != 0 and
            $totalPercentagePembimbing1 != 0 and $totalPercentagePembimbing2 != 0) {
            $nilaiPenguji1 = $nilaiPenguji1 / $totalPercentagePenguji1;
            $nilaiPenguji2 = $nilaiPenguji2 / $totalPercentagePenguji2;
            $nilaiPembimbing1 = $nilaiPembimbing1 / $totalPercentagePembimbing1;
            $nilaiPembimbing2 = $nilaiPembimbing2 / $totalPercentagePembimbing2;
        } else {
            return "pembimbing dan penguji ada yang belum input nilai";
        }


        $porsi_nilai = ScorePortion::where('period_id', $schedule->sidang->period_id)->where('study_program_id', $studyProgramId)->first();

        if ($porsi_nilai) {
            $nilaiTotal = ($porsi_nilai->pembimbing * (($nilaiPembimbing1 + $nilaiPembimbing2) / 2) / 100) + ($porsi_nilai->penguji * (($nilaiPenguji1 + $nilaiPenguji2) / 2) / 100);
        } else {
            $nilaiTotal = (60 * (($nilaiPembimbing1 + $nilaiPembimbing2) / 2) / 100) + (40 * (($nilaiPenguji1 + $nilaiPenguji2) / 2) / 100);
        }

        $indeks = "";
        if ($nilaiTotal > 80) {
            $indeks = "A";
        } else if ($nilaiTotal > 70) {
            $indeks = "AB";
        } else if ($nilaiTotal > 65) {
            $indeks = "B";
        } else if ($nilaiTotal > 60) {
            $indeks = "BC";
        } else if ($nilaiTotal > 50) {
            $indeks = "C";
        } else if ($nilaiTotal > 40) {
            $indeks = "D";
        } else {
            $indeks = "E";
        }

        $sn_document = $this->generateSN($schedule->sidang->mahasiswa->nim);
        $inputData = [
            'serial_number' => $sn_document,
            'perihal' => 'lembar nilai sidang',
            'nim' => $schedule->sidang->mahasiswa->nim,
            'created_by' => Auth()->user()->id
        ];
        $verify_doc = Verify_documentController::simpanData($inputData);

        if ($this->onlyGetData) {
            return compact('nilaiPenguji1', 'nilaiPenguji2', 'nilaiPembimbing1', 'nilaiPembimbing2', 'nilaiTotal', 'indeks', 'sn_document','porsi_nilai');
        } else {
            return view('documents.nilai_sidang', compact(
                'nilaiPenguji1',
                'nilaiPenguji2',
                'nilaiPembimbing1',
                'nilaiPembimbing2',
                'nilaiTotal',
                'indeks',
                'schedule_id',
                'schedule',
                'isPrint',
                'sn_document',
                'porsi_nilai'
            ));
        }

    }

    public function form_nilai_penguji($period_id, $schedule_id, $penguji, Request $request, $prodi_id)
    {
        $isPrint = !empty($request->query('print'));
        $clos = CLO::where('period_id', $period_id)->where('study_program_id', $prodi_id)->get();
        $schedule = Schedule::find($schedule_id);
        $scores = null;
        $lecturer = null;
        if ($penguji == 1) {
            $scores = Score::where('jadwal_id', $schedule_id)
                ->where('user_id', $schedule->detailpenguji1->id)
                ->get();
            $lecturer = Lecturer::find($schedule->detailpenguji1->id);
        } else if ($penguji == 2) {
            $scores = Score::where('jadwal_id', $schedule_id)
                ->where('user_id', $schedule->detailpenguji2->id)
                ->get();
            $lecturer = Lecturer::find($schedule->detailpenguji2->id);
        } else {
            return "Penguji tidak ditemukan";
        }

        $sn_document = $this->generateSN($schedule->sidang->mahasiswa->nim);
        $inputData = [
            'serial_number' => $sn_document,
            'perihal' => 'form nilai penguji',
            'nim' => $schedule->sidang->mahasiswa->nim,
            'created_by' => Auth()->user()->id
        ];
        $verify_doc = Verify_documentController::simpanData($inputData);

        if ($this->onlyGetData) {
            return compact('clos', 'scores', 'lecturer', 'sn_document');
        } else {
            return view('documents.form_nilai_penguji')
                ->with([
                    'clos' => $clos,
                    'scores' => $scores,
                    'isPrint' => $isPrint,
                    'lecturer' => $lecturer,
                    'sn_document' => $sn_document
                ]);
        }

    }

    public function form_nilai_pembimbing($period_id, $schedule_id, $pembimbing, Request $request, $prodi_id)
    {
        $isPrint = !empty($request->query('print'));
        $clos = CLO::where('period_id', $period_id)->where('study_program_id', $prodi_id)->get();
        $schedule = Schedule::find($schedule_id);
        $scores = null;
        $lecturer = null;
        if ($pembimbing == 1) {
            $scores = Score::where('jadwal_id', $schedule_id)
                ->where('user_id', $schedule->sidang->pembimbing1->id)
                ->get();
            $lecturer = Lecturer::find($schedule->sidang->pembimbing1->id);
        } else if ($pembimbing == 2) {
            $scores = Score::where('jadwal_id', $schedule_id)
                ->where('user_id', $schedule->sidang->pembimbing2->id)
                ->get();
            $lecturer = Lecturer::find($schedule->sidang->pembimbing2->id);
        } else {
            return "Pembimbing tidak ditemukan";
        }
        $sn_document = $this->generateSN($schedule->sidang->mahasiswa->nim);
        $inputData = [
            'serial_number' => $sn_document,
            'perihal' => 'form nilai pembimbing',
            'nim' => $schedule->sidang->mahasiswa->nim,
            'created_by' => Auth()->user()->id
        ];
        $verify_doc = Verify_documentController::simpanData($inputData);

        return view('documents.form_nilai_pembimbing')
            ->with([
                'clos' => $clos,
                'scores' => $scores,
                'isPrint' => $isPrint,
                'lecturer' => $lecturer,
                'sn_document' => $sn_document
            ]);
    }

    public function daftar_hadir($schedule_id, Request $request)
    {
        $isPrint = !empty($request->query('print'));
        $attendances = Attendance::where('schedule_id', $schedule_id)->get();

        $schedule = Schedule::find($schedule_id);
        $sn_document = $this->generateSN($schedule->sidang->mahasiswa->nim);
        $inputData = [
            'serial_number' => $sn_document,
            'perihal' => 'daftar hadir',
            'nim' => $schedule->sidang->mahasiswa->nim,
            'created_by' => Auth()->user()->id
        ];
        $verify_doc = Verify_documentController::simpanData($inputData);

        if ($this->onlyGetData) {
            return compact('attendances', 'sn_document');
        } else {
            return view('documents.daftar_hadir')
                ->with([
                    'attendances' => $attendances,
                    'isPrint' => $isPrint,
                    'sn_document' => $sn_document
                ]);
        }

    }

    public function revisi($schedule_id, Request $request)
    {
        $isPrint = !empty($request->query('print'));
        $schedule = Schedule::find($schedule_id);
        $revisions_ta = Revision::where([['schedule_id', $schedule_id]])->whereHas('dokumen', function ($q) {
            $q->where('jenis', 'draft');
        })->get();
        $revisions_makalah = Revision::where([['schedule_id', $schedule_id]])->whereHas('dokumen', function ($q) {
            $q->where('jenis', 'makalah');
        })->get();
        $sn_document = $this->generateSN($schedule->sidang->mahasiswa->nim);
        $inputData = [
            'serial_number' => $sn_document,
            'perihal' => 'lembar revisi',
            'nim' => $schedule->sidang->mahasiswa->nim,
            'created_by' => Auth()->user()->id
        ];
        $verify_doc = Verify_documentController::simpanData($inputData);

        if ($this->onlyGetData) {
            return compact('revisions_ta', 'revisions_makalah', 'sn_document');
        } else {
            return view('documents.revisi', compact('schedule', 'revisions_ta', 'revisions_makalah', 'isPrint', 'sn_document'));
        }

    }

    public function cetak_semua($schedule_id, $period_id, Request $request)
    {
        $isPrint = !empty($request->query('print'));
        $schedule = Schedule::find($schedule_id);
        if ($schedule) {
            $prodiMahasiswaName = $schedule->sidang->mahasiswa->study_program;
            $prodiMahasiswa = StudyProgram::where('name', $prodiMahasiswaName)->first();
        } else {
            return redirect()->back()->withErrors([
                'error' => 'Jadwal tidak ditemukan'
            ]);
        }
        $this->onlyGetData = true;
        $postRequest = new Request();
        $postRequest['print'] = false;

        //Get Data
        $berita_acara = self::berita_acara($schedule_id, $postRequest);
        $revisi = self::revisi($schedule_id, $postRequest);
        $penguji_1 = self::form_nilai_penguji($period_id, $schedule_id, 1, $postRequest, $prodiMahasiswa->id);
        $penguji_2 = self::form_nilai_penguji($period_id, $schedule_id, 2, $postRequest, $prodiMahasiswa->id);
        $pembimbing_1 = self::form_nilai_pembimbing($period_id, $schedule_id, 1, $postRequest, $prodiMahasiswa->id);
        $pembimbing_2 = self::form_nilai_pembimbing($period_id, $schedule_id, 2, $postRequest, $prodiMahasiswa->id);
        $nilai_sidang = self::nilai_sidang($schedule_id, $postRequest);
        $daftar_hadir = self::daftar_hadir($schedule_id, $postRequest);


        return view('documents.cetak_semua',
            ['isPrint' => $isPrint, 'schedule' => $schedule,
                'sn_document_berita_acara' => $berita_acara['sn_document'],
                'revisions_ta' => $revisi['revisions_ta'], 'revisions_makalah' => $revisi['revisions_makalah'], 'sn_document_revisi' => $revisi['sn_document'],
                'clos_penguji_1' => $penguji_1['clos'], 'scores_penguji_1' => $penguji_1['scores'], 'lecturer_penguji_1' => $penguji_1['lecturer'], 'sn_document_form_nilai_penguji_1' => $penguji_1['sn_document'],
                'clos_penguji_2' => $penguji_2['clos'], 'scores_penguji_2' => $penguji_2['scores'], 'lecturer_penguji_2' => $penguji_2['lecturer'], 'sn_document_form_nilai_penguji_2' => $penguji_2['sn_document'],
                'clos_pembimbing_1' => $pembimbing_1['clos'], 'scores_pembimbing_1' => $pembimbing_1['scores'], 'lecturer_pembimbing_1' => $pembimbing_1['lecturer'], 'sn_document_form_nilai_pembimbing_1' => $pembimbing_1['sn_document'],
                'clos_pembimbing_2' => $pembimbing_2['clos'], 'scores_pembimbing_2' => $pembimbing_2['scores'], 'lecturer_pembimbing_2' => $pembimbing_2['lecturer'], 'sn_document_form_nilai_pembimbing_2' => $pembimbing_2['sn_document'],
                'nilaiPenguji1' => $nilai_sidang['nilaiPenguji1'], 'nilaiPenguji2' => $nilai_sidang['nilaiPenguji2'], 'nilaiPembimbing1' => $nilai_sidang['nilaiPembimbing1'], 'nilaiPembimbing2' => $nilai_sidang['nilaiPembimbing2'], 'nilaiTotal' => $nilai_sidang['nilaiTotal'], 'indeks' => $nilai_sidang['indeks'], 'sn_document_nilai_sidang' => $nilai_sidang['sn_document'], 'porsi_nilai' => $nilai_sidang['porsi_nilai'],
                'attendances' => $daftar_hadir['attendances'], 'sn_document_daftar_hadir' => $daftar_hadir['sn_document']]);
    }

    public function generateSN($nim)
    {
        $token = $this->getToken(6, $nim);
        $code = 'FRI' . $token . time();
        return $code;
    }

    private function getToken($length, $seed)
    {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet .= "0123456789";

        mt_srand($seed);      // Call once. Good since $application_id is unique.

        for ($i = 0; $i < $length; $i++) {
            $token .= $codeAlphabet[mt_rand(0, strlen($codeAlphabet) - 1)];
        }
        return $token;
    }

    public function exportIndex()
    {
        $periods = Period::all();
        return view('exports.index', compact('periods'));
    }

    public function exportDocument(Request $request)
    {

        $this->validate($request, [
            'berdasarkan' => 'required',
            'jenis_dokumen' => 'required',
        ]);

        if ($request->berdasarkan == 'range') {
            $this->validate($request, [
                'tanggal_awal' => 'required',
                'tanggal_akhir' => 'required',
            ]);

            $tanggal_awal = Carbon::parse($request->tanggal_awal);
            $tanggal_akhir = Carbon::parse($request->tanggal_akhir);

            if ($tanggal_awal > $tanggal_akhir) {
                return redirect()->back()->withErrors([
                    'error' => 'Tanggal bermasalah'
                ]);
            }
        }

        $jenis_dokumen = $request->jenis_dokumen;

        if ($jenis_dokumen == "pendaftar_sidang") {

            if ($request->berdasarkan == 'range') {
                return Excel::download(new PendaftarSidangExport(null, $tanggal_awal, $tanggal_akhir), 'pendaftarsidang.xlsx');
            } else {
                return Excel::download(new PendaftarSidangExport($request->period_id, null, null), 'pendaftarsidang.xlsx');
            }

        } elseif ($jenis_dokumen == "jadwal_sidang") {

            if ($request->berdasarkan == 'range') {
                return Excel::download(new JadwalSidangExport(null, $tanggal_awal, $tanggal_akhir), 'jadwalsidang.xlsx');
            } else {
                return Excel::download(new JadwalSidangExport($request->period_id, null, null), 'jadwalsidang.xlsx');
            }

        } elseif ($jenis_dokumen == "sidang_yudisium") {

            if ($request->berdasarkan == 'range') {
                return Excel::download(new YudisiumExport(null, $tanggal_awal, $tanggal_akhir), 'yudisium.xlsx');
            } else {
                return Excel::download(new YudisiumExport($request->period_id, null, null), 'yudisium.xlsx');
            }

        } elseif ($jenis_dokumen == "tepat_waktu") {

            if ($request->berdasarkan == 'range') {
                return Excel::download(new LulusTepatWaktuExport(null, $tanggal_awal, $tanggal_akhir), 'lulus-tepat-waktu.xlsx');
            } else {
                return Excel::download(new LulusTepatWaktuExport($request->period_id, null, null), 'lulus-tepat-waktu.xlsx');
            }

        } elseif ($jenis_dokumen == "cumlaude") {
            if ($request->berdasarkan == 'range') {
                return Excel::download(new CumlaudeExport(null, $tanggal_awal, $tanggal_akhir), 'cumlaude.xlsx');
            } else {
                return Excel::download(new CumlaudeExport($request->period_id, null, null), 'cumlaude.xlsx');
            }
        }
    }
}
