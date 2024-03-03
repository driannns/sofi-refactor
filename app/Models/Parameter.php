<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Parameter extends Model
{
    use LogsActivity;
    protected $table = 'parameters';

    protected $fillable = [
        'id','name','value'
    ];

    protected $casts = [
        'id' => 'string',
        'value' => 'string'
    ];
}
