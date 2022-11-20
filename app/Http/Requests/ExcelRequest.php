<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExcelRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'file.*' => ['required', 'distinct', 'max:100'],
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'groupId.*.required' => __('messages.groupRegistration.groupIdRequired'),
            'groupId.*.distinct' => __('messages.groupRegistration.groupIdDuplicate'),
            'groupId.*.max' => __('messages.groupRegistration.groupIdRange'),
            'groupName.*.required' => __('messages.groupRegistration.groupNameRequired'),
            'groupName.*.max' => __('messages.groupRegistration.groupNameRange'),
            'groupMultiplyRatio.*.required' => __('messages.groupRegistration.groupMultiplyRatioRequired'),
            'groupMultiplyRatio.*.integer' => __('messages.groupRegistration.groupMultiplyRatioInteger'),
            'groupMultiplyRatio.*.between' => __('messages.groupRegistration.groupMultiplyRatioRange')
        ];
    }
}