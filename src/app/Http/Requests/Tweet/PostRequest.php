<?php

namespace App\Http\Requests\Tweet;

use App\Http\Requests\BaseRequest;

class PostRequest extends BaseRequest
{
    /**
     * バリデーションのルール設定
     *
     * @return array
     */
    public function rules()
    {
        return [
            'tweet' => ['required', 'max:140']
        ];
    }
}
