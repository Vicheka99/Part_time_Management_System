<form action="{{ route('store.user') }}" method="POST" enctype="multipart/form-data" class="student-form teacher-form">
    @csrf
    <div class="student-form-header">
        <div><strong>Add New Teacher</strong><small>Enter personal details and login credentials.</small></div>
        <span>New Teacher</span>
    </div>
    <div class="student-form-body">
        <label><span>First Name</span><input type="text" name="first_name" placeholder="James" required></label>
        <label><span>Last Name</span><input type="text" name="last_name" placeholder="Wilson" required></label>
        <label><span>Email Address</span><input type="email" name="email" placeholder="james@school.edu" required></label>
        <label><span>Password</span><input type="password" name="password" placeholder="Minimum 8 characters" required></label>
        <fieldset><legend>Gender</legend><div class="student-choice-group">
            <label><input type="radio" name="gender" value="Male" required><span>Male</span></label>
            <label><input type="radio" name="gender" value="Female"><span>Female</span></label>
        </div></fieldset>
        <label class="teacher-profile-field"><span>Profile Photo</span><input type="file" name="profile" id="profile" accept="image/*"><input type="hidden" name="profile_name" id="profile_name"></label>
        <button type="button" class="teacher-profile-preview preview-profile"><img src="{{ asset('assets/images/uploadimage.jpg') }}" id="show-profile" alt=""><span>Choose profile photo</span></button>
    </div>
    <div class="student-form-actions">
        <button type="button" class="btn student-cancel-button" data-bs-dismiss="modal">Cancel</button>
        <button class="btn student-add-button">Add Teacher</button>
    </div>
</form>
