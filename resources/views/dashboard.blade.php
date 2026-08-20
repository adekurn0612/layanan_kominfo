@extends('layouts.app', ['title' => 'Dashboard'])

@section('content')
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <x-stat-card label="Organisasi" :value="$organizationCount" />
        <x-stat-card label="User" :value="$userCount" />
        <x-stat-card label="Role" :value="$roleCount" />
        <x-stat-card label="Permission" :value="$permissionCount" />
        <x-stat-card label="Kategori Layanan" :value="$serviceCategoryCount" />
        <x-stat-card label="Layanan" :value="$serviceCount" />
        <x-stat-card label="Tiket" :value="$ticketCount" />
        <x-stat-card label="Tiket Baru" :value="$submittedTicketCount" />
    </div>

    <x-ui.card title="Dashboard layanan aktif" description="Pengajuan layanan kini menghasilkan tiket ber-UUID yang dapat dicek melalui landing page publik." class="mt-6" />
@endsection
