<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $rules = [];
        
        // Profile photo validation
        if ($this->hasFile('profile_photo')) {
            $rules['profile_photo'] = ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'];
        }
        
        // Name validation
        if ($this->has('name')) {
            $rules['name'] = ['required', 'string', 'max:255'];
        }
        
        // Email validation (only for non-social users)
        if ($this->has('email') && !$this->user()->google_id && !$this->user()->github_id) {
            $rules['email'] = [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id)
            ];
        }
        
        return $rules;
    }

    /**
     * Get custom error messages.
     */
    public function messages(): array
    {
        return [
            'profile_photo.image' => 'The file must be an image.',
            'profile_photo.mimes' => 'The image must be a JPEG, PNG, JPG, or GIF file.',
            'profile_photo.max' => 'The image size must not exceed 2MB.',
            'name.required' => 'Name is required.',
            'name.string' => 'Name must be a valid string.',
            'name.max' => 'Name must not exceed 255 characters.',
            'email.required' => 'Email is required.',
            'email.string' => 'Email must be a valid string.',
            'email.lowercase' => 'Email must be in lowercase.',
            'email.email' => 'Please provide a valid email address.',
            'email.max' => 'Email must not exceed 255 characters.',
            'email.unique' => 'This email is already taken.',
        ];
    }

    /**
     * Get custom attribute names for error messages.
     */
    public function attributes(): array
    {
        return [
            'profile_photo' => 'profile photo',
            'name' => 'name',
            'email' => 'email address',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}