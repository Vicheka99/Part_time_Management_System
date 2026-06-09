<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Course extends Model
{
    /** @use HasFactory<\Database\Factories\CourseFactory> */
    use HasFactory;

    const TABLE_NAME = 'courses';
    const ID = 'id';
    const TITLE = 'title';
    const DESCRIPTION = 'description';
    const PRICE = 'price';
    const START_DATE = 'start_date';
    const END_DATE = 'end_date';
    const USER_ID = 'user_id';

    protected $fillable = [
        self::TITLE,
        self::DESCRIPTION,
        self::PRICE,
        self::START_DATE,
        self::END_DATE,
        self::USER_ID,
        self::DESCRIPTION
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
