@extends('layouts.app', ['title' => 'Tambah Field'])

@section('content')
    <form method="POST" action="{{ route('admin.services.fields.store', $service) }}" class="max-w-3xl rounded-lg border border-[#CDEAF5] bg-white p-5">
        @csrf
        @include('admin.service-fields.partials.form')
    </form>
@endsection
