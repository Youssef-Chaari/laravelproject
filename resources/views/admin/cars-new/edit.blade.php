@extends('layouts.admin')
@section('title', 'Modifier la voiture')
@section('page-title', 'Modifier la voiture')

@section('content')
<div class="max-w-3xl">
    <form method="POST" action="{{ route('admin.cars-new.update', $car) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf @method('PUT')
        @include('admin.cars-new._form', ['car' => $car])
        <button type="submit" class="btn-primary">Mettre à jour</button>
    </form>
</div>
@endsection
