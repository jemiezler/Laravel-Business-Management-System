<?php

namespace App\Models;

use App\Traits\HasJsonFallback;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformanceReview extends Model
{
    use HasFactory, HasJsonFallback;

    protected $fillable = [
        'employee_id',
        'reviewer_id',
        'review_date',
        'rating',
        'comments',
        'kpis',
    ];

    protected $casts = [
        'review_date' => 'date',
        'kpis' => 'json',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}
