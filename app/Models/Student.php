<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    public $timestamps = true;
    use HasFactory;

    const TABLE_NAME = 'students';
    const ID = 'id';
    const FIRST_NAME = 'first_name';
    const LAST_NAME = 'last_name';
    const GENDER = 'gender';
    const SCORE = 'score';
    const STATUS = 'status';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const USER_ID = 'user_id';
    const COURSE_ID = 'course_id';

    protected $fillable = [
        self::FIRST_NAME,
        self::LAST_NAME,
        self::GENDER,
        self::SCORE,
        self::STATUS,
        self::CREATED_AT,
        self::UPDATED_AT,
        self::USER_ID,
        self::COURSE_ID
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function fullName()
    {
        return ($this->gender == 'Male' ? 'Mr. ' : 'Ms. ') . $this->first_name . ' ' . $this->last_name;
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
