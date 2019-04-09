@extends('layouts.layout_app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <!-- <div class="card-header">Account Details: {{Auth::user()->id}}</div> -->
                <div class="card-header">Account Details: {{Auth::user()->fname}} {{Auth::user()->lname}}</div>

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

                    <!-- TODO Connect fields to a controller -->
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
                          <!--<input disabled class="input" type="text" value="<fname> <lname>" name="name"> -->
                        </div>
                      </div>

                      <div class="h-divider"></div>

                      <!-- Date of Birth -->
                      <div class="field">
                        <div class="control">
                          <label class="label col-md-3">Date of Birth</label>
                          <input disabled class="date" type="date" value="{{ Auth::user()->dob}}" name="dob">
                          <!--<input disabled class="date" type="date" value="2019-04-09" name="dob"> -->
                        </div>
                      </div>

                      <div class="h-divider"></div>

                      <!-- Gender -->
                      <div class="field">
                        <div class="control">
                          <label class="label col-md-3">Gender</label>
                          <input disabled class="text" type="text" value="{{ Auth::user()->gender}}" name="gender">
                        <!--   <input disabled class="text" type="text" value="java" name="gender">-->
                        </div>
                      </div>

                      <div class="h-divider"></div>
                      <?php // TODO: Delete everything between these if tags ?>
                      @endif

                      <!-- Address -->
                      <!-- TODO Ensure Required -->
                      <div class="field">
                        <div class="control">
                          <label class="label col-md-3">Address</label>
                          <!-- <input required disabled class="text" type="text" value="{{ Auth::user()->address}}" name="address"> -->
                          <input required class="text" type="text" value="24 Sussex Drive" name="address">
                        </div>
                      </div>

                      <div class="h-divider"></div>
                      <!-- TODO seperate in day phone and night phone -->
                      <!-- Phone Number -->
                      <!-- TODO Number Valid Check -->
                      <div class="field">
                        <div class="control">
                          <label class="label col-md-3">Day Phone Number</label>
                          <!--BUG why won't you update T.T  -->
                          <input required class="text" type="number" value="{{ Auth::user()->day_phone_number}}" name="day_phone_number">
                        <!--  <input required class="text" type="number" value="555-555-5555" name="phone">-->
                        </div>
                      </div>

                      <div class="h-divider"></div>

                      <!-- Email -->
                      <!-- TODO Email Valid Check -->
                      <div class="field">
                        <div class="control">
                          <label class="label col-md-3">Email</label>
                         <input required class="text" type="email" value="{{ Auth::user()->email}}" name="email">
                        <!--  <input required class="text" type="email" value="standin@email.com" name="phone"> -->
                        </div>
                      </div>

                      <div class="h-divider"></div>
                      <!--TODO start if block with the condtion that role == customer to display the following blocks-->
                      <!-- Billing Info -->
                      <div class="field">
                        <div class="control">
                          <label class="label col-md-3">Billing Information</label>
                           <input class="text" type="text" value="{{ Auth::user()->billing}}" name="billing">
                        <!--  <input required class="text" type="text" value="placeholder billing info" name="billing"> --?
                        </div>
                      </div>

                      <div class="h-divider"></div>

                      <!-- Previous Vehicle -->
                      <!-- Not Required -->
                      <div class="field">
                        <div class="control">
                          <label class="label col-md-3">Previous Vehicle</label>
                           <!-- <input class="text" type="text" value="{{ Auth::user()->pvehicle}}" name="pvehicle"> -->
                          <input class="text" type="text" value="placeholder vehicle" name="pvehicle">
                        </div>
                      </div>

                      <div class="h-divider"></div>

                      <!-- Previous Vehicle Year -->
                      <!-- Not Required -->
                      <!-- TODO validate year -->
                      <div class="field">
                        <div class="control">
                          <label class="label col-md-3">Previous Vehicle Model Year</label>
                          <!-- <input class="text" type="number" value="{{ Auth::user()->pvehicle_yr}}" name="pvehicle_yr"> -->
                         <input class="text" type="number" value="1900" name="pvehicle_yr">
                        </div>
                      </div>

                      <div class="h-divider"></div>

                      <!-- Previous Vehicle Colour -->
                      <!-- Not Required -->
                      <div class="field">
                        <div class="control">
                          <label class="label col-md-3">Previous Vehicle Model Colour</label>
                          <input class="text" type="text" value="{{ Auth::user()->pvehicle_colour}}" name="pvehicle_colour">
                          <!--  <input class="text" type="text" value="placeholder colour" name="pvehicle_colour"> -->
                        </div>
                      </div>

                      <div class="h-divider"></div>

                      <!-- Desired Model -->
                      <!-- Not Required -->
                      <div class="field">
                        <div class="control">
                          <label class="label col-md-3">Desired Model</label>
                          <input class="text" type="text" value="{{ Auth::user()->dvehicle}}" name="dvehicle">
                          <!-- <input class="text" type="text" value="placeholder desired model" name="dvehicle"> -->
                        </div>
                      </div>

                      <div class="h-divider"></div>

                      <!-- Desired Model Colour -->
                      <!-- Not Required -->
                      <div class="field">
                        <div class="control">
                          <label class="label col-md-3">Desired Model Colour</label>
                          <input class="text" type="text" value="{{ Auth::user()->dvehicle_colour}}" name="dvehicle_colour">
                        <!--  <input class="text" type="text" value="placeholder desired model colour" name="dvehicle_colour">-->
                        </div>
                      </div>

                      <div class="h-divider"></div>

                      <!-- Desired Price Range -->
                      <!-- Not Required -->
                      <div class="field">
                        <div class="control">
                          <label class="label col-md-3">Desired Price Range</label>
                          <input class="text" type="text" value="{{ Auth::user()->price}}" name="price">
                          <!-- <input class="text" type="text" value="placeholder desired model colour" name="price"> -->
                        </div>
                      </div>

                      <div class="h-divider"></div>


                      <div class="h-divider"></div>

                      <div>
                        <button class="btn" type="submit">Update</button>
                      </div>

                    </form>

                    @include('error')

                </div>
            </div>
        </div>
    </div>
</div>
@stop
