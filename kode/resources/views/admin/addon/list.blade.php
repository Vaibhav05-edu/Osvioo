@extends('admin.layouts.master')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">{{translate('Manage Add-ons')}}</h4>
                <button type="button" class="i-btn btn--primary btn--md capsuled" data-bs-toggle="modal" data-bs-target="#addModal">{{translate('Add New')}}</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>{{translate('Title')}}</th>
                                <th>{{translate('Type')}}</th>
                                <th>{{translate('Price')}}</th>
                                <th>{{translate('Value')}}</th>
                                <th>{{translate('Status')}}</th>
                                <th>{{translate('Actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($addons as $addon)
                            <tr>
                                <td>{{$addon->title}}</td>
                                <td>{{ucwords(str_replace('_', ' ', (string)$addon->type))}}</td>
                                <td>{{num_format((float)$addon->price)}}</td>
                                <td>{{$addon->value}}</td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input addon-status-update" type="checkbox" data-id="{{$addon->id}}" @if($addon->status == 1) checked @endif>
                                    </div>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-info text-white editBtn" data-addon='@json($addon)'><i class="bi bi-pencil"></i></button>
                                    <a href="{{route('admin.addon.destroy', $addon->id)}}" class="btn btn-sm btn-danger text-white"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">{{translate('No add-ons found')}}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{$addons->links()}}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{translate('Add New Add-on')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('admin.addon.store')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">{{translate('Title')}}</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{translate('Type')}}</label>
                        <select name="type" class="form-select" required>
                            <option value="extra_account">{{translate('Extra Social Account')}}</option>
                            <option value="extra_media_kit">{{translate('Extra Media Kit')}}</option>
                            <option value="credits">{{translate('Credits')}}</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{translate('Value (e.g., Number of accounts)')}}</label>
                        <input type="number" name="value" class="form-control" value="1" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{translate('Price')}}</label>
                        <input type="number" name="price" class="form-control" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{translate('Status')}}</label>
                        <select name="status" class="form-select" required>
                            <option value="1">{{translate('Active')}}</option>
                            <option value="2">{{translate('Inactive')}}</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{translate('Cancel')}}</button>
                    <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{translate('Edit Add-on')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('admin.addon.update')}}" method="POST">
                @csrf
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">{{translate('Title')}}</label>
                        <input type="text" name="title" id="edit_title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{translate('Type')}}</label>
                        <select name="type" id="edit_type" class="form-select" required>
                            <option value="extra_account">{{translate('Extra Social Account')}}</option>
                            <option value="extra_media_kit">{{translate('Extra Media Kit')}}</option>
                            <option value="credits">{{translate('Credits')}}</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{translate('Value')}}</label>
                        <input type="number" name="value" id="edit_value" class="form-control" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{translate('Price')}}</label>
                        <input type="number" name="price" id="edit_price" class="form-control" step="0.01" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{translate('Cancel')}}</button>
                    <button type="submit" class="btn btn-primary">{{translate('Update')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script-push')
<script nonce="{{ csp_nonce() }}">
(function($){
    "use strict";

    $(document).on('click', '.editBtn', function() {
        var addon = $(this).data('addon');
        $('#edit_id').val(addon.id);
        $('#edit_title').val(addon.title);
        $('#edit_type').val(addon.type);
        $('#edit_value').val(addon.value);
        $('#edit_price').val(addon.price);
        $('#editModal').modal('show');
    });

    $(document).on('change', '.addon-status-update', function() {
        var id = $(this).data('id');
        var url = "{{route('admin.addon.update.status')}}";
        var token = "{{csrf_token()}}";
        $.ajax({
            type: "POST",
            url: url,
            data: {
                '_token': token,
                'id': id
            },
            success: function(response) {
                toastr.success(response.message);
            },
            error: function(response) {
                toastr.error(response.responseJSON.message);
            }
        });
    });
})(jQuery);
</script>
@endpush
