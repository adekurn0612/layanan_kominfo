@extends('layouts.app', ['title' => 'Tambah Persyaratan'])

@section('content')
    <form method="POST" action="{{ route('admin.services.requirements.store', $service) }}" class="max-w-2xl rounded-lg border border-[#CDEAF5] bg-white p-5">
        @csrf
        @include('admin.service-requirements.partials.form')
    </form>
@endsection
