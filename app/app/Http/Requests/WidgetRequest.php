<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WidgetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // доступно всем
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|regex:/^\+[1-9]\d{1,14}$/', // E.164
            'subject' => 'required|string|max:255',
            'body' => 'required|string|max:4096',
            'files.*' => 'file|max:10240',
        ];
    }
    public function messages()
    {
        return [
            'phone.regex' => 'Телефон должен быть в E.164 формате (+123456789).',
            'email.email' => 'Не верный емейл.',
            'subject.max' => 'Тема слишком длинная.',
            'name.max' => 'Имя слишком длинное',
            'body.max' => 'Текст слишком длинный.'
        ];
    }
}
