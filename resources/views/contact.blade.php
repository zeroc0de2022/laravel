@extends('layouts.app')

@section('title-block') Контакты @endsection

@section('content')
    <h1>Контакты</h1>
    
    <form action="{{ route('contact-form') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="name">Name</label> 
            <input type="text" name="name" id="name" placeholder="Name" value="" class="form-control"/>
        </div>
        
        <div class="form-group"> 
            <label for="email">Email</label> 
            <input type="text" name="email" id="email" placeholder="email" value="" class="form-control"/> 
        </div>
        
        <div class="form-group"> 
            <label for="subject">Subject</label> 
            <input type="text" name="subject" id="subject" placeholder="subject" value="" class="form-control"/>
        </div>
        
        <div class="form-group"> 
            <label for="message">Message</label> 
            <textarea type="text" name="message" id="message" placeholder="message" class="form-control"/></textarea>
        </div>
        <button type="submit" class="btn btn-success">Отправить</button>
    </form>
@endsection