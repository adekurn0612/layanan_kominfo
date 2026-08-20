@extends('layouts.app', ['title' => 'Edit User'])

@section('content')
    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="max-w-2xl rounded-lg border border-[#CDEAF5] bg-white p-5">
        @csrf
        @method('PUT')
        @include('admin.users.partials.form')
    </form>

    <a href="{{ route('admin.users.password.edit', $user) }}" class="mt-4 inline-block rounded-md border border-[#B8E2F0] px-4 py-2 text-sm font-semibold hover:bg-[#F7FBFD]">Reset Password</a>
@endsection
