@extends('layouts.app', ['title' => 'Permission'])

@section('content')
    <div class="overflow-hidden rounded-lg border border-[#CDEAF5] bg-white">
        <table class="w-full divide-y divide-[#CDEAF5] text-sm">
            <thead class="bg-[#F7FBFD] text-left text-xs font-semibold uppercase text-zinc-500">
                <tr>
                    <th class="px-4 py-3">Permission</th>
                    <th class="px-4 py-3">Kode</th>
                    <th class="px-4 py-3">Modul</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#EAF8FC]">
                @foreach ($permissions as $permission)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ $permission->name }}</td>
                        <td class="px-4 py-3">{{ $permission->code }}</td>
                        <td class="px-4 py-3">{{ $permission->module }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $permissions->links() }}</div>
@endsection
