<?php

class Syllabus extends Model
{
    protected $table = 'syllabuses';
    protected $fillable = [
        'title', 'overview', 'learning_outcomes', 'topics_covered',
        'assessment_methods', 'grading_scale', 'recommended_resources',
        'prerequisites', 'duration', 'academic_year', 'subject_id',
        'class_id', 'status'
    ];
}
