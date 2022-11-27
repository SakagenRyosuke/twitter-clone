<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;
use Illuminate\Http\Request;

class PostRequest extends BaseRequest
{
    /**
     * バリデーションのルール設定
     *
     * @return array
     */
    public function rules(Request $request)
    {
        if ($request->get('profileImage')) {
            return [
                'profileImage' => ['mimes:png,jpg,jpeg,webp', 'max:800'],
                'screenName' => ['required', 'max:20']
            ];
        } else {
            return [
                'screenName' => ['required', 'max:20']
            ];
        }
    }
}
