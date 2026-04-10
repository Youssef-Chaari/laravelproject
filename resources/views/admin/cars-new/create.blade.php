@extends('layouts.admin')
@section('title', 'Ajouter une voiture')
@section('page-title', 'Ajouter une voiture')

@section('content')
<div class="max-w-3xl">
    <form method="POST" action="{{ route('admin.cars-new.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @include('admin.cars-new._form')
        <button type="submit" class="btn-primary">Ajouter la voiture</button>
    </form>
</div>
@endsection
