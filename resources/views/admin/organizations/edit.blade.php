@extends('layouts.app', ['title' => 'Edit Organisasi'])

@section('content')
    <form method="POST" action="{{ route('admin.organizations.update', $organization) }}" class="max-w-2xl rounded-lg border border-[#CDEAF5] bg-white p-5">
        @csrf
        @method('PUT')
        @include('admin.organizations.partials.form')
    </form>
@endsection
