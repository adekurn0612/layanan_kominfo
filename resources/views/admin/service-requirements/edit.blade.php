@extends('layouts.app', ['title' => 'Edit Persyaratan'])

@section('content')
    <form method="POST" action="{{ route('admin.services.requirements.update', [$service, $requirement]) }}" class="max-w-2xl rounded-lg border border-[#CDEAF5] bg-white p-5">
        @csrf
        @method('PUT')
        @include('admin.service-requirements.partials.form')
    </form>
@endsection
