@extends('layouts.layout_app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Submitted</div>

                <div class="card-body">
                    <br>
                    <div class="card-title">
                        <h1 style="color: gray;">Thank you for your submission</h1>
                    </div>

                    <p>Your local dealership has been notified of your order.
                    <br/>Please visit them to finalize your order.</p>

                    <br>

                    <h3 style="color: gray;">Changed your mind?</h3>

                    <p>No problem! You can edit your order anytime you like before you make your purchase.
                    <br>You can change your vehicle's colour by clicking <a href="{{ url('/render_model/1') }}">here</a>. <?php // TODO: Change URLs to point to last vehicle viewed ?>
                    <br>Or you can select a new vehicle by clicking <a href="{{ url('/select') }}">here</a>.</p>
                    <br>
                    <br>

                    <h3 style="color: gray;">Stay in touch</h3>
                    <input type="checkbox" name="" value=""> <label>Receive notifications from your local dealership</label>
                    <br>
                    <input type="checkbox" name="" value=""> <label>Receive occasional promotions from your local dealership</label>

                    <br>
                    <br>
                    <button type="button" name="button" class="btn" onclick="document.location.href='{{ url('/') }}'">Done</button>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
