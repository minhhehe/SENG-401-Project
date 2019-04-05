@extends('layouts.layout_select')

@section('mainDisplay')

@endsection

@section('list')
<div class="">
    @foreach ($renderedModels as $renderedModel)
        <div class="card">
            <!-- <a href="render_model/{{ $renderedModel->id }}"></a> -->
            <a href="{{ url('render_model/' . $renderedModel->id)}}">
                    <img src="{{ asset('storage/' . $renderedModel->picture) }}" class="card-image" alt="">
            </a>
        </div>
    @endforeach
</div>
@endsection
