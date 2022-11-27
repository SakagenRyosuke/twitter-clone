<?php

namespace App\Models;

use App\Consts\Paginate;
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
     * ユーザーリストの取得
     * 
     * @param int $authUserId
     * @return object
     */
    public function getUserList(int $authUserId): object
    {
        return $this->where('id', '<>', $authUserId)
            ->select("id", "name", "screenName", "profileImage")
            ->paginate(Paginate::NUM_USER_PER_PAGE);
    }

    /**
     * 認証ユーザーのみユーザー情報更新
     * 
     * @param int $authId
     * @param object $request
     * @return bool
     */
    public function updateUser(int $authId, object $request): bool
    {
        $user = $this->where('id', $authId)->first();
        $user->screenName = $request->screenName;

        if ($request->file('profileImage')) {
            $imageName = $request->file('profileImage')
                ->hashName();
            $user->profileImage = '/storage/user/' . $imageName;
            $request->file('profileImage')
                ->storeAs('public/user', $imageName);
        }

        return $user->save();
    }

    /**
     * 名前取得
     * 
     * @param int $userId
     * @return string
     */
    public function getUserName(int $userId): string
    {
        return $this->where('id', $userId)
            ->select('name')->first();
    }

    /**
     * フォローしているユーザー名の取得
     * 
     * @param array $timelineIds
     * @return array
     */
    public function getTimelineNames(array $timelineIds): array
    {
        return $this->whereIn('id', $timelineIds)
            ->select('name')->get()->pluck('name')->toArray();
    }
}
