<?php

namespace App\Exports;

use App\Models\StudyProgram;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class RevisionMultiplesExport implements WithMultipleSheets
{
    protected $period_id;

    public function __construct($period_id)
    {
        $this->period_id = $period_id;
    }
    public function sheets(): array
    {
        $sheets = [];
        //get all prodi available
        $program_studies = StudyProgram::all();

        foreach ($program_studies as $program_study) {
            $sheets[] = new RevisionsExport($this->period_id, $program_study->name);
        }

        return $sheets;
    }
}
