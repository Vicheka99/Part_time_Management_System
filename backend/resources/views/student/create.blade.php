<form action="{{ route('store.student') }}" method="POST" class="student-form">
    @csrf

    <div class="student-form-header">
        <div>
            <strong>Add New Student</strong>
            <small>Create a student account and assign their enrollment details.</small>
        </div>
        <span>{{ $nextStudentId ?? 'New student' }}</span>
    </div>

    <div class="student-form-body">
        <label>
            <span>First Name</span>
            <input type="text" name="first_name" value="{{ old('first_name') }}" placeholder="Emma" required>
        </label>
        <label>
            <span>Last Name</span>
            <input type="text" name="last_name" value="{{ old('last_name') }}" placeholder="Johnson" required>
        </label>
        <label>
            <span>Email Address</span>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="emma@student.edu" required>
        </label>
        <label>
            <span>Username</span>
            <input type="text" name="username" value="{{ old('username') }}" placeholder="emma.johnson" required>
        </label>
        <label>
            <span>Class / Grade</span>
            <select name="course_id" required>
                <option value="">Select class</option>
                @foreach ($courses as $course)
                    <option value="{{ $course->id }}" {{ (string) old('course_id') === (string) $course->id ? 'selected' : '' }}>{{ $course->title }}</option>
                @endforeach
            </select>
        </label>
        <fieldset>
            <legend>Gender</legend>
            <div class="student-choice-group">
                <label><input type="radio" name="gender" value="Male" {{ old('gender') === 'Male' ? 'checked' : '' }} required><span>Male</span></label>
                <label><input type="radio" name="gender" value="Female" {{ old('gender') === 'Female' ? 'checked' : '' }}><span>Female</span></label>
            </div>
        </fieldset>
        <label>
            <span>Status</span>
            <select name="status" required>
                <option value="Active" {{ old('status', 'Active') === 'Active' ? 'selected' : '' }}>Active</option>
                <option value="At Risk" {{ old('status') === 'At Risk' ? 'selected' : '' }}>At Risk</option>
                <option value="Inactive" {{ old('status') === 'Inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </label>
        <p class="student-form-note"><i class="mdi mdi-lock-outline"></i> Default password: <strong>Student12345</strong></p>
    </div>
    <div class="student-form-actions">
        <button type="button" class="btn student-cancel-button" data-bs-dismiss="modal">Cancel</button>
        <button class="btn student-add-button">Add Student</button>
    </div>
</form>
