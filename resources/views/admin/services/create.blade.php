@extends('layouts.app', ['title' => 'Tambah Layanan'])

@section('content')
    <form method="POST" action="{{ route('admin.services.store') }}" class="max-w-3xl rounded-lg border border-[#CDEAF5] bg-white p-5">
        @csrf
        @include('admin.services.partials.form')
    </form>
@endsection
