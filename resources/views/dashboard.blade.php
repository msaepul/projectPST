@extends('layouts.main')
@section('content')

    <h1>Selamat Datang, {{ Auth::user()->name }}</h1>

@endsection
