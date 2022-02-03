<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Если false, пользователь не сможет отправлять данные, пока не авторизуется
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
            'name' => 'required|min:2|max:20',
            'email' => 'required|min:6|max:30|email:filter',
            'subject' => 'required|min:5|max:50',
            'message' => 'required|min:10|max:500'
            ];
    }
    
    
    public function attributes()
    {
        return [
            'name' => 'Имя',
            'subject' => 'Тема',
            'message' => 'Сообщение'
        ];
    }
    
    public function messages()
    {
        return [
            'name.required' => 'Поле Имя обязательно',
            'email.required' => 'Поле Email обязательно',
            'subject.required' => 'Поле Тема обязательно',
            'message.required' => 'Поле Сообщение обязательно',
            
            'name.min' => 'Минимальное количество символов  в поле Имя должно быть больше 2',
            'email.min' => 'Минимальное количество символов  в поле Email должно быть больше 6',
            'subject.min' => 'Минимальное количество символов в поле Тема должно быть больше 5',
            'message.min' => 'Минимальное количество символов в поле Сообщение должно быть больше 10',  
            
            'name.max' => 'Максимальное количество символов  в поле Имя должно быть меньше 20',
            'email.max' => 'Максимальное количество символов  в поле Email должно быть меньше 30',
            'subject.max' => 'Максимальное количество символов в поле Тема должно быть меньше 50',
            'message.max' => 'Минимальное количество символов в поле Сообщение должно быть меньше 500',
            
            'email.email' => 'Поле Email должно соответствовать формату name@domain.ru'
        ];
    }
    
    
    
}
