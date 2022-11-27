<?php

namespace App\Http\Requests\Comment;

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
            'comment' => ['required', 'max:140']
        ];
    }
}
