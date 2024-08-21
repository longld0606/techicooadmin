<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use  HasFactory, Notifiable, HasRoles;
    protected $guard_name = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function configs()
    {
        return $this->hasMany(UserConfig::class, 'user_id', 'id');
    }

   
    public function shortName()
    {
        $array = explode(' ', $this->name);
        $c = count($array);
        if ($c == 1) {
            return substr($array[0], 0, 1);
        }
        $s1 = substr($array[$c - 1], 0, 1);
        $s2 = substr($array[$c - 2], 0, 1);
        // nếu ko phải utf8 lấy 2 ký tự
        if (mb_check_encoding($s1, 'UTF-8') == false)    $s1 = substr($array[$c - 1], 0, 2);
        if (mb_check_encoding($s2, 'UTF-8') == false)    $s2 = substr($array[$c - 2], 0, 2);
        // 2 ký tự ko đủ lấy 3 ký tự
        if (mb_check_encoding($s1, 'UTF-8') == false)    $s1 = substr($array[$c - 1], 0, 3);
        if (mb_check_encoding($s2, 'UTF-8') == false)    $s2 = substr($array[$c - 2], 0, 3);
        // tối đa 3 ký tự là đủ
        return $s2 . $s1;
    }
}
