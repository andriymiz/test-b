<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'username' => 'required_without:email',
            'email' => 'required_without:username',
            'subject' => 'required|string',
            'message' => 'required|string',
            'password' => '',
            'g-recaptcha-response' => 'recaptcha',
        ];
    }
}
