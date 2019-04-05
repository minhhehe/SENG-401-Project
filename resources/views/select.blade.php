@extends('layouts.layout_select')

@section('mainDisplay')
<!-- <div style="width: 60%; display: inline-block;"> -->
@endsection

@section('list')
<div style="width: 60%; display: inline-block;">
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
