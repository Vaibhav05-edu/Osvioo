@extends('layouts.master')
@section('content')

<div class="row justify-content-center">
    <div class="col-xl-8 col-lg-8 col-md-10">
        <div class="i-card-md ">
            <div class="card-header">

                <div class="image avatar-md">
                    <img src='{{imageURL(@$log->method->file,"payment_method",true)}}' alt="{{@$log->method->file->name ?? @$log->method->name.'.jpg'}}" >
                </div>
                <h4 class="card-title">
                    {{@$log->method->name}}
               </h4>

            </div>
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-12">
                        <ul class="payment-details list-group">
                            <li class="list-group-item">
                                <p>
                                    {{translate('You have to pay')}}:
                                </p>
                               <h6>{{num_format($log->final_amount,$log->method->currency)}}  </h6>

                            </li>
                            <li class="list-group-item">
                                <p>
                                    {{translate('You will get')}}:
                                </p>

                                <h6>{{num_format($log->amount,$log->currency)}}</h6>
                            </li>
                        </ul>


                        <form action="{{$data->url}}" method="{{$data->method}}" id="razorpay-form" class="form mt-4">
                            @csrf
                            <input type="hidden" custom="{{$data->custom}}" name="hidden">
                            <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
                            <input type="hidden" name="razorpay_order_id" id="razorpay_order_id" value="{{ $data->val['order_id'] }}">
                            <input type="hidden" name="razorpay_signature" id="razorpay_signature">
                            
                            <button type="button" id="rzp-button1" class="i-btn btn--lg btn--primary w-100">
                                {{translate('Pay Now')}}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script-push')
<script nonce="{{ csp_nonce() }}" src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script nonce="{{ csp_nonce() }}">
    "use strict";
    $(document).ready(function () {
        var options = {
            "key": "{{ $data->val['key'] }}",
            "amount": "{{ $data->val['amount'] }}",
            "currency": "{{ $data->val['currency'] }}",
            "name": "{{ $data->val['name'] }}",
            "description": "{{ $data->val['description'] }}",
            "image": "{{ $data->val['image'] }}",
            "order_id": "{{ $data->val['order_id'] }}",
            "handler": function (response){
                $('#razorpay_payment_id').val(response.razorpay_payment_id);
                $('#razorpay_signature').val(response.razorpay_signature);
                $('#razorpay-form').submit();
            },
            "prefill": {
                "name": "{{ $data->val['prefill.name'] }}",
                "email": "{{ $data->val['prefill.email'] }}",
                "contact": "{{ $data->val['prefill.contact'] }}"
            },
            "theme": {
                "color": "{{ $data->val['theme.color'] }}"
            }
        };
        var rzp1 = new Razorpay(options);
        $('#rzp-button1').on('click', function(e){
            rzp1.open();
            e.preventDefault();
        });
    });
</script>

@endpush
