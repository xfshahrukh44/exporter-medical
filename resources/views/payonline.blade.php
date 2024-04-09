@extends('layouts.main')
@section('content')
@php
    $country = DB::table('countries')->get();
    $months = [1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'];
@endphp


 <div class="contanier">
    <div class="row">
        <div class="col-md-12">
            <div class="centercontent">
             
                <h1>Pay Online Form</h1>
                <form class="form" id="contactform">
                    @csrf
                    <input type="hidden" name="form_name" value="Pay Online">

                            <div class="row">
                     
                                 <div class="col-md-12">
                                        <h3>Personal Information</h3>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="billing-info input-style mb-35">
                                                <label>First Name *</label>
                                                <input type="text" id="f-name" name="fname" placeholder="First Name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="billing-info input-style mb-35">
                                                <label>Last Name *</label>
                                                <input type="text" id="l-name" name="lname" placeholder="Last Name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="billing-info input-style mb-35">
                                            <label>Email Address *</label>
                                            <input type="text" id="f-name" name="email" placeholder="Email Address" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="billing-info input-style mb-35">
                                                <label>Billing Address *</label>
                                                <input type="text" id="address" name="address" placeholder="Address" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="billing-info select-style mb-35">
                                        <label>Country *</label>
                                            <select class="select-active form-control" name="country" id="country">
                                                @foreach ($country as $item)
                                                    <option {{ $item->sortname == 'US' ? 'selected' : '' }}
                                                        value="{{ $item->sortname }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="billing-info input-style mb-35">
                                                <label>City *</label>
                                                <input type="text" id="city" name="city" placeholder="City" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="billing-info input-style mb-35">
                                                <label>State *</label>
                                                <input type="text" id="state" name="state" placeholder="State" required>
                                        </div>
                                    </div>
                                
                                    <div class="col-md-6 col-sm-12">
                                        <div class="billing-info input-style mb-35">
                                                <label>Zip *</label>
                                                <input type="text" id="zip" name="zip" placeholder="Zip Code" required>
                                        </div>
                                    </div>
                                    
                      
                        
                              

                                    <div class="col-md-12">
                                        <h3>Payment Details</h3>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="billing-info input-style mb-35">
                                                <label for="cc">Card Number</label>
                                                <input maxlength="16" type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" name="cc" placeholder="Card Number"
                                                    class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                    <div class="billing-info select-style mb-35">
                                            <label>Expriy Month</label>
                                            <select class="select-active form-control" id="expiration-month" name="month">
                                                @foreach ($months as $k => $v)
                                                    <option value="{{ $k }}"
                                                        {{ old('expiration-month') == $k ? 'selected' : '' }}>
                                                        {{ $v }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="billing-info select-style mb-35">
                                                <label>Expriy Year *</label>
                                                <select class="select-active form-control" name="expr" id="expiration-year">
                                                        @for ($i = date('Y'); $i <= date('Y') + 15; $i++)
                                                            <option value="{{ $i }}">
                                                                {{ $i }}</option>
                                                        @endfor
                                                </select>
                                        </div>
                                    </div>
                                 
                                    <div class="col-md-6 col-sm-12">
                                        <div class="billing-info input-style mb-35">
                                                <label for="cvv">CVV</label>
                                                    <input type="number" name="cvv" required placeholder="CVV" pattern="\d{3}"
                                                        class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="billing-info input-style mb-35">
                                                <label for="amount">Amount in ($)</label>
                                                <input type="number" name="amount" required step="0.01" class="form-control">
                                                
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12">
                                        <div class="billing-info input-style mb-35">
                                                <label for="amount">Description</label>
                                                <textarea required name="extra_content" id="" cols="30" rows="10"></textarea>


                                                
                                        </div>
                                    </div>
                      
                        
                        <div class="col-md-12">
                            <div class="center">
                                <div id="loader" style="display: none">
                                    <img src="{{ asset('images/loader.gif') }}">
                                </div>
                                <button id="payonlinebutn" class="formbtn">Submit</button>
                            </div>
                        </div>
                    
                       

                       
                    
                </form>
            </div>

        </div>
    </div>
   </div>




@endsection
@section('css')
   <style>
   .select2-selection__rendered {
        text-align: left;
    }
   h3{
    font-weight: 500;
   }
   button{
        display: inline-block;
        color: #ffffff;
        font-size: 15px;
        font-weight: bold;
        border: 0;
        border-radius: 50px;
        padding: 14px 42px 16px;
        background-color: #4e97fd;
   }
   button:hover{
    background: #e4573d;
   }
   input#invoice {
        padding: 0;
        height: 20px;
    }

    .form-check {
        margin-top: 7px;
        margin-left: 15px;
    }
    div#loader img {
            width: 60px;
        }
   form.form {
        width: 50%;
        margin-top: 35px;
    }

    form.form label {
        text-align: left;
        display: block;
        margin-bottom: 16px;
    }
    .centercontent {
        display: flex;
        justify-content: center;
        flex-direction: column;
        text-align: center;
        align-items: center;
        margin: 45px 0;
    }
    .centercontent h1 {
        font-family: 'Manrope';
        
        font-weight: 900;
    }
    .centercontent i {
        font-size: 9.75rem;
        font-weight: 900;
        color: #24b663;
    }
    .centercontent p {
        font-size: 16px;
        font-weight: 900;
        margin-top: 14px;
        width: 50%;
        
        font-style: italic;
    }
</style>
@endsection
