@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="welcome-box" style="padding: 20px; background: white; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <h2>Selamat Datang, {{ Auth::user()->name }}!</h2>
        <p>Status: <span class="badge badge-primary">{{ strtoupper(Auth::user()->role) }}</span></p>
        <hr>
        <p>Sekarang lo udah pake layout Admin Native lo di dalam Laravel. 🏎️💨</p>
    </div>
</div>
@endsection