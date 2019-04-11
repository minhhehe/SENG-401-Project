@extends('layouts.layout_select')

@section('script')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
<script type="text/javascript">
const RENDER_MODEL_URL = "{{ url('selectedModel') }}/";
var renderedModels = [
  @foreach ($renderedModels as $renderedModel)
  {
    id: {{ $renderedModel->id }},
    picture: "storage/{{ $renderedModel->picture }}",
    description: "{{ $renderedModel->description }}"

  },
  @endforeach
];

var selectedIndex = 1;

$(function() {
  initCardList();
  setMainDisplay(selectedIndex);
});

function initCardList() {
    renderedModels.forEach(function(renderedModel, index) {
        // $("#card-list").append(
        //     "<div id='card" + renderedModel.id + "' class='custom-card custom-card--unselected'><a href='" + RENDER_MODEL_URL + renderedModel.id + "'><img src='" + renderedModel.picture + "' class='custom-card-image' alt=''></a></div>"
        // );

        $("#card-" + renderedModel.id).children().attr('title', "View " + renderedModel.description);

        $("#card-" + renderedModel.id).click(function(event) {
            var index = parseInt($(this).attr('id').split('-')[1]);
            selectCard(index);
        });
    });

    // $("#card-2").click(function(event) {
    //     var index = parseInt($(this).attr('id').split('-')[1]);
    //     selectCard(index);
    // });
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
  $("#mainDisplayImg").attr("title", "View " + renderedModel.description);
  $("#description").text(renderedModel.description);
  // animateCSS('#mainDisplayImg', 'fadeOut', function(){ animateCSS('#mainDisplayImg', 'fadeIn') } );

    // $("#card-" + selectedIndex).removeClass("custom-card--selected");
    // $("#card-" + selectedIndex).addClass("custom-card--unselected");
    // $("#card-" + index).removeClass("custom-card--unselected");
    // $("#card-" + index).addClass("custom-card--selected");

    $("#card-" + selectedIndex).css("border", "");
    $("#card-" + index).css("border", "4px solid gray");

  selectedIndex = index;
}

function selectLeft() {
  animateCSS('#mainDisplayImg', 'bounceOutUp', function(){
    setMainDisplay(selectedIndex - 1);
    animateCSS('#mainDisplayImg', 'bounceInDown')
  } );
}

function selectRight() {
  animateCSS('#mainDisplayImg', 'bounceOutUp', function(){
    setMainDisplay(selectedIndex + 1);
    animateCSS('#mainDisplayImg', 'bounceInDown')
  });
}

function selectCard(index) {
    if (index == selectedIndex) {
        return;
    }

    animateCSS('#mainDisplayImg', 'bounceOutUp', function(){
      setMainDisplay(index);
      animateCSS('#mainDisplayImg', 'bounceInDown')
    });
}

function animateCSS(element, animationName, callback) {
  const node = document.querySelector(element)
  node.classList.add('animated', animationName)

  function handleAnimationEnd() {

    node.classList.remove('animated', animationName)
    node.removeEventListener('animationend', handleAnimationEnd)
if (typeof callback === 'function') callback()

  }

  node.addEventListener('animationend', handleAnimationEnd)
}

</script>
@stop

@section('mainDisplay')
<div class="custom-main-display" style="justify-content:center;">
    <button id="leftButton" class="custom-select-button" onclick="selectLeft()" title="View previous model">
        &lt;
    </button>
    <div style="display: inline-block; float: left; width: auto;">
        <a id="mainDisplayLink" href="#"><img id="mainDisplayImg" src="" class="custom-card-image" alt=""></a>
    </div>
    <button id="rightButton" class="custom-select-button" onclick="selectRight()" title="View next model">
        &gt;
    </button>
</div>

<br>
<div>
    <h4 id="description">Ferrari 458 Italia</h4>
</div>

@stop

@section('list')
<!-- <div id="card-list" class="custom-select-list">
</div> -->
<div style="text-align: center;background:lightgrey; margin-left: 10%; margin-right: 10%;">
    <div id="card-list">
        <div class="row" style="justify-content: center; align-items: center;margin-bottom: 10px">
            @foreach ($renderedModels as $renderedModel)
            <div class="col-md-4" style="margin:10px;">
                <div class="card custom-clickable" href="http://localhost:8000/render_model/{{$renderedModel->id}}">
                    <a href="http://localhost:8000/selectedModel/{{$renderedModel->id}}"><img style="max-height: 300px; max-width: 300px" id="{{ $renderedModel->id }}" class="card-img" src="storage/{{$renderedModel->picture}}" alt="" title="{{$renderedModel->description}}"> </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>


@stop
