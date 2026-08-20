@extends('layouts.app', ['title' => 'Edit User'])

@section('content')
    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="max-w-2xl rounded-lg border border-[#CDEAF5] bg-white p-5">
        @csrf
        @method('PUT')
        @include('admin.users.partials.form')
    </form>
@endsection
