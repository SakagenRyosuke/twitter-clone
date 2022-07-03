<?php

namespace App\Models;

use App\Consts\AdditionalNumber;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'screenName',
        'email',
        'profileImage',
        'password',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * 引数のページ数に応じてusersテーブルから10件ずつ追加で取得して該当するユーザーの情報をobjectで返す
     *
     * @return object
     */
    public function getUserList(int $page, int $authUserId): object
    {
        $count = AdditionalNumber::SHOW_NUMBER * $page;
        $start = $count - AdditionalNumber::SHOW_NUMBER + 1;
        $allUser = $this->where('id', '<>', $authUserId)->select("id", "name", "screenName", "profileImage")->whereBetween('id', [$start, $count])->get();
        return $allUser;
    }
}
