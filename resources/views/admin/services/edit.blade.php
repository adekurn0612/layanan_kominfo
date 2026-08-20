@extends('layouts.app', ['title' => 'Edit Layanan'])

@section('content')
    <form method="POST" action="{{ route('admin.services.update', $service) }}" class="max-w-3xl rounded-lg border border-[#CDEAF5] bg-white p-5">
        @csrf
        @method('PUT')
        @include('admin.services.partials.form')
    </form>
@endsection
