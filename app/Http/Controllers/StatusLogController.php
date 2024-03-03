<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateStatusLogRequest;
use App\Http\Requests\UpdateStatusLogRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\StatusLog;
use App\Models\User;
use Illuminate\Http\Request;
use Flash;
use Response;
use Auth;

class StatusLogController extends AppBaseController
{
    /**
     * Display a listing of the StatusLog.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        /** @var StatusLog $statusLogs */
        $statusLogs = StatusLog::all();

        return view('status_logs.index')
            ->with('statusLogs', $statusLogs);
    }

    /**
     * Show the form for creating a new StatusLog.
     *
     * @return Response
     */
    public function create()
    {
        return view('status_logs.create');
    }

    /**
     * Store a newly created StatusLog in storage.
     *
     * @param CreateStatusLogRequest $request
     *
     * @return Response
     */
    public function store(CreateStatusLogRequest $request)
    {
        $input = $request->all();

        /** @var StatusLog $statusLog */
        $statusLog = StatusLog::create($input);

        Flash::success('Status Log saved successfully.');

        return redirect(route('statusLogs.index'));
    }

    /**
     * Display the specified StatusLog.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var StatusLog $statusLog */
        $statusLog = StatusLog::find($id);

        if (empty($statusLog)) {
            Flash::error('Status Log not found');

            return redirect(route('statusLogs.index'));
        }

        return view('status_logs.show')->with('statusLog', $statusLog);
    }

    /**
     * Show the form for editing the specified StatusLog.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var StatusLog $statusLog */
        $statusLog = StatusLog::find($id);

        if (empty($statusLog)) {
            Flash::error('Status Log not found');

            return redirect(route('statusLogs.index'));
        }

        return view('status_logs.edit')->with('statusLog', $statusLog);
    }

    /**
     * Update the specified StatusLog in storage.
     *
     * @param int $id
     * @param UpdateStatusLogRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateStatusLogRequest $request)
    {
        /** @var StatusLog $statusLog */
        $statusLog = StatusLog::find($id);

        if (empty($statusLog)) {
            Flash::error('Status Log not found');

            return redirect(route('statusLogs.index'));
        }

        $statusLog->fill($request->all());
        $statusLog->save();

        Flash::success('Status Log updated successfully.');

        return redirect(route('statusLogs.index'));
    }

    /**
     * Remove the specified StatusLog from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var StatusLog $statusLog */
        $statusLog = StatusLog::find($id);

        if (empty($statusLog)) {
            Flash::error('Status Log not found');

            return redirect(route('statusLogs.index'));
        }

        $statusLog->delete();

        Flash::success('Status Log deleted successfully.');

        return redirect(route('statusLogs.index'));
    }

    public static function addStatusLog($sidangId,$feedback,$workflow_type,$name)
    {
        if(Auth::user() == null){
            $user_id = User::where('username','admin')->first()->id;
        }else
            $user_id = Auth::user()->id;

        return StatusLog::create([
            'sidangs_id' => $sidangId,
            'feedback' => $feedback,
            'workflow_type' => $workflow_type,
            'name' => $name,
            'created_by' => $user_id
        ]);
    }

    public static function addStatusTerimaPengajuan($sidang_id,$feedback,$workflow_type,$isPembimbing1)
    {
        $statusLog = StatusLog::orderBy('id', 'desc')->take(1)->get();
        
        //cek Status Approval kedua pembimbing
        $isSetuju = false;
        foreach ($statusLog as $value) {
            if( ($value['name'] == 'disetujui oleh pembimbing1') || ($value['name'] == 'disetujui oleh pembimbing2')  )
                $isSetuju = true;
        }

        $result = false;
        if($isPembimbing1)
            $result = self::addStatusLog($sidang_id,$feedback,$workflow_type,"disetujui oleh pembimbing1");
        else
            $result = self::addStatusLog($sidang_id,$feedback,$workflow_type,"disetujui oleh pembimbing2");
        if($isSetuju)
            $result = self::addStatusLog($sidang_id,$feedback,$workflow_type,"belum disetujui admin");

        return $result->name;
    }

    public static function addStatusTolakPengajuan($sidang_id,$feedback,$workflow_type,$isPembimbing1)
    {
        $statusLog = StatusLog::orderBy('id', 'desc')->take(1)->get();
        $result = false;
        if($isPembimbing1)
            $result = self::addStatusLog($sidang_id,$feedback,$workflow_type,"ditolak oleh pembimbing1");
        else
            $result = self::addStatusLog($sidang_id,$feedback,$workflow_type,"ditolak oleh pembimbing2");

        return $result->name;
    }


}
