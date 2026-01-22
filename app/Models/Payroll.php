<?php

namespace App\Models;

use App\Traits\HasJsonFallback;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory, HasJsonFallback;

    protected $table = 'payroll';

    protected $fillable = [
        'employee_id',
        'payment_date',
        'basic_salary',
        'allowances',
        'deductions',
        'net_salary',
        'status',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'basic_salary' => 'decimal:2',
        'allowances' => 'decimal:2',
        'deductions' => 'decimal:2',
        'net_salary' => 'decimal:2',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
