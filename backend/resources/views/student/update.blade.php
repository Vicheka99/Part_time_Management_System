<form action="{{ route('update.student', $student->id) }}" method="POST" class="student-form">
    @csrf
    @method('PUT')
    <input type="hidden" name="score" value="{{ $student->score }}">

    <div class="student-form-header">
        <div>
            <strong>Edit Student</strong>
            <small>Update the student's account and enrollment details.</small>
        </div>
        <span>STU-{{ str_pad($student->id, 4, '0', STR_PAD_LEFT) }}</span>
    </div>

    <div class="student-form-body">
        <label>
            <span>First Name</span>
            <input type="text" name="first_name" value="{{ old('first_name', $student->first_name) }}" required>
        </label>
        <label>
            <span>Last Name</span>
            <input type="text" name="last_name" value="{{ old('last_name', $student->last_name) }}" required>
        </label>
        <label>
            <span>Email Address</span>
            <input type="email" name="email" value="{{ old('email', $student->user?->email) }}" required>
        </label>
        <label>
            <span>Username</span>
            <input type="text" name="username" value="{{ old('username', $student->user?->username) }}" required>
        </label>
        <label>
            <span>Class / Grade</span>
            <select name="course_id" required>
                @foreach ($courses as $course)
                    <option value="{{ $course->id }}" {{ (string) old('course_id', $student->course_id) === (string) $course->id ? 'selected' : '' }}>{{ $course->title }}</option>
                @endforeach
            </select>
        </label>
        <label>
            <span>Status</span>
            <select name="status" required>
                @foreach (['Active', 'At Risk', 'Inactive'] as $status)
                    <option value="{{ $status }}" {{ old('status', $student->status) === $status ? 'selected' : '' }}>{{ $status }}</option>
                @endforeach
            </select>
        </label>
        <fieldset>
            <legend>Gender</legend>
            <div class="student-choice-group">
                <label><input type="radio" name="gender" value="Male" {{ old('gender', $student->gender) === 'Male' ? 'checked' : '' }} required><span>Male</span></label>
                <label><input type="radio" name="gender" value="Female" {{ old('gender', $student->gender) === 'Female' ? 'checked' : '' }}><span>Female</span></label>
            </div>
        </fieldset>
    </div>

    <div class="student-form-actions">
        <button type="button" class="btn student-cancel-button" data-bs-dismiss="modal">Cancel</button>
        <button class="btn student-add-button">Save Changes</button>
    </div>
</form>
