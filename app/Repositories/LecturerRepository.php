<?php

namespace App\Repositories;

use App\Models\Lecturer;
use App\Repositories\BaseRepository;

/**
 * Class LecturerRepository
 * @package App\Repositories
 * @version April 4, 2020, 5:34 am UTC
*/

class LecturerRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'nip',
        'code',
        'jfa',
        'kk',
        'user_id'
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
        return Lecturer::class;
    }
}
