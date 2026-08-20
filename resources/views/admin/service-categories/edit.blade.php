@extends('layouts.app', ['title' => 'Edit Kategori Layanan'])

@section('content')
    <form method="POST" action="{{ route('admin.service-categories.update', $category) }}" enctype="multipart/form-data" class="max-w-2xl rounded-lg border border-[#CDEAF5] bg-white p-5">
        @csrf
        @method('PUT')
        @include('admin.service-categories.partials.form')
    </form>
@endsection
