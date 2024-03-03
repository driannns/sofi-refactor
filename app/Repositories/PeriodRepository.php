<?php

namespace App\Repositories;

use App\Models\Period;
use App\Repositories\BaseRepository;

/**
 * Class PeriodRepository
 * @package App\Repositories
 * @version April 4, 2020, 10:13 am UTC
*/

class PeriodRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'start_date',
        'end_date',
        'description',
        'created_at',
        'updated_at'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Period::class;
    }
}
