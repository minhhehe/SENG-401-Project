@extends('layouts.layout_select')

@section('script')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
<script type="text/javascript">
const RENDER_MODEL_URL = "{{ url('render_model') }}/";
var renderedModels = [
  @foreach ($renderedModels as $renderedModel)
  {
    id: {{ $renderedModel->id }},
    picture: "{{ asset('storage/' . $renderedModel->picture) }}",
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
  $("#mainDisplayImg").attr("title", "Colour " + renderedModel.description);
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
  animateCSS('#mainDisplayImg', 'bounceOutLeft', function(){
    setMainDisplay(selectedIndex - 1);
    animateCSS('#mainDisplayImg', 'bounceInRight')
  } );
}

function selectRight() {
  animateCSS('#mainDisplayImg', 'bounceOutRight', function(){
    setMainDisplay(selectedIndex + 1);
    animateCSS('#mainDisplayImg', 'bounceInLeft')
  });
}

function selectCard(index) {
    if (index == selectedIndex) {
        return;
    }

    animateCSS('#mainDisplayImg', 'bounceOutRight', function(){
      setMainDisplay(index);
      animateCSS('#mainDisplayImg', 'bounceInLeft')
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

@section('title')
 Choose your vehicle model
@stop

@section('mainDisplay')
<div class="custom-main-display">
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
<div style="text-align: center; margin-left: 20%; margin-right: 20%;">
    <div id="card-list">
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <div id="card-1" class="card">
                    <img class="card-img" src="{{ url('storage/ferrari.png') }}" alt="" title="View Ferrari 458 Italia">
                </div>
            </div>
            <div class="col-md-4">
                <div id="card-2" class="card">
                    <img class="card-img" src="{{ url('storage/range_rover.png') }}" alt="">
                </div>
            </div>
            <div class="col-md-4">
                <div id="card-3" class="card">
                    <img class="card-img" src="{{ url('storage/toyota.png') }}" alt="">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div id="card-4" class="card custom-clickable">
                    <img class="card-img" src="{{ url('storage/mclaren.png') }}" alt="">
                </div>
            </div>
            <div class="col-md-4">
                <div id="card-5" class="card">
                    <img class="card-img" src="{{ url('storage/lamborghini.png') }}" alt="">
                </div>
            </div>
            <div class="col-md-4">
                <div id="card-6" class="card">
                    <img class="card-img" src="{{ url('storage/x_wing.png') }}" alt="">
                </div>
            </div>
        </div>
    </div>
</div>


@stop
