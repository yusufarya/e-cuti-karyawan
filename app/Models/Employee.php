<?php

namespace App\Models;

use App\Models\Grade;
use App\Models\SubDistrict;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $primaryKey = 'nik';
    public $keyType = 'string';
    public $table = 'employees';
    public $timestamps = false;

    protected $fillable = [
        'nik',
        'fullname',
        'username',
        'gender',
        'phone', 
        'place_of_birth',
        'date_of_birth',
        'address',
        'is_active',
        'sub_district',
        'village',
        'email',
        'password',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
    ];
    
    public function sub_districts(): BelongsTo
    {
        return $this->belongsTo(SubDistrict::class, 'sub_district', 'id');
    }

    public function getUserProfile() {
        $nik = auth('employee')->user()->nik;
        $data = DB::table('employees')
            ->select('employees.*','sub_districts.name as sub_district_name', 'villages.name as village_name')
            ->leftJoin('sub_districts', 'employees.sub_district', '=', 'sub_districts.id')
            ->leftJoin('villages', 'employees.village', '=', 'villages.id')
            ->where(['nik' => $nik])
            ->first();
        return $data;
    }

    public function getUserProfileByNumber($nik) {
        $data = DB::table('employees')
            ->select('employees.*','sub_districts.name as sub_district_name', 'villages.name as village_name')
            ->leftJoin('sub_districts', 'employees.sub_district', '=', 'sub_districts.id')
            ->leftJoin('villages', 'employees.village', '=', 'villages.id')
            ->where(['nik' => $nik])
            ->first();
        return $data;
    }
}
