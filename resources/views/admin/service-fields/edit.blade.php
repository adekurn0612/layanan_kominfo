@extends('layouts.app', ['title' => 'Edit Field'])

@section('content')
    <form method="POST" action="{{ route('admin.services.fields.update', [$service, $field]) }}" class="max-w-3xl rounded-lg border border-[#CDEAF5] bg-white p-5">
        @csrf
        @method('PUT')
        @include('admin.service-fields.partials.form')
    </form>
@endsection
