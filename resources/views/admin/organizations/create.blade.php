@extends('layouts.app', ['title' => 'Tambah Organisasi'])

@section('content')
    <form method="POST" action="{{ route('admin.organizations.store') }}" class="max-w-2xl rounded-lg border border-[#CDEAF5] bg-white p-5">
        @csrf
        @include('admin.organizations.partials.form')
    </form>
@endsection
