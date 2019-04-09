@extends('layouts.layout_app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <!-- <div class="card-header">Account Details: {{Auth::user()->id}}</div> -->
                <div title = "Back To The Homepage" class="card-header">Account Details: {{Auth::user()->fname}} {{Auth::user()->lname}}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- User Details -->
                    <!-- Customer records shall have the fields:
                    20-Digit Customer ID,
                    Name,
                    Date of Birth,
                    Gender,
                    Address,
                    Phone Number,
                    Email,
                    Billing Information,
                    Last Vehicle purchased,
                    Last Vehicle year,
                    Last Vehicle colour,
                    Desired Model,
                    Designed Colour,
                    Desired Price Range and
                    Desired payment method. -->


                    <!-- TODO change from home -->
                    <form action="/home/" method="post">
                      {{@csrf_field()}}
                        {{ method_field('PATCH') }}
                      <br>

                      @if (false)
                      <?php // TODO: Delete everything between these if tags ?>
                      <!-- First and Last Name -->
                      <div class="field">
                        <div class="control">
                          <label class="label col-md-3">Name</label>
                          <input disabled class="input" type="text" value="{{ Auth::user()->fname}} {{ Auth::user()->lname }}" name="name">
                        </div>
                      </div>

                      <!-- <div class="h-divider"></div> -->

                      <!-- Date of Birth -->
                      <div class="field">
                        <div class="control">
                          <label class="label col-md-3">Date of Birth</label>
                          <input disabled class="date" type="date" value="{{ Auth::user()->dob}}" name="dob">
                        </div>
                      </div>

                      <!-- <div class="h-divider"></div> -->

                      <!-- Gender -->
                      <div class="field">
                        <div class="control">
                          <label class="label col-md-3">Gender</label>
                          <input disabled class="text" type="text" value="{{ Auth::user()->gender}}" name="gender">
                        </div>
                      </div>

                      <!-- <div class="h-divider"></div> -->
                      <?php // TODO: Delete everything between these if tags ?>
                      @endif

                      <!-- Address -->
                      <!-- TODO Ensure Required -->
                      <div class="field">
                        <div class="control">
                          <label class="label col-md-3">Address</label>
                          <input required class="text" type="text" value="{{ Auth::user()->address}}" name="address">
                        </div>
                      </div>

                      <!-- <div class="h-divider"></div> -->
                      <!-- TODO seperate in day phone and night phone -->
                      <!-- Phone Number -->
                      <!-- TODO Number Valid Check -->
                      <div class="field">
                        <div class="control">
                          <label class="label col-md-3">Day Phone Number</label>
                          <input required class="text" type="number" value="{{ Auth::user()->day_phone_number}}" name="day_phone_number">
                        </div>
                      </div>

                      <!-- <div class="h-divider"></div> -->
                      <!-- TODO seperate in day phone and night phone -->
                      <!-- Phone Number -->
                      <!-- TODO Number Valid Check -->
                      <div class="field">
                        <div class="control">
                          <label class="label col-md-3">Night Phone Number</label>
                          <input required class="text" type="number" value="{{ Auth::user()->night_phone_number}}" name="night_phone_number">
                        </div>
                      </div>

                      <!-- <div class="h-divider"></div> -->

                      <!-- Email -->
                      <!-- TODO Email Valid Check -->
                      <div class="field">
                        <div class="control">
                          <label class="label col-md-3">Email</label>
                         <input required class="text" type="email" value="{{ Auth::user()->email}}" name="email">
                        </div>
                      </div>

                      <!-- <div class="h-divider"></div> -->

                      <!-- Billing Info -->
                      <div class="field">
                        <div class="control">
                          <label class="label col-md-3">Billing Information</label>
                           <input class="text" type="text" value="{{$customer->billingInfo}}" name="billingInfo">
                        </div>
                      </div>

                      <div class="h-divider"></div>

                      <!-- Previous Vehicle -->
                      <!-- Not Required -->
                      <div class="field">
                        <div class="control">
                          <label class="label col-md-3">Previous Vehicle</label>
                           <input class="text" type="text" value="{{ $customer->lastVehiclePurchased}}" name="lastVehiclePurchased">
                        </div>
                      </div>

                      <!-- <div class="h-divider"></div> -->

                      <!-- Previous Vehicle Year -->
                      <!-- Not Required -->
                      <!-- TODO validate year -->
                      <div class="field">
                        <div class="control">
                          <label class="label col-md-3">Previous Vehicle Model Year</label>
                          <input class="text" type="number" value="{{ $customer->lastVehicleYear}}" name="lastVehicleYear">
                        </div>
                      </div>

                      <!-- <div class="h-divider"></div> -->

                      <!-- Previous Vehicle Colour -->
                      <!-- Not Required -->
                      <div class="field">
                        <div class="control">
                          <label class="label col-md-3">Previous Vehicle Model Colour</label>
                          <input class="text" type="text" value="{{ $customer->lastExterior}}" name="lastExterior">
                        </div>
                      </div>

                      <div class="h-divider"></div>

                      <!-- Desired Model -->
                      <!-- Not Required -->
                      <div class="field">
                        <div class="control">
                          <label class="label col-md-3">Desired Model</label>
                          <input class="text" type="text" value="{{ $customer->desiredModel}}" name="desiredModel">
                        </div>
                      </div>

                      <!-- <div class="h-divider"></div> -->

                      <!-- Desired Model Colour -->
                      <!-- Not Required -->
                      <div class="field">
                        <div class="control">
                          <label class="label col-md-3">Desired Model Colour</label>
                          <input class="text" type="text" value="{{ $customer->desiredExterior}}" name="desiredExterior">
                        </div>
                      </div>

                      <!-- <div class="h-divider"></div> -->

                      <!-- Desired Price Range -->
                      <!-- Not Required -->
                      <div class="field">
                        <div class="control">
                          <label class="label col-md-3">Desired Price Range</label>
                          <input class="text" type="text" value="{{ $customer->desiredPrice}}" name="desiredPrice">
                        </div>
                      </div>

                      <!-- <div class="h-divider"></div> -->


                      <div class="h-divider"></div>
                      <br>
                      <div style="text-align:center;">
                        <button title = "Update Your Info!" class="btn" type="submit">Update</button>
                      </div>

                    </form>

                    @include('error')

                </div>
            </div>
        </div>
    </div>
</div>
@stop
