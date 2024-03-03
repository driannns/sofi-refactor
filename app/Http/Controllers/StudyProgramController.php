<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateStudyProgramRequest;
use App\Http\Requests\UpdateStudyProgramRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\StudyProgram;
use Illuminate\Http\Request;
use Flash;
use Response;

class StudyProgramController extends AppBaseController
{
    /**
     * Display a listing of the StudyProgram.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        /** @var StudyProgram $studyPrograms */
        $studyPrograms = StudyProgram::all();

        return view('study_programs.index')
            ->with('studyPrograms', $studyPrograms);
    }

    /**
     * Show the form for creating a new StudyProgram.
     *
     * @return Response
     */
    public function create()
    {
        return view('study_programs.create');
    }

    /**
     * Store a newly created StudyProgram in storage.
     *
     * @param CreateStudyProgramRequest $request
     *
     * @return Response
     */
    public function store(CreateStudyProgramRequest $request)
    {
        $input = $request->all();

        /** @var StudyProgram $studyProgram */
        $studyProgram = StudyProgram::create($input);

        Flash::success('Study Program saved successfully.');

        return redirect(route('studyPrograms.index'));
    }

    /**
     * Display the specified StudyProgram.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var StudyProgram $studyProgram */
        $studyProgram = StudyProgram::find($id);

        if (empty($studyProgram)) {
            Flash::error('Study Program not found');

            return redirect(route('studyPrograms.index'));
        }

        return view('study_programs.show')->with('studyProgram', $studyProgram);
    }

    /**
     * Show the form for editing the specified StudyProgram.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var StudyProgram $studyProgram */
        $studyProgram = StudyProgram::find($id);

        if (empty($studyProgram)) {
            Flash::error('Study Program not found');

            return redirect(route('studyPrograms.index'));
        }

        return view('study_programs.edit')->with('studyProgram', $studyProgram);
    }

    /**
     * Update the specified StudyProgram in storage.
     *
     * @param int $id
     * @param UpdateStudyProgramRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateStudyProgramRequest $request)
    {
        /** @var StudyProgram $studyProgram */
        $studyProgram = StudyProgram::find($id);

        if (empty($studyProgram)) {
            Flash::error('Study Program not found');

            return redirect(route('studyPrograms.index'));
        }

        $studyProgram->fill($request->all());
        $studyProgram->save();

        Flash::success('Study Program updated successfully.');

        return redirect(route('studyPrograms.index'));
    }

    /**
     * Remove the specified StudyProgram from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var StudyProgram $studyProgram */
        $studyProgram = StudyProgram::find($id);

        if (empty($studyProgram)) {
            Flash::error('Study Program not found');

            return redirect(route('studyPrograms.index'));
        }

        $studyProgram->delete();

        Flash::success('Study Program deleted successfully.');

        return redirect(route('studyPrograms.index'));
    }
}
