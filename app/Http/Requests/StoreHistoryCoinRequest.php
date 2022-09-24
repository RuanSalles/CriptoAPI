<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 *
 */
class StoreHistoryCoinRequest extends FormRequest
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
     * @return void
     */
    public function rules()
    {
    //
    }
}
