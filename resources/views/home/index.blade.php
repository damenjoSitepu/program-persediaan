@extends('page.main.home')

@section('content')
    @if(session()->get('login')['jabatan_id'] == 1)
        @include('home.admin')
    @else 
        @include('home.picker')
    @endif
@endSection