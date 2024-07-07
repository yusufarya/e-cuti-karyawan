<?php

namespace App\Models;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CalculateEmpLeave extends Model
{
    use HasFactory;

    public $table = 'calculate_emp_leaves';
    public $guarded = ['id'];
    public $timestamps = false;

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'emp_nik', 'nik');
    }
}
