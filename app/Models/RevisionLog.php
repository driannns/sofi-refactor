<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class RevisionLog extends Model
{
    use LogsActivity;
    public $table = 'revision_logs';


    public $fillable = [
        'revision_id',
        'feedback',
        'created_at',
        'updated_at'
    ];

    public function revision()
    {
        return $this->belongsTo(\App\Models\Revision::class, 'revision_id');
    }
}
