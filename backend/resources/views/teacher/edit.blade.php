<form action="{{ route('update.user', $user->id) }}" method="POST" enctype="multipart/form-data" class="student-form teacher-form">
    @csrf
    @method('PUT')
    <div class="student-form-header">
        <div><strong>Edit Teacher</strong><small>Update personal details and profile photo.</small></div>
        <span>TCH-{{ str_pad($user->id, 3, '0', STR_PAD_LEFT) }}</span>
    </div>
    <div class="student-form-body">
        <label><span>First Name</span><input type="text" name="first_name" value="{{ $user->first_name }}" required></label>
        <label><span>Last Name</span><input type="text" name="last_name" value="{{ $user->last_name }}" required></label>
        <label class="form-span-2"><span>Email Address</span><input type="email" name="email" value="{{ $user->email }}" required></label>
        <fieldset><legend>Gender</legend><div class="student-choice-group">
            <label><input type="radio" name="gender" value="Male" {{ $user->gender === 'Male' ? 'checked' : '' }} required><span>Male</span></label>
            <label><input type="radio" name="gender" value="Female" {{ $user->gender === 'Female' ? 'checked' : '' }}><span>Female</span></label>
        </div></fieldset>
        <label class="teacher-profile-field"><span>Profile Photo</span><input type="file" name="profile" id="profile" accept="image/*"><input type="hidden" name="profile_name" value="{{ $user->profile }}" id="profile_name"></label>
        <button type="button" class="teacher-profile-preview preview-profile"><img src="{{ $user->profile ? asset('assets/images/teacher/' . $user->profile) : asset('assets/images/uploadimage.jpg') }}" id="show-profile" alt=""><span>{{ $user->profile ? 'Change' : 'Choose' }} profile photo</span></button>
    </div>
    <div class="student-form-actions">
        <button type="button" class="btn student-cancel-button" data-bs-dismiss="modal">Cancel</button>
        <button class="btn student-add-button">Save Changes</button>
    </div>
</form>
