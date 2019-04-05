@extends('layouts.layout_select')

@section('script')
<script type="text/javascript">
const RENDER_MODEL_URL = "{{ url('render_model') }}/";
var renderedModels = [
    @foreach ($renderedModels as $renderedModel)
    {
        id: {{ $renderedModel->id }},
        picture: "{{ asset('storage/' . $renderedModel->picture) }}"
    },
    @endforeach
];

var selectedIndex = 0;

$(function() {
    initCardList();
    setMainDisplay(0);
});

function initCardList() {
    renderedModels.forEach(function(renderedModel) {
        $("#card-list").append(
            "<div id='" + renderedModel.id + "' class='card'><a href='" + RENDER_MODEL_URL + renderedModel.id + "'><img src='" + renderedModel.picture + "' class='card-image' alt=''></a></div>"
        );
    });
}

function setMainDisplay(index) {
    if (index < 0) {
        index = renderedModels.length - 1;
    } else if (index >= renderedModels.length) {
        index = 0;
    }

    var renderedModel = renderedModels[index];
    selectedIndex = index;

    $("#mainDisplayLink").attr("href", RENDER_MODEL_URL + renderedModel.id);
    $("#mainDisplayImg").attr("src", renderedModel.picture);
}

</script>
@endsection

@section('mainDisplay')
<div class="main-display">
    <a id="mainDisplayLink" href="#"><img id="mainDisplayImg" src="" class="card-image" alt=""></a>
</div>
@endsection

@section('list')
<div id="card-list" style="width: 60%; display: inline-block;">
</div>
@endsection
