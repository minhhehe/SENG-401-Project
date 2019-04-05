@extends('layouts.layout_select')

@section('script')
<!-- <script type="text/javascript"> // FIXME delete script tags (just using them auto-formatting in Atom) -->
const RENDER_MODEL_URL = "{{ url('render_model') }}/";
var renderedModels = [
    @foreach ($renderedModels as $renderedModel)
    {
        id: {{ $renderedModel->id }},
        picture: "{{ asset('storage/' . $renderedModel->picture) }}"
    },
    @endforeach
];

$(function() {
    initCardList();
    alert('loaded');
});

function initCardList() {
    renderedModels.forEach(function(renderedModel) {
        $("#cardList").append(
            "<div class='card'><a href='" + RENDER_MODEL_URL + renderedModel.id + "'><img src='" + renderedModel.picture + "' class='card-image' alt=''></a></div>"
        );
    });

}

<!-- </script> -->
@endsection

@section('mainDisplay')
<div class="">

</div>
@endsection

@section('list')
<div id="cardList" style="width: 60%; display: inline-block;">
    @if (false)
    @foreach ($renderedModels as $renderedModel)
        <div class="card">
            <!-- <a href="render_model/{{ $renderedModel->id }}"></a> -->
            <a href="{{ url('render_model/' . $renderedModel->id)}}">
                    <img src="{{ asset('storage/' . $renderedModel->picture) }}" class="card-image" alt="">
            </a>
        </div>

    @endforeach
    @endif
</div>
@endsection
