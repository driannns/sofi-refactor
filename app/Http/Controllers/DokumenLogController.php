<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDokumenLogRequest;
use App\Http\Requests\UpdateDokumenLogRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\DokumenLog;
use App\Models\Sidang;
use App\Models\Period;
use Illuminate\Http\Request;
use Flash;
use Response;
use Auth;
use Storage;

class DokumenLogController extends AppBaseController
{
    /**
     * Display a listing of the DokumenLog.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        /** @var DokumenLog $dokumenLogs */
        $dokumenLogs = DokumenLog::all();

        return view('dokumen_logs.index')
            ->with('dokumenLogs', $dokumenLogs);
    }

    /**
     * Show the form for creating a new DokumenLog.
     *
     * @return Response
     */
    public function create()
    {
        return view('dokumen_logs.create');
    }

    /**
     * Store a newly created DokumenLog in storage.
     *
     * @param CreateDokumenLogRequest $request
     *
     * @return Response
     */
    public function store(CreateDokumenLogRequest $request)
    {
        $input = $request->all();

        /** @var DokumenLog $dokumenLog */
        $dokumenLog = DokumenLog::create($input);

        Flash::success('Dokumen Log Berhasil Disimpan.');

        return redirect(route('dokumenLogs.index'));
    }

    /**
     * Display the specified DokumenLog.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var DokumenLog $dokumenLog */
        $dokumenLog = DokumenLog::find($id);

        if (empty($dokumenLog)) {
            Flash::error('Dokumen Log Tidak DItemukan');

            return redirect(route('dokumenLogs.index'));
        }

        return view('dokumen_logs.show')->with('dokumenLog', $dokumenLog);
    }

    /**
     * Show the form for editing the specified DokumenLog.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var DokumenLog $dokumenLog */
        $dokumenLog = DokumenLog::find($id);

        if (empty($dokumenLog)) {
            Flash::error('Dokumen Log Tidak DItemukan');

            return redirect(route('dokumenLogs.index'));
        }

        return view('dokumen_logs.edit')->with('dokumenLog', $dokumenLog);
    }

    /**
     * Update the specified DokumenLog in storage.
     *
     * @param int $id
     * @param UpdateDokumenLogRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDokumenLogRequest $request)
    {
        /** @var DokumenLog $dokumenLog */
        $dokumenLog = DokumenLog::find($id);

        if (empty($dokumenLog)) {
            Flash::error('Dokumen Log Tidak DItemukan');

            return redirect(route('dokumenLogs.index'));
        }

        $dokumenLog->fill($request->all());
        $dokumenLog->save();

        Flash::success('Dokumen Log Berhasil Di Ubah.');

        return redirect(route('dokumenLogs.index'));
    }

    /**
     * Remove the specified DokumenLog from storage.
     *
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        /** @var DokumenLog $dokumenLog */
        $dokumenLog = DokumenLog::find($id);

        if (empty($dokumenLog)) {
            Flash::error('Dokumen Log Tidak DItemukan');

            return redirect(route('dokumenLogs.index'));
        }

        $dokumenLog->delete();

        Flash::success('Dokumen Log Berhasil Dihapus.');

        return redirect(route('dokumenLogs.index'));
    }

    public function slide()
    {
        $periods = Period::getPeriodNow();
        $oldPeriod = null;
        $sidang = Sidang::where('mahasiswa_id', Auth::user()->student->nim)
            ->orderBy('id', 'desc')
            ->first();

        if (empty($sidang)) {
            return redirect()->back()->withError('Anda belum mendaftar sidang!');
        }

        if ($sidang->status == 'sudah dijadwalkan' || $sidang->status == 'tidak lulus (sudah dijadwalkan)') {
            Flash::warning('Sidang anda sudah dijadwalkan, tidak dapat merubah file presentasi');
            return redirect(route('schedule.mahasiswa'));
        }

        //status apa aja yang bisa buka update slide
        if ($sidang->status != "telah disetujui admin" &&
            $sidang->status != "belum dijadwalkan" &&
            $sidang->status != "tidak lulus" &&
            $sidang->status != "tidak lulus (sudah update dokumen)" &&
            $sidang->status != "tidak lulus (belum dijadwalkan)") {
            return redirect()->back()
                ->withError('Sidang anda belum di approve dosen pembimbing dan admin');
        }

        $slide = DokumenLog::where('sidang_id', $sidang->id)
            ->where('jenis', 'slide')
            ->orderBy('id', 'desc')
            ->first();

        if($sidang->status == 'tidak lulus')
        {
            $oldPeriod = $sidang->period->id;
            $periods = Period::where('id',$oldPeriod)->pluck('name','id');
        }

        return view('powerpoints.index')->with([
            'slide' => $slide,
            'sidang' => $sidang,
            'periods' => $periods,
            'oldPeriod' => $oldPeriod,
        ]);

    }

    public function slide_upload(Request $request)
    {
        $userInfo = Auth::user();

        if ($request->file('slide')->getClientOriginalExtension() == 'ppt'
            or $request->file('slide')->getClientOriginalExtension() == 'pptx') {
            $this->validate($request, [
                'slide' => 'required|max:10240',
            ]);
        } else {
            return redirect()->back()->withError('File anda bukan ppt ataupun pptx');
        }

        //GetFile
        $slide = $request->file('slide');
        $slide_extension = $request->file('slide')->extension();
        if ($slide_extension == null) {
            $slide_extension = "ppt";
        }
        $slide_name = "slide_" . $userInfo->username . "_" . date('Y-m-d_H-i-s');
        $slide->move('uploads/slide', $slide_name . "." . $slide_extension);

        $input_slide = [
            'sidang_id' => $request->sidang_id,
            'nama' => $slide_name,
            'jenis' => 'slide',
            'file_url' => 'uploads/slide/' . $slide_name . "." . $slide_extension,
            'created_by' => $userInfo->id
        ];
        DokumenLog::create($input_slide);

        Flash::success('Berhasil mengupload slide presentasi, silahkan buat team jika belum membuat team. PERHATIAN : Slide presentasi dapat diubah sebelum sidang anda telah dijadwalkan!');
        return redirect(route('slides.index'));

    }

    public function updateExtension()
    {
        $documents = DokumenLog::all();
        foreach ($documents as $document) {
            if ((substr($document->file_url, -4) != '.pdf') and
                (substr($document->file_url, -4) != '.doc') and
                (substr($document->file_url, -4) != '.ppt') and
                (substr($document->file_url, -5) != '.docx') and
                (substr($document->file_url, -5) != '.pptx')) {
                $url = $document->file_url;
                DokumenLog::where('file_url', $url)->update([
                    'file_url' => $url . ".docx",
                ]);
                rename(public_path('uploads/ta/' . $document->nama), public_path('uploads/ta/' . $document->nama . '.docx'));
            }
        }
        dd('berhasil');
    }

}
