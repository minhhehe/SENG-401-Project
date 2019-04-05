@extends('layouts.layout_select')

@section('mainDisplay')

@endsection

@section('list')
<div class="">
    @foreach ($renderedModels as $renderedModel)
        <div class="card">
            <img src="{{ asset('storage/' . $renderedModel->picture) }}" class="card-image" alt="">
        </div>
    @endforeach
</div>
@endsection
