<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Violation extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'violation_date',
        'license_plate',
        'full_name',
        'birth_year',
        'address',
        'violation_type',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'violation_date' => 'date',
        'birth_year' => 'integer',
    ];

    /**
     * Get the age of the person based on birth year.
     */
    public function getAgeAttribute(): int
    {
        return date('Y') - $this->birth_year;
    }

    /**
     * Scope to filter by license plate.
     */
    public function scopeByLicensePlate($query, $licensePlate)
    {
        return $query->where('license_plate', 'LIKE', "%{$licensePlate}%");
    }

    /**
     * Scope to filter by full name.
     */
    public function scopeByFullName($query, $fullName)
    {
        return $query->where('full_name', 'LIKE', "%{$fullName}%");
    }

    /**
     * Scope to filter by date range.
     */
    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('violation_date', [$startDate, $endDate]);
    }
}
