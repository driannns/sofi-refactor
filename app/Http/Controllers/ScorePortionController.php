<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateScorePortionRequest;
use App\Http\Requests\UpdateScorePortionRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Period;
use App\Models\ScorePortion;
use App\Models\StudyProgram;
use Illuminate\Http\Request;
use Flash;
use Response;

class ScorePortionController extends AppBaseController
{
    /**
     * Display a listing of the ScorePortion.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        /** @var ScorePortion $scorePortions */
        $scorePortions = ScorePortion::all();

        return view('score_portions.index')
            ->with('scorePortions', $scorePortions);
    }

    /**
     * Show the form for creating a new ScorePortion.
     *
     * @return Response
     */
    public function create()
    {
        $period = Period::getAllPeriod();
        $studyPrograms = StudyProgram::getAllProdi();
        return view('score_portions.create', ['period' => $period, 'studyPrograms' => $studyPrograms]);
    }

    /**
     * Store a newly created ScorePortion in storage.
     *
     * @param CreateScorePortionRequest $request
     *
     * @return Response
     */
    public function store(CreateScorePortionRequest $request)
    {
        $input = $request->all();

        if( ($input['pembimbing'] + $input['penguji']) > 100 ){
            Flash::error('ERROR ! Porsi nilai inputan lebih dari 100%. Porsi nilai harus 100%');
            return redirect()->back();
        }elseif (($input['pembimbing'] + $input['penguji']) < 100){
            Flash::error('ERROR ! Porsi nilai inputan kurang dari 100%. Porsi nilai harus 100%');
            return redirect()->back();
        }

        /** @var ScorePortion $scorePortion */
        $scorePortion = ScorePortion::create($input);

        Flash::success('Score Portion saved successfully.');

        return redirect(route('scorePortions.index'));
    }

    /**
     * Display the specified ScorePortion.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var ScorePortion $scorePortion */
        $scorePortion = ScorePortion::find($id);

        if (empty($scorePortion)) {
            Flash::error('Score Portion not found');

            return redirect(route('scorePortions.index'));
        }

        return view('score_portions.show')->with('scorePortion', $scorePortion);
    }

    /**
     * Show the form for editing the specified ScorePortion.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $period = Period::getAllPeriod();
        $studyPrograms = StudyProgram::getAllProdi();
        /** @var ScorePortion $scorePortion */
        $scorePortion = ScorePortion::find($id);

        if (empty($scorePortion)) {
            Flash::error('Score Portion not found');

            return redirect(route('scorePortions.index'));
        }

        return view('score_portions.edit')->with(['period' => $period, 'scorePortion'=> $scorePortion, 'studyPrograms' => $studyPrograms]);
    }

    /**
     * Update the specified ScorePortion in storage.
     *
     * @param int $id
     * @param UpdateScorePortionRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateScorePortionRequest $request)
    {
        /** @var ScorePortion $scorePortion */
        $scorePortion = ScorePortion::find($id);

        if (empty($scorePortion)) {
            Flash::error('Score Portion not found');

            return redirect(route('scorePortions.index'));
        }

        if( ($request->pembimbing + $request->penguji) > 100 ){
            Flash::error('ERROR ! Porsi nilai inputan lebih dari 100%. Porsi nilai harus 100%');
            return redirect()->back();
        }elseif (($request->pembimbing + $request->penguji) < 100){
            Flash::error('ERROR ! Porsi nilai inputan kurang dari 100%. Porsi nilai harus 100%');
            return redirect()->back();
        }

        $scorePortion->fill($request->all());
        $scorePortion->save();

        Flash::success('Score Portion updated successfully.');

        return redirect(route('scorePortions.index'));
    }

    /**
     * Remove the specified ScorePortion from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var ScorePortion $scorePortion */
        $scorePortion = ScorePortion::find($id);

        if (empty($scorePortion)) {
            Flash::error('Score Portion not found');

            return redirect(route('scorePortions.index'));
        }

        $scorePortion->delete();

        Flash::success('Score Portion deleted successfully.');

        return redirect(route('scorePortions.index'));
    }
}
