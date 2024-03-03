<?php

namespace App\Repositories;

use App\Models\Sidang;
use App\Repositories\BaseRepository;

/**
 * Class SidangRepository
 * @package App\Repositories
 * @version April 4, 2020, 8:51 am UTC
*/

class SidangRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'mahasiswa_id',
        'pembimbing1_id',
        'pembimbing2_id',
        'judul',
        'form_bimbingan',
        'eprt',
        'dokumen_ta',
        'makalah',
        'tak',
        'status',
        'created_at',
        'updated_at',
        'is_english',
        'period_id'
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
        return Sidang::class;
    }
}
