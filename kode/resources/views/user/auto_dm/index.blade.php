@extends('layouts.master')

@section('content')
<div class="row g-4">
    <div class="col-12">
        <div class="glass-card p-4 d-flex align-items-center justify-content-between" style="background: linear-gradient(135deg, #5D5AF1 0%, #3f3cbd 100%); color: white; border-radius: 20px;">
            <div>
                <h3 class="mb-1 fw-bold text-white">{{translate('Instagram Auto DM')}}</h3>
                <p class="mb-0 opacity-75">{{translate('Automate replies to direct messages or public comments on Reels and Posts instantly')}}</p>
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
                <table class="table table--light align-middle">
                    <thead>
                        <tr>
                            <th>{{translate('Trigger Keyword')}}</th>
                            <th>{{translate('Type & Target')}}</th>
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
                                    <div class="fw-bold fs-14">"{{$trigger->keyword}}"</div>
                                    <div class="mt-1">
                                        @if($trigger->trigger_type == 'comment_to_dm')
                                            <div class="fs-11 text-muted text-truncate" style="max-width: 250px;">
                                                <span class="text-primary fw-bold">{{translate('Comment reply:')}}</span> "{{$trigger->comment_reply_text}}"
                                            </div>
                                            <div class="fs-11 text-muted text-truncate mt-1" style="max-width: 250px;">
                                                <span class="text-info fw-bold">{{translate('Inbox DM:')}}</span> "{{$trigger->reply_text}}"
                                            </div>
                                        @else
                                            <div class="fs-11 text-muted text-truncate" style="max-width: 250px;">
                                                <span class="text-success fw-bold">{{translate('DM reply:')}}</span> "{{$trigger->reply_text}}"
                                            </div>
                                        @endif
                                        @if($trigger->steps->count() > 0)
                                            <span class="badge bg--primary-soft text--primary fs-10 capsuled mt-1">+{{$trigger->steps->count()}} {{translate('follow-up steps')}}</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if($trigger->trigger_type == 'comment_to_dm')
                                        <span class="badge bg-warning-soft text-warning capsuled fs-11">
                                            <i class="bi bi-chat-dots-fill me-1"></i> {{translate('Comment-to-DM')}}
                                        </span>
                                        @if($trigger->media_id)
                                            <div class="mt-1">
                                                <a href="{{$trigger->media_url}}" target="_blank" class="d-inline-flex align-items-center gap-1 fs-11 text-decoration-none text-primary fw-bold">
                                                    <i class="bi bi-link-45deg"></i> {{translate('View Target Post')}}
                                                </a>
                                            </div>
                                        @else
                                            <div class="fs-10 text-muted mt-1">
                                                <i class="bi bi-grid-fill me-1"></i> {{translate('All Reels / Posts')}}
                                            </div>
                                        @endif
                                    @else
                                        <span class="badge bg-success-soft text-success capsuled fs-11">
                                            <i class="bi bi-envelope-fill me-1"></i> {{translate('Inbox DM')}}
                                        </span>
                                    @endif
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
                                    <span class="badge bg-info-soft text-info capsuled">{{strtoupper($trigger->match_type ?? '')}}</span>
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
                                <td colspan="6" class="text-center py-5">
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
                                <h6 class="mb-0 fs-13 fw-bold text-truncate" style="max-width: 150px;">ID: {{$log->sender_id}}</h6>
                                <span class="fs-10 text-muted">{{optional($log->created_at)->diffForHumans()}}</span>
                            </div>
                            <p class="mb-1 fs-12 text-muted">
                                <span class="fw-bold">"{{ $log->received_message ?? '' }}"</span> ⮕ 
                                <span class="text-success">{{ $log->reply_sent ?? '' }}</span>
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
@endsection

@section('modal')
{{-- MODAL --}}
<div class="modal fade" id="addTriggerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0" style="border-radius: 24px;">
            <form action="{{route('user.social.auto_dm.store')}}" method="POST" id="addTriggerForm">
                @csrf
                <div class="modal-header border-0 p-4">
                    <h5 class="modal-title fw-bold">{{translate('New Auto DM Trigger')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 pt-0">
                    
                    {{-- AUTOMATION TYPE --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{translate('Automation Type')}}</label>
                        <select class="form-select capsuled" name="trigger_type" id="triggerTypeSelect" required>
                            <option value="inbox_dm">{{translate('Inbox Message (Trigger when someone DMs you)')}}</option>
                            <option value="comment_to_dm">{{translate('Comment on Reel/Post (Trigger when someone comments)')}}</option>
                        </select>
                    </div>

                    {{-- SOCIAL ACCOUNT --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold" id="accountSelectLabel">{{translate('Select Instagram Account')}}</label>
                        <select class="form-select capsuled" name="social_account_id" id="socialAccountIdSelect" required>
                            <option value="">{{translate('Choose Account...')}}</option>
                            @foreach($accounts as $account)
                                <option value="{{$account->id}}">{{$account->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- COMMENT AUTO-REPLY MESSAGE (ONLY FOR COMMENT-TO-DM) --}}
                    <div class="mb-3 d-none animate__animated animate__fadeIn" id="commentReplyGroup">
                        <label class="form-label fw-bold">{{translate('Public Comment Auto-Reply')}}</label>
                        <input type="text" class="form-control capsuled" name="comment_reply_text" id="commentReplyInput" placeholder="e.g. Sent you a DM! Check your inbox 📩">
                        <p class="fs-11 text-muted mt-1">{{translate('This text will instantly be posted as a comment reply under the commenter\'s comment.')}}</p>
                    </div>

                    {{-- POST TARGET TYPE (ONLY FOR COMMENT-TO-DM) --}}
                    <div class="mb-3 d-none animate__animated animate__fadeIn" id="postTargetGroup">
                        <label class="form-label fw-bold">{{translate('Target Post / Reel')}}</label>
                        <select class="form-select capsuled" name="post_target_type" id="postTargetTypeSelect">
                            <option value="all">{{translate('All Posts & Reels')}}</option>
                            <option value="specific">{{translate('Specific Post / Reel')}}</option>
                        </select>
                    </div>

                    {{-- SPECIFIC MEDIA SELECTOR (ONLY FOR SPECIFIC COMMENT-TO-DM) --}}
                    <div class="mb-3 d-none animate__animated animate__fadeIn" id="specificMediaSelectorGroup">
                        <label class="form-label fw-bold mb-2">{{translate('Choose Instagram Reel / Post')}}</label>
                        <input type="hidden" name="media_id" id="selectedMediaId">
                        <input type="hidden" name="media_url" id="selectedMediaUrl">

                        {{-- Spinner --}}
                        <div id="mediaLoadingSpinner" class="text-center py-4 d-none">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="text-muted mt-2 fs-12">{{translate('Fetching latest Reels and Posts...')}}</p>
                        </div>

                        {{-- Alert when no account selected --}}
                        <div id="mediaAlertMessage" class="alert alert-warning fs-12 p-3 rounded-3 mb-0">
                            <i class="bi bi-info-circle me-1"></i> {{translate('Please select a specific Instagram Account above to fetch media.')}}
                        </div>

                        {{-- Media Grid Container --}}
                        <div id="mediaListContainer" class="row g-2 overflow-y-auto px-1 d-none" style="max-height: 250px;">
                            {{-- Loaded media cards with templates will go here --}}
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label fw-bold">{{translate('Trigger Keyword')}}</label>
                                <input type="text" class="form-control capsuled" name="keyword" placeholder="e.g. Price, Help, Info" required>
                                <p class="fs-11 text-muted mt-1">{{translate('The comment or message word that will trigger this automation')}}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label fw-bold">{{translate('Match Type')}}</label>
                                <select class="form-select capsuled" name="match_type" required>
                                    <option value="exact">{{translate('Exact Match')}}</option>
                                    <option value="contains">{{translate('Contains Keyword')}}</option>
                                    <option value="start_with">{{translate('Starts With')}}</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold" id="dmReplyLabel">{{translate('Automated DM Message')}}</label>
                        <textarea class="form-control" name="reply_text" rows="3" placeholder="{{translate('Enter the initial message to be sent as a private DM')}}" required></textarea>
                    </div>

                    <hr class="my-4">
                    <div class="mb-3">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <label class="form-label fw-bold mb-0">{{translate('Follow-up Steps (Sequential DM Builder)')}}</label>
                            <button type="button" class="btn btn-sm btn-outline-primary capsuled px-3" id="addStepBtn">
                                <i class="bi bi-plus-circle me-1"></i> {{translate('Add Step')}}
                            </button>
                        </div>
                        <p class="fs-11 text-muted mb-3">{{translate('Configure additional consecutive private DMs sent after the initial DM with custom delays.')}}</p>
                        
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

        // Handle trigger type changes
        $('#triggerTypeSelect').on('change', function() {
            let val = $(this).val();
            if (val === 'comment_to_dm') {
                $('#commentReplyGroup').removeClass('d-none');
                $('#commentReplyInput').attr('required', true);
                $('#postTargetGroup').removeClass('d-none');
                $('#socialAccountIdSelect').attr('required', true);
                $('#accountSelectLabel').text("{{translate('Select Instagram Account (Required for Comments)')}}");
                $('#dmReplyLabel').text("{{translate('Automated DM Message (Sent to commenter)')}}");

                // Toggle specific post container based on target select
                if ($('#postTargetTypeSelect').val() === 'specific') {
                    $('#specificMediaSelectorGroup').removeClass('d-none');
                    triggerMediaFetch();
                }
            } else {
                $('#commentReplyGroup').addClass('d-none');
                $('#commentReplyInput').removeAttr('required').val('');
                $('#postTargetGroup').addClass('d-none');
                $('#socialAccountIdSelect').attr('required', false);
                $('#accountSelectLabel').text("{{translate('Select Instagram Account')}}");
                $('#dmReplyLabel').text("{{translate('Automated DM Message')}}");
                $('#specificMediaSelectorGroup').addClass('d-none');
            }
        });

        // Handle post target type changes
        $('#postTargetTypeSelect').on('change', function() {
            let val = $(this).val();
            if (val === 'specific') {
                $('#specificMediaSelectorGroup').removeClass('d-none');
                triggerMediaFetch();
            } else {
                $('#specificMediaSelectorGroup').addClass('d-none');
                clearMediaSelection();
            }
        });

        // Trigger media fetch on social account change
        $('#socialAccountIdSelect').on('change', function() {
            if ($('#triggerTypeSelect').val() === 'comment_to_dm' && $('#postTargetTypeSelect').val() === 'specific') {
                triggerMediaFetch();
            }
        });

        function clearMediaSelection() {
            $('#selectedMediaId').val('');
            $('#selectedMediaUrl').val('');
            $('#mediaListContainer .media-select-card').removeClass('border-primary bg-light-blue shadow-sm');
            $('#mediaListContainer .check-badge').addClass('d-none');
        }

        function triggerMediaFetch() {
            let accountId = $('#socialAccountIdSelect').val();
            if (!accountId) {
                $('#mediaAlertMessage').removeClass('d-none').text("{{translate('Please select a specific Instagram Account above to fetch media.')}}");
                $('#mediaListContainer').addClass('d-none');
                $('#mediaLoadingSpinner').addClass('d-none');
                clearMediaSelection();
                return;
            }

            $('#mediaAlertMessage').addClass('d-none');
            $('#mediaLoadingSpinner').removeClass('d-none');
            $('#mediaListContainer').addClass('d-none').empty();
            clearMediaSelection();

            $.get("/user/auto-dm/instagram-media/" + accountId, function(res) {
                $('#mediaLoadingSpinner').addClass('d-none');
                if (res.status && res.data && res.data.length > 0) {
                    let html = '';
                    res.data.forEach(function(item) {
                        let caption = item.caption ? item.caption : '';
                        if(caption.length > 60) {
                            caption = caption.substring(0, 57) + '...';
                        }
                        
                        let thumb = item.thumbnail_url ? item.thumbnail_url : item.media_url;
                        let icon = item.media_type === 'VIDEO' ? 'bi-play-circle-fill' : 'bi-image-fill';
                        
                        html += `
                            <div class="col-md-6 col-12">
                                <div class="media-select-card p-2 border rounded-3 d-flex gap-2 align-items-center position-relative cursor-pointer" 
                                     style="transition: all 0.2s ease; cursor: pointer;" 
                                     data-id="${item.id}" 
                                     data-url="${item.permalink}">
                                    <div class="position-relative" style="width: 50px; height: 50px; border-radius: 8px; overflow: hidden; background: #eee;">
                                        <img src="${thumb}" style="width: 100%; height: 100%; object-fit: cover;">
                                        <div class="position-absolute bottom-0 end-0 bg-dark text-white p-1 d-flex align-items-center justify-content-center" style="font-size: 8px; border-radius: 4px 0 0 0; opacity: 0.8;">
                                            <i class="bi ${icon}"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <div class="fs-11 fw-bold text-dark text-truncate">${item.media_type}</div>
                                        <div class="fs-10 text-muted text-truncate">${caption ? caption : 'No Caption'}</div>
                                    </div>
                                    <div class="check-badge position-absolute top-0 end-0 bg-primary text-white d-none" 
                                         style="width: 16px; height: 16px; border-radius: 50%; display: flex; align-items: center; justify-content: center; transform: translate(5px, -5px);">
                                        <i class="bi bi-check" style="font-size: 10px;"></i>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    $('#mediaListContainer').html(html).removeClass('d-none');
                } else {
                    $('#mediaAlertMessage').removeClass('d-none').text(res.message || "{{translate('No posts or reels found on this account.')}}");
                }
            }).fail(function() {
                $('#mediaLoadingSpinner').addClass('d-none');
                $('#mediaAlertMessage').removeClass('d-none').text("{{translate('Error occurred while fetching media. Make sure webhook and platform settings are valid.')}}");
            });
        }

        // Handle media card selection click
        $(document).on('click', '.media-select-card', function() {
            $('.media-select-card').removeClass('border-primary bg-light-blue shadow-sm');
            $('.media-select-card .check-badge').addClass('d-none');

            $(this).addClass('border-primary bg-light-blue shadow-sm');
            $(this).find('.check-badge').removeClass('d-none');

            $('#selectedMediaId').val($(this).data('id'));
            $('#selectedMediaUrl').val($(this).data('url'));
        });

        // Steps handling
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
