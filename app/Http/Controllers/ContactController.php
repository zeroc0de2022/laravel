<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;


class ContactController extends Controller
{
    public function submit(ContactRequest $req)
    {
        $contact = new Contact();
        # Назначение данных из формы в класс Contact, наследование от Model
        $contact->name = $req->input('name');
        $contact->email = $req->input('email');
        $contact->subject = $req->input('subject');
        $contact->message = $req->input('message');
        # Сохранение данных из формы в БД
        $contact->save();
        # переадресация роута, с добавлением в сессию сообшения
        return redirect()->route('home')->with("success", "Сообщение было отправлено");
       
    }
}
