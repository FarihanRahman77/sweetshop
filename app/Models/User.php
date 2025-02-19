<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\DB;


class User extends Authenticatable
{
    
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name','username','email', 'password',
    ];

    protected $guard_name = 'web';
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    

    public function Usertypes()
    {

        return $this->belongsTo(Usertype::class, 'usertype_id', 'id');
    }


    public static function getPermissionGroups()
    {
        $permissionGroups =  DB::table('permissions')
            ->select('group_name as name')
            ->groupBy('group_name')
            ->get();
        return  $permissionGroups;
    }


    public static function getPermissionsByGroupName($groupName)
    {
        $getPermissionsByGroupName =  DB::table('permissions')
            ->where('group_name', $groupName)
            ->get();
        return  $getPermissionsByGroupName;
    }
}
