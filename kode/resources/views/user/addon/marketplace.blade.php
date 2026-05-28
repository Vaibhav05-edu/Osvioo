@extends('layouts.master')
@section('content')

@if(session('success'))
<div class="alert alert-success rounded-3 mb-4">{{ session('success') }}</div>
@endif
@if(session('error'))
<div class="alert alert-danger rounded-3 mb-4">{{ session('error') }}</div>
@endif

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold mb-0" style="font-family: 'Outfit', sans-serif;">{{translate('Add-on Marketplace')}}</h3>
</div>

<div class="row g-4">
    @forelse($addons as $addon)
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 20px; overflow: hidden;">
            <div class="card-header text-white py-3" style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">
                <h5 class="mb-0 text-white fw-bold">{{$addon->title}}</h5>
            </div>
            <div class="card-body text-center p-4">
                <h2 class="fw-bold mb-1" style="color: #6366f1;">
                    {{ num_format($addon->price, base_currency()) }}
                </h2>
                <p class="text-muted mb-3" style="font-size: 0.9rem;">{{translate('One-time payment')}}</p>
                <ul class="list-unstyled text-start mt-3 mb-4">
                    <li class="mb-2">
                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                        <strong>{{translate('Type')}}:</strong> {{ucwords(str_replace('_', ' ', $addon->type))}}
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                        <strong>{{translate('Value')}}:</strong> +{{$addon->value}} {{$addon->type === 'credits' ? translate('Credits') : ''}}
                    </li>
                </ul>
                <button type="button" class="i-btn btn--primary btn--md w-100" style="border-radius: 12px;" data-bs-toggle="modal" data-bs-target="#purchaseModal{{$addon->id}}">
                    <i class="bi bi-bag-plus me-2"></i>{{translate('Purchase')}}
                </button>
            </div>
        </div>
    </div>

    {{-- Purchase Confirmation Modal --}}
    <div class="modal fade" id="purchaseModal{{$addon->id}}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 20px; border: none;">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">{{translate('Confirm Purchase')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('user.addon.purchase', $addon->uid)}}" method="POST">
                    @csrf
                    <div class="modal-body px-4 py-3">
                        <p class="mb-3">{{translate('You are about to purchase')}} <strong>{{$addon->title}}</strong> {{translate('for')}} <strong>{{ num_format($addon->price, base_currency()) }}</strong>.</p>
                        <div class="p-3 rounded-3" style="background: #f8f9ff; border: 1px solid #e0e7ff;">
                            <p class="mb-1 text-muted" style="font-size: 0.88rem;">
                                <i class="bi bi-wallet2 me-1 text-primary"></i>{{translate('Current Wallet Balance')}}:
                                <strong>{{ num_format(auth_user('web')->balance, base_currency()) }}</strong>
                            </p>
                            @if(auth_user('web')->balance < $addon->price)
                            <p class="mb-0 text-danger" style="font-size: 0.88rem;">
                                <i class="bi bi-exclamation-triangle me-1"></i>{{translate('Insufficient balance. Please deposit funds first.')}}
                            </p>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer border-0 px-4">
                        <button type="button" class="i-btn btn--light btn--md" data-bs-dismiss="modal">{{translate('Cancel')}}</button>
                        <button type="submit" class="i-btn btn--primary btn--md" {{ auth_user('web')->balance < $addon->price ? 'disabled' : '' }}>
                            <i class="bi bi-bag-check me-1"></i>
                            {{ auth_user('web')->balance < $addon->price ? translate('Insufficient Balance') : translate('Pay with Wallet') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="text-center py-5">
            <div class="mb-3" style="font-size: 4rem;">🛍️</div>
            <h5 class="fw-bold">{{translate('No Add-ons Available Yet')}}</h5>
            <p class="text-muted">{{translate('The admin has not added any add-ons to the marketplace yet. Check back soon!')}}</p>
        </div>
    </div>
    @endforelse
</div>

@endsection
