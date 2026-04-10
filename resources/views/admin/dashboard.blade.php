@extends('layouts.admin')

@section('title', 'Tableau de bord')

@section('content')

<div class="page-header">
    <div>
        <h1>Tableau de bord</h1>
        <p>Vue d'ensemble de votre activité</p>
    </div>
</div>

{{-- STATS --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-top">
            <span class="stat-label">Marques</span>
            <div class="stat-icon" style="background:#EFF6FF;color:#2563EB">
                <i class="fa-solid fa-tag"></i>
            </div>
        </div>
        <span class="stat-value">{{ $stats['marques'] }}</span>
    </div>
    <div class="stat-card">
        <div class="stat-top">
            <span class="stat-label">Véhicules</span>
            <div class="stat-icon" style="background:#ECFDF5;color:#059669">
                <i class="fa-solid fa-car"></i>
            </div>
        </div>
        <span class="stat-value">{{ $stats['vehicules'] }}</span>
    </div>
    <div class="stat-card">
        <div class="stat-top">
            <span class="stat-label">Clients</span>
            <div class="stat-icon" style="background:#EDE9FE;color:#7C3AED">
                <i class="fa-solid fa-users"></i>
            </div>
        </div>
        <span class="stat-value">{{ number_format($stats['clients'], 0, ',', ' ') }}</span>
    </div>
    <div class="stat-card">
        <div class="stat-top">
            <span class="stat-label">Annonces</span>
            <div class="stat-icon" style="background:#FEF3C7;color:#D97706">
                <i class="fa-solid fa-file-lines"></i>
            </div>
        </div>
        <span class="stat-value">{{ $stats['annonces'] }}</span>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 280px;gap:24px;align-items:start">

    {{-- RECENT ACTIVITY --}}
    <div class="table-card">
        <div style="padding:20px 24px 16px;border-bottom:1px solid var(--gray-200)">
            <h2 style="font-size:17px;font-weight:700">Activité récente</h2>
        </div>
        @foreach($activiteRecente as $activite)
        <div style="display:flex;align-items:center;justify-content:space-between;padding:16px 24px;border-bottom:1px solid var(--gray-100)">
            <div style="display:flex;align-items:center;gap:14px">
                <div style="width:36px;height:36px;border-radius:50%;background:var(--blue-light);color:var(--blue);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                    <i class="fa-solid fa-plus" style="font-size:14px"></i>
                </div>
                <div>
                    <div style="font-size:14px;font-weight:600">{{ $activite->titre }}</div>
                    <div style="font-size:12px;color:var(--gray-400)">{{ $activite->description }} • {{ $activite->date_relative }}</div>
                </div>
            </div>
            <a href="{{ $activite->lien }}" style="color:var(--gray-400);text-decoration:none;font-size:14px">
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
            </a>
        </div>
        @endforeach
    </div>

    {{-- QUICK ACTIONS --}}
    <div>
        <div class="table-card" style="padding:20px">
            <h3 style="font-size:15px;font-weight:700;margin-bottom:16px">Actions rapides</h3>
            <a href="{{ route('admin.vehicules.create') }}" class="btn btn-primary" style="width:100%;justify-content:center;margin-bottom:10px">
                <i class="fa-solid fa-plus"></i>
                Ajouter un véhicule
            </a>
            <a href="{{ route('admin.marques.create') }}" class="btn btn-outline" style="width:100%;justify-content:center">
                <i class="fa-solid fa-tag" style="font-size:13px"></i>
                Ajouter une marque
            </a>
        </div>

        {{-- SYSTEM NOTE --}}
        @if($noteSysteme)
        <div style="margin-top:16px;padding:16px 18px;background:#FFFBEB;border:1px solid #FDE68A;border-radius:var(--radius)">
            <div style="font-size:13px;font-weight:700;color:#92400E;margin-bottom:6px">Note système</div>
            <p style="font-size:13px;color:#92400E;line-height:1.5">{{ $noteSysteme }}</p>
        </div>
        @endif
    </div>
</div>

@endsection
