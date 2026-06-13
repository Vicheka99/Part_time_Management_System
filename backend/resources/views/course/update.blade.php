<form action="{{ route('update.course', $course->id) }}" method="POST" class="student-form course-form">
    @csrf
    @method('PUT')

    <div class="student-form-header">
        <div>
            <strong>Edit Course</strong>
            <small>Update the course teacher, pricing, and semester dates.</small>
        </div>
        <span>Course {{ str_pad($course->id, 2, '0', STR_PAD_LEFT) }}</span>
    </div>

    <div class="student-form-body">
        <label class="form-span-2">
            <span>Course Title</span>
            <input type="text" name="title" value="{{ old('title', $course->title) }}" required>
        </label>
        <label>
            <span>Teacher</span>
            <select name="teacher_id" required>
                @foreach ($teachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ (string) old('teacher_id', $course->user_id) === (string) $teacher->id ? 'selected' : '' }}>{{ $teacher->fullName() }}</option>
                @endforeach
            </select>
        </label>
        <label>
            <span>Course Price</span>
            <input type="number" name="price" value="{{ old('price', $course->price) }}" min="0" step="0.01" required>
        </label>
        <label>
            <span>Start Date</span>
            <input type="date" name="start_date" value="{{ old('start_date', $course->start_date) }}" required>
        </label>
        <label>
            <span>End Date</span>
            <input type="date" name="end_date" value="{{ old('end_date', $course->end_date) }}">
        </label>
    </div>

    <div class="student-form-actions">
        <button type="button" class="btn student-cancel-button" data-bs-dismiss="modal">Cancel</button>
        <button class="btn student-add-button">Save Changes</button>
    </div>
</form>
