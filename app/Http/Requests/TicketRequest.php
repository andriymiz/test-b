<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

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
            'username' => 'required|string',
            'email' => 'required|email',
            'subject' => 'required|string',
            'message' => 'required|string',
            'password' => '',
            'user' => '',
            'g-recaptcha-response' => 'recaptcha',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     *
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $this->merge([
                'user' => User::where('username', $this->username)
                    ->orWhere('email', $this->email)
                    ->first(),
            ]);

            if (is_null($this->user)) {
                $validator->errors()->add('username', 'User Not Found!');
            }

            if (
                $this->password
                && $this->user
                && ! Hash::check($this->password, $this->user->password)
            ) {
                $validator->errors()->add('password', 'Password is incorrect!');
            }
        });
    }
}
