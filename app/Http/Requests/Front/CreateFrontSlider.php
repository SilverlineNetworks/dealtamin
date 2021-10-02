<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;

class CreateFrontSlider extends FormRequest
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
                'image' => 'dimensions:min_width=1920px,min_height=520px,max_width=1920px,max_height=520px',
                'have_content' => 'required|in:yes,no',
            ];
        }

        public function messages()
        {
            return [
                'image' => __('messages.front.errors.image'),
                'have_content.required' => __('messages.front.errors.have_content'),
            ];
        }
}
