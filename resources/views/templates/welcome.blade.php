@extends('templates.default')

@section('content')

    <div class="container">
            <h1 class="text-center">Selamat Datang, {{ $user->name }}!</h1>
    </div>

@endsection
