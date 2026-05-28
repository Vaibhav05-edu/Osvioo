@extends('layouts.master')
@section('content')
<div class="row">
    @forelse($addons as $addon)
    <div class="col-md-4 mb-4">
        <div class="card h-100 text-center">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0 text-white">{{$addon->title}}</h5>
            </div>
            <div class="card-body">
                <h3 class="card-title pricing-card-title">{{num_format($addon->price)}}</h3>
                <ul class="list-unstyled mt-3 mb-4">
                    <li>Type: <strong>{{ucwords(str_replace('_', ' ', $addon->type))}}</strong></li>
                    <li>Value: <strong>+{{$addon->value}}</strong></li>
                </ul>
                <button type="button" class="i-btn btn--primary btn--md capsuled w-100" data-bs-toggle="modal" data-bs-target="#purchaseModal{{$addon->id}}">{{translate('Purchase')}}</button>
            </div>
        </div>
    </div>

    <!-- Purchase Modal -->
    <div class="modal fade" id="purchaseModal{{$addon->id}}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{translate('Purchase Add-on')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('user.addon.purchase', $addon->uid)}}" method="POST">
                    @csrf
                    <div class="modal-body text-start">
                        <p>{{translate('You are about to purchase')}} <strong>{{$addon->title}}</strong> {{translate('for')}} {{num_format($addon->price)}}.</p>
                        <div class="mb-3">
                            <label class="form-label">{{translate('Select Payment Method')}}</label>
                            <select name="method_id" class="form-select" required>
                                @foreach($methods as $method)
                                    <option value="{{$method->id}}">{{$method->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{translate('Cancel')}}</button>
                        <button type="submit" class="btn btn-primary">{{translate('Pay Now')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="alert alert-info text-center">{{translate('No add-ons available in the marketplace currently.')}}</div>
    </div>
    @endforelse
</div>
@endsection
