@extends('dashboard.layout.main')

@push('styles')
<style>

    .profile-container{
        display:flex;
        gap:25px;
        align-items:flex-start;
        flex-wrap:wrap;
        margin-top:20px;
    }

    /* LEFT CARD */
    .profile-sidebar{
        width:320px;
        background:#fff;
        border-radius:14px;
        box-shadow:0 2px 10px rgba(0,0,0,0.08);
        overflow:hidden;
        flex-shrink:0;
    }

    .profile-header{
        background:linear-gradient(135deg,#1e3a8a 0%,#3b82f6 100%);
        padding:30px 20px;
        text-align:center;
        color:#fff;
    }

    .profile-header img{
        width:100px;
        height:100px;
        border-radius:50%;
        object-fit:cover;
        border:4px solid #fff;
        margin-bottom:12px;
    }

    .profile-header h2{
        font-size:22px;
        margin-bottom:5px;
    }

    .profile-header p{
        font-size:13px;
        opacity:0.9;
    }

    .profile-body{
        padding:20px;
    }

    .info-item{
        margin-bottom:15px;
    }

    .info-label{
        font-size:13px;
        font-weight:600;
        color:#666;
        margin-bottom:5px;
    }

    .info-value{
        font-size:14px;
        color:#222;
        word-break:break-word;
    }

    /* RIGHT FORM */
    .profile-content{
        flex:1;
        min-width:320px;
        background:#fff;
        border-radius:14px;
        box-shadow:0 2px 10px rgba(0,0,0,0.08);
        padding:25px;
    }

    .section-title{
        font-size:22px;
        font-weight:700;
        margin-bottom:20px;
        color:#1e3a8a;
    }

    .form-row{
        display:flex;
        gap:20px;
        margin-bottom:20px;
        flex-wrap:wrap;
    }

    .form-group{
        flex:1;
        min-width:220px;
    }

    .form-group label{
        display:block;
        margin-bottom:8px;
        font-size:14px;
        font-weight:600;
        color:#444;
    }

    .form-control{
        width:100%;
        padding:12px 14px;
        border:1px solid #dcdcdc;
        border-radius:10px;
        font-size:14px;
        transition:0.3s;
    }

    .form-control:focus{
        outline:none;
        border-color:#3b82f6;
        box-shadow:0 0 0 3px rgba(59,130,246,0.15);
    }

    .upload-note{
        margin-top:8px;
        font-size:12px;
        color:#777;
    }

    .btn-save{
        background:linear-gradient(135deg,#1e3a8a 0%,#3b82f6 100%);
        color:#fff;
        border:none;
        padding:12px 20px;
        border-radius:10px;
        font-size:14px;
        font-weight:600;
        cursor:pointer;
        transition:0.3s;
    }

    .btn-save:hover{
        transform:translateY(-1px);
    }

    @media(max-width:768px){

        .profile-container{
            flex-direction:column;
        }

        .profile-sidebar{
            width:100%;
        }

        .profile-content{
            width:100%;
        }
    }

</style>
@endpush


@section('content')

<div class="profile-container mb-3">

    <!-- LEFT PROFILE CARD -->
    <div class="profile-sidebar">

       <div class="profile-header">

    <img 
    src="{{ 
        $user->profile_photo
            ? asset('storage/' . $user->profile_photo)
            : 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'User') . '&background=ffffff&color=1e3a8a&size=120&bold=true'
    }}"
    alt="Profile Photo"
>

    <h2>{{ $user->name ?? 'Not Set' }}</h2>

    <p>
        <i class="fas fa-gavel"></i>
        {{ ucfirst($user->role ?? 'Advocate') }}
    </p>

</div>

        <div class="profile-body">

            <div class="info-item">
                <div class="info-label">
                    <i class="fas fa-envelope"></i>
                    Email
                </div>

                <div class="info-value">
                    {{ isset($user->email) ? Crypt::decryptString($user->email) : 'Not Set' }}
                </div>
            </div>

            <div class="info-item">
                <div class="info-label">
                    <i class="fas fa-phone"></i>
                    Mobile
                </div>

                <div class="info-value">
                    {{ isset($user->contact_number) ? Crypt::decryptString($user->contact_number) : 'Not Set' }}
                </div>
            </div>

            <div class="info-item">
                <div class="info-label">
                    <i class="fas fa-id-card"></i>
                    Enrollment Number
                </div>

                <div class="info-value">
                    {{ $user->enrollment_number ?? 'Not Set' }}
                </div>
            </div>

            <div class="info-item">
                <div class="info-label">
                    <i class="fas fa-location-dot"></i>
                    Location
                </div>

                <div class="info-value">
                    {{ $user->district ?? '' }},
                    {{ $user->state ?? '' }}
                </div>
            </div>

        </div>

    </div>


    <!-- RIGHT FORM -->
    <div class="profile-content">

    <h3 class="section-title">
        Additional Advocate Details
    </h3>

    <form method="POST"
          action="{{ route('profile.update') }}"
          enctype="multipart/form-data">

        @csrf

        <div class="form-row">

            <div class="form-group">
                <label>
                    <i class="fas fa-image"></i>
                    Profile Photo
                </label>

                <input type="file"
                       name="profile_photo"
                       class="form-control"
                       accept=".jpg,.jpeg">

                <div class="upload-note">
                    Only JPG/JPEG allowed (20KB - 500KB)
                </div>
            </div>

        </div>


        <div class="form-row">

            <div class="form-group">
                <label>
                    <i class="fas fa-calendar"></i>
                    Date of Birth
                </label>

                <input type="date"
                       name="dob"
                       class="form-control"
                       value="{{ old('dob', $user->dob ?? '') }}">
            </div>


            <div class="form-group">
                <label>
                    <i class="fas fa-scale-balanced"></i>
                    Date of Enrollment
                </label>

                <input type="date"
                       name="date_of_enrollment"
                       class="form-control"
                       value="{{ old('date_of_enrollment', $user->date_of_enrollment ?? '') }}">
            </div>

        </div>


        <button type="submit" class="btn-save">
            <i class="fas fa-save"></i>
            Save Details
        </button>

    </form>

</div>

</div>

@endsection