@extends('errors::minimal')

@section('title', __('Forbidden'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'Forbidden'))
<p class="mt-3 mb-1">
    <a href="{{ route('login') }}">Login</a>
</p>
