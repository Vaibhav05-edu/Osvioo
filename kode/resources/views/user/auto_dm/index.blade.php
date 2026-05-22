@extends('layouts.master')

@section('content')
<div class="row g-4">
    <div class="col-12">
        <div class="glass-card p-4 d-flex align-items-center justify-content-between" style="background: linear-gradient(135deg, #5D5AF1 0%, #3f3cbd 100%); color: white; border-radius: 20px;">
            <div>
                <h3 class="mb-1 fw-bold text-white">{{translate('Instagram Auto DM')}}</h3>
                <p class="mb-0 opacity-75">{{translate('Automate your replies and engage your followers instantly')}}</p>
            </div>
            <button class="btn btn-light capsuled px-4 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#addTriggerModal">
                <i class="bi bi-plus-lg me-2"></i> {{translate('Add New Trigger')}}
            </button>
        </div>
    </div>

    {{-- STATS CARDS --}}
    <div class="col-xl-4 col-md-6">
        <div class="glass-card p-4 border-0 shadow-sm h-100" style="background: #fff; border-radius: 20px;">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="icon-box bg--primary-soft text--primary" style="width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-lightning-charge-fill fs-24"></i>
                </div>
                <div>
                    <h5 class="mb-0 fw-bold">{{$triggers->count()}}</h5>
                    <p class="text-muted fs-12 mb-0">{{translate('Active Triggers')}}</p>
                </div>
            </div>
            <div class="progress" style="height: 6px;">
                <div class="progress-bar bg--primary" style="width: 75%"></div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="glass-card p-4 border-0 shadow-sm h-100" style="background: #fff; border-radius: 20px;">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="icon-box bg--success-soft text--success" style="width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-chat-left-text-fill fs-24"></i>
                </div>
                <div>
                    <h5 class="mb-0 fw-bold">{{$logs->where('status', 'success')->count()}}</h5>
                    <p class="text-muted fs-12 mb-0">{{translate('Replies Sent (Last 20)')}}</p>
                </div>
            </div>
            <div class="progress" style="height: 6px;">
                <div class="progress-bar bg-success" style="width: 90%"></div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="glass-card p-4 border-0 shadow-sm h-100" style="background: #fff; border-radius: 20px;">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="icon-box bg--info-soft text--info" style="width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-graph-up-arrow fs-24"></i>
                </div>
                <div>
                    <h5 class="mb-0 fw-bold">
                        @if($dmLimit == -1)
                            {{$dmUsedCount}} / {{translate('Unlimited')}}
                        @else
                            {{$dmUsedCount}} / {{$dmLimit}}
                        @endif
                    </h5>
                    <p class="text-muted fs-12 mb-0">{{translate('Plan DM Usage')}}</p>
                </div>
            </div>
            <div class="progress" style="height: 6px;">
                @if($dmLimit == -1)
                    <div class="progress-bar bg-info" style="width: 0%"></div>
                @else
                    <div class="progress-bar bg-info" style="width: {{ min(100, ($dmUsedCount / max(1, $dmLimit)) * 100) }}%"></div>
                @endif
            </div>
        </div>
    </div>

    {{-- TRIGGERS TABLE --}}
    <div class="col-lg-8">
        <div class="glass-card p-4 border-0 shadow-sm" style="background: #fff; border-radius: 24px;">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h5 class="fw-bold mb-0">{{translate('Your Automation Triggers')}}</h5>
            </div>
            <div class="table-responsive">
                <table class="table table--light">
                    <thead>
                        <tr>
                            <th>{{translate('Trigger Keyword')}}</th>
                            <th>{{translate('Account')}}</th>
                            <th>{{translate('Match')}}</th>
                            <th>{{translate('Status')}}</th>
                            <th>{{translate('Action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($triggers as $trigger)
                            <tr>
                                <td>
                                    <div class="fw-bold">{{$trigger->keyword}}</div>
                                    <div class="d-flex align-items-center gap-2 mt-1">
                                        <div class="text-muted fs-11 text-truncate" style="max-width: 200px;">{{$trigger->reply_text}}</div>
                                        @if($trigger->steps->count() > 0)
                                            <span class="badge bg--primary-soft text--primary fs-10 capsuled">+{{$trigger->steps->count()}} {{translate('steps')}}</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if($trigger->socialAccount)
                                        <span class="badge bg-light text-dark capsuled border">
                                            <i class="bi bi-instagram text-danger me-1"></i> {{$trigger->socialAccount->name}}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary-soft text-secondary capsuled">{{translate('All Accounts')}}</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-info-soft text-info capsuled">{{strtoupper($trigger->match_type)}}</span>
                                </td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input status-toggle" type="checkbox" role="switch" data-uid="{{$trigger->uid}}" {{$trigger->status ? 'checked' : ''}}>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{route('user.social.auto_dm.destroy', $trigger->uid)}}" class="icon-btn danger circle" onclick="return confirm('Are you sure?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="opacity-50 mb-3">
                                        <i class="bi bi-robot fs-1" style="font-size: 50px !important;"></i>
                                    </div>
                                    <h6 class="text-muted">{{translate('No triggers found. Start by adding one!')}}</h6>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- RECENT LOGS --}}
    <div class="col-lg-4">
        <div class="glass-card p-4 border-0 shadow-sm" style="background: #fff; border-radius: 24px;">
            <h5 class="fw-bold mb-4">{{translate('Live Activity')}}</h5>
            <div class="activity-timeline">
                @forelse($logs as $log)
                    <div class="d-flex gap-3 mb-4 position-relative">
                        <div class="flex-shrink-0">
                            <div class="icon-sm {{ $log->status == 'success' ? 'bg-success-soft text-success' : 'bg-danger-soft text-danger' }} rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                <i class="bi {{ $log->status == 'success' ? 'bi-check-all' : 'bi-exclamation-circle' }}"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 border-bottom pb-3">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <h6 class="mb-0 fs-14 fw-bold">ID: {{$log->sender_id}}</h6>
                                <span class="fs-10 text-muted">{{$log->created_at->diffForHumans()}}</span>
                            </div>
                            <p class="mb-1 fs-12 text-muted">
                                <span class="fw-bold">"{{$log->received_message}}"</span> ⮕ 
                                <span class="text-success">{{$log->reply_sent}}</span>
                            </p>
                            <span class="fs-10 badge {{ $log->status == 'success' ? 'bg-success' : 'bg-danger' }}">{{strtoupper($log->status)}}</span>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-muted py-4">{{translate('No recent activity')}}</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- MODAL --}}
<div class="modal fade" id="addTriggerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0" style="border-radius: 24px;">
            <form action="{{route('user.social.auto_dm.store')}}" method="POST">
                @csrf
                <div class="modal-header border-0 p-4">
                    <h5 class="modal-title fw-bold">{{translate('New Auto DM Trigger')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 pt-0">
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{translate('Select Instagram Account')}}</label>
                        <select class="form-select capsuled" name="social_account_id">
                            <option value="">{{translate('All Instagram Accounts')}}</option>
                            @foreach($accounts as $account)
                                <option value="{{$account->id}}">{{$account->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{translate('Trigger Keyword')}}</label>
                        <input type="text" class="form-control capsuled" name="keyword" placeholder="e.g. Price, Help, Info" required>
                        <p class="fs-11 text-muted mt-1">{{translate('Message from user that will trigger this reply')}}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{translate('Match Type')}}</label>
                        <select class="form-select capsuled" name="match_type">
                            <option value="exact">{{translate('Exact Match')}}</option>
                            <option value="contains">{{translate('Contains Keyword')}}</option>
                            <option value="start_with">{{translate('Starts With')}}</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{translate('Automated Reply Message')}}</label>
                        <textarea class="form-control" name="reply_text" rows="4" placeholder="{{translate('Enter the message you want to send automatically')}}" required></textarea>
                    </div>

                    <hr class="my-4">
                    <div class="mb-3">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <label class="form-label fw-bold mb-0">{{translate('Follow-up Steps (Sequential Flow Builder)')}}</label>
                            <button type="button" class="btn btn-sm btn-outline-primary capsuled px-3" id="addStepBtn">
                                <i class="bi bi-plus-circle me-1"></i> {{translate('Add Step')}}
                            </button>
                        </div>
                        <p class="fs-11 text-muted mb-3">{{translate('Configure consecutive messages sent after the initial reply with custom delay times.')}}</p>
                        
                        <div id="stepsContainer" class="d-flex flex-column gap-3">
                            {{-- Dynamic steps will be injected here --}}
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light capsuled px-4" data-bs-dismiss="modal">{{translate('Cancel')}}</button>
                    <button type="submit" class="btn btn--primary capsuled px-4 fw-bold shadow-sm">{{translate('Create Automation')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script-push')
<script nonce="{{ csp_nonce() }}">
    $(document).on('change', '.status-toggle', function() {
        let uid = $(this).data('uid');
        $.post("{{route('user.social.auto_dm.update.status')}}", {
            _token: "{{csrf_token()}}",
            uid: uid
        }, function(res) {
            if(res.status) {
                // Success toast or notification
            }
        });
    });

    (function($) {
        "use strict";
        let stepCount = 0;
        $('#addStepBtn').on('click', function() {
            let stepHtml = `
                <div class="step-card p-3 border rounded-3 position-relative mb-2" style="background-color: #f9f9fc;">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="badge bg-primary-soft text-primary fw-bold px-2 py-1 fs-11">{{translate('Step')}} \${stepCount + 2}</span>
                        <button type="button" class="btn-close remove-step-btn" style="font-size: 0.8rem;"></button>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-9">
                            <label class="form-label fs-12 fw-bold mb-1">{{translate('Reply Message')}}</label>
                            <textarea class="form-control" name="steps[\${stepCount}][reply_text]" rows="2" placeholder="{{translate('Enter step message...')}}" required></textarea>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fs-12 fw-bold mb-1">{{translate('Delay (Seconds)')}}</label>
                            <input type="number" class="form-control" name="steps[\${stepCount}][delay_seconds]" min="0" value="10" placeholder="e.g. 10" required>
                        </div>
                    </div>
                </div>
            `;
            $('#stepsContainer').append(stepHtml);
            stepCount++;
        });

        $(document).on('click', '.remove-step-btn', function() {
            $(this).closest('.step-card').remove();
            reorderSteps();
        });

        function reorderSteps() {
            stepCount = 0;
            $('#stepsContainer .step-card').each(function() {
                let index = stepCount;
                $(this).find('.badge').text(`{{translate('Step')}} \${index + 2}`);
                $(this).find('textarea').attr('name', `steps[\${index}][reply_text]`);
                $(this).find('input').attr('name', `steps[\${index}][delay_seconds]`);
                stepCount++;
            });
        }
    })(jQuery);
</script>
@endpush
