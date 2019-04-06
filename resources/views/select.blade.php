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

var selectedIndex = 1;

$(function() {
    initCardList();
    setMainDisplay(selectedIndex);
});

function initCardList() {
    renderedModels.forEach(function(renderedModel) {
        $("#card-list").append(
            "<div id='card" + renderedModel.id + "' class='custom-card custom-card--unselected'><a href='" + RENDER_MODEL_URL + renderedModel.id + "'><img src='" + renderedModel.picture + "' class='custom-card-image' alt=''></a></div>"
        );
    });
}

function setMainDisplay(index) {
    // Index starts at 1
    if (index - 1 < 0) {
        index = renderedModels.length;
    } else if (index > renderedModels.length) {
        index = 1;
    }

    var renderedModel = renderedModels[index - 1];

    $("#mainDisplayLink").attr("href", RENDER_MODEL_URL + renderedModel.id);
    $("#mainDisplayImg").attr("src", renderedModel.picture);

    $("#card" + selectedIndex).removeClass("custom-card--selected");
    $("#card" + selectedIndex).addClass("custom-card--unselected");
    $("#card" + index).removeClass("custom-card--unselected");
    $("#card" + index).addClass("custom-card--selected");

    selectedIndex = index;
}

function selectLeft() {
    setMainDisplay(selectedIndex - 1);
}

function selectRight() {
    setMainDisplay(selectedIndex + 1);
}

</script>
@stop

@section('mainDisplay')
<div class="custom-main-display">
    <button id="leftButton" class="custom-select-button" onclick="selectLeft()">
        &lt;
    </button>
    <div style="display: inline-block; float: left; width: auto;">
        <a id="mainDisplayLink" href="#"><img id="mainDisplayImg" src="" class="custom-card-image" alt=""></a>
    </div>
    <button id="rightButton" class="custom-select-button" onclick="selectRight()">
        &gt;
    </button>
</div>

@stop

@section('list')
<div id="card-list" class="custom-select-list">
</div>
@stop
