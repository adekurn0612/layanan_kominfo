@extends('layouts.app', ['title' => 'Tambah User'])

@section('content')
    <form method="POST" action="{{ route('admin.users.store') }}" class="max-w-2xl rounded-lg border border-[#CDEAF5] bg-white p-5">
        @csrf
        @include('admin.users.partials.form')
    </form>
@endsection
