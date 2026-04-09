
<!DOCTYPE html>
<html lang="zxx">

@include('layouts.head')

<body>

@include('components.sidebar')
@include('components.header')

@php
    $photo = Auth::user()->photo;
    $path = public_path('uploads/profile/' . $photo);
    if (!$photo || !file_exists($path)) {
        $photoUrl = asset('uploads/profile/masterprofile.png');
    } else {
        $photoUrl = asset('uploads/profile/' . $photo);
    }
@endphp

<main class="nxl-container">        
<div class="container mt-5">
    <div class="card shadow-sm mb-4 p-4 text-center">
        @if(session('success'))
            <div class="alert alert-success d-flex align-items-center" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                <div>{{ session('success') }}</div>
            </div>
        @endif
        <!-- PROFILE PHOTO -->
        <div class="position-relative d-inline-block">
            <img src="{{ $photoUrl }}" 
                 class="rounded-circle border shadow" 
                 width="150" height="150" 
                 style="object-fit: cover;">

            <!-- Change Photo Button -->
            <form action="{{ route('change.photo') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label class="btn btn-primary btn-sm mt-3">
                    Change Profile Picture
                    <input type="file" name="photo" class="d-none" onchange="this.form.submit()">
                </label>
            </form>
        </div>

    </div>

    <!-- ACCOUNT INFORMATION -->
    <div class="card shadow-sm p-4">
        <h4 class="mb-3">Account Settings</h4>

        <form action="{{ route('update.Profile') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-bold">Full Name</label>
                <input type="text" name="fullname" class="form-control" 
                       value="{{ Auth::user()->fullname }}" required>
            </div>
            <hr>
            <h5 class="fw-bold mt-3 mb-3">Change Password</h5>
            @error('password')
                <small class="text-danger d-block">{{ $message }}</small>
            @enderror
        <div class="mb-3 position-relative">
            <label class="form-label">New Password</label>
            <input type="password" id="password" name="password" class="form-control pe-5" minlength="8">

            <span class="position-absolute" 
                onclick="togglePassword('password', 'iconPassword')"
                style="cursor:pointer; right:15px; top:55px;">
                <i id="iconPassword" class="bi bi-eye-slash"></i>
            </span>
        </div>
        <div class="mb-3 position-relative">
            <label class="form-label">Retype Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control pe-5" minlength="8">

            <span class="position-absolute"
                onclick="togglePassword('password_confirmation', 'iconPasswordConfirmation')"
                style="cursor:pointer; right:15px; top:55px;">
                <i id="iconPasswordConfirmation" class="bi bi-eye-slash"></i>
            </span>
        </div>
                    <button type="submit" class="btn btn-success w-100">
                        Save Changes
                    </button>
                </form>
            </div>
        </div>
@include('components.script')
</main>

<script>
function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    // Toggle tipe password <-> text
    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("bi-eye-slash");
        icon.classList.add("bi-eye");
    } else {
        input.type = "password";
        icon.classList.remove("bi-eye");
        icon.classList.add("bi-eye-slash");
    }
    
}
</script>

</body>
</html>