@extends('layouts.app', ['title' => 'Kategori Layanan'])

@section('content')
    @section('action')
        <a href="{{ route('admin.service-categories.create') }}" class="rounded-md bg-[#137CBD] px-4 py-2 text-sm font-semibold text-white hover:bg-[#0D6EAE]">Tambah Kategori</a>
    @endsection

    <div class="overflow-hidden rounded-lg border border-[#CDEAF5] bg-white">
        <table class="w-full divide-y divide-[#CDEAF5] text-sm">
            <thead class="bg-[#F7FBFD] text-left text-xs font-semibold uppercase text-zinc-500">
                <tr>
                    <th class="px-4 py-3">Gambar</th>
                    <th class="px-4 py-3">Kategori</th>
                    <th class="px-4 py-3">Kode</th>
                    <th class="px-4 py-3">Urutan</th>
                    <th class="px-4 py-3">Layanan</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#EAF8FC]">
                @foreach ($categories as $category)
                    <tr>
                        <td class="px-4 py-3">
                            <img src="{{ $category->image_url }}" alt="Gambar {{ $category->name }}" loading="lazy" decoding="async" class="h-12 w-20 rounded-md border border-[#CDEAF5] object-cover">
                        </td>
                        <td class="px-4 py-3 font-medium">{{ $category->name }}</td>
                        <td class="px-4 py-3">{{ $category->code }}</td>
                        <td class="px-4 py-3">{{ $category->sort_order }}</td>
                        <td class="px-4 py-3">{{ $category->services_count }}</td>
                        <td class="px-4 py-3"><x-status-badge :active="$category->is_active" /></td>
                        <td class="px-4 py-3 text-right"><a href="{{ route('admin.service-categories.edit', $category) }}" class="font-medium underline">Edit</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $categories->links() }}</div>
@endsection
