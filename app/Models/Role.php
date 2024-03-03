<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Role
 * @package App\Models
 * @version April 3, 2020, 1:08 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property string nama
 * @property string role_code
 */
class Role extends Model
{

    use LogsActivity;
    public $table = 'roles';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'nama',
        'role_code'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'nama' => 'string',
        'role_code' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function users()
    {
        return $this->belongsToMany(\App\Models\User::class, 'user_has_role');
    }

    public static function getAllAdmin()
    {
        $users = array();
        $roles = Role::where('role_code','RLADM')->with('users')->get()->toArray();
        foreach ($roles as $key => $role) {
            foreach ($role['users'] as $user) {
                $users[] = $user;
            }
        }
        return ($users);
    }
}
