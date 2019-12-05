<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MembersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 이름 10, 주소 255, 전화번호 13, 좌우명 x, 이미지 255,
            // id, created_at, updated_at
            // 왜인지 모르겠지만 |사용시 오류025ㅠ
            'name' => ['required', 'max:10'],
            'phone_number' => ['required', 'max:13'],
            'motto' => ['required', 'min:10'],
            'address' => ['required', 'max:255'],  
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute은(는) 필수 입력 항목입니다.',
            'min' => ':attribute은(는) 최소 :min자 이상 입력해주세요.',
            'max' => ':attribute은(는) 최대 :max자 이상 입력할 수 없습니다.',
        ];
    }

    public function attributes()
    {
        return [
            'name' => '이름',
            'phone_number' => '전화번호',
            'motto' => '모토',
            'address' => '주소',
        ];
    }
}
