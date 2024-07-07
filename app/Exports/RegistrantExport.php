<?php

namespace App\Exports;

use App\Invoice;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SubmissionExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    use Exportable;

    public function __construct($request) {
        $this->session = $request->session();
    }

    public function headings(): array
    {
        return [
            'NIK',
            'Nama Lengkap',
            'Jenis Kelamin',
            'Tempat Tanggal Lahir',
            'No. Telp',
            'Alamat Lengkap',
            'Email',
            'Agama',
            'Status',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => [
                'font' => [
                    'bold' => true, 
                    'size' => 12,
                ],
            ],
            'L' => [
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                    // 'wrapText' => true,
                ],
            ],
            'K' => [
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                ],
            ]

            // // Styling a specific cell by coordinate.
            // 'B2' => ['font' => ['italic' => true]],
        ];
    }

    public function collection()
    {
        $fullname = $this->session->get('fullname') ? $this->session->get('fullname')[0] : false;
        $gender = $this->session->get('gender') ? $this->session->get('gender')[0] : false;
        $sub_district = $this->session->get('sub_district') ? $this->session->get('sub_district')[0] : false;
        $village = $this->session->get('village') ? $this->session->get('village')[0] : false;
        $year = $this->session->get('year') ? $this->session->get('year')[0] : '';

        $where = ['employees.is_active' => 'Y'];
        
        if($fullname) {
            $where = ['employees.nik' => $fullname];
        }
        if($gender) {
            $where = ['employees.gender' => $gender];
        }

        $data = DB::table('employees')
        ->select('employees.nik', 'employees.fullname', 'emp_leaves.start_date', 'emp_leaves.end_date', 'emp_leaves.leave_type', 'emp_leaves.approved1', 'emp_leaves.approved1_by', 'emp_leaves.approved2', 'emp_leaves.approved2_by',
        DB::raw('(CASE WHEN employees.gender = "M" THEN "Laki-laki" ELSE "Perempuan" END) AS gender'),
        DB::raw("CONCAT(employees.place_of_birth, \" - \", DATE_FORMAT(employees.date_of_birth, '%d/%m/%Y')) AS ttl"),
        DB::raw("CONCAT(\"'\", employees.phone) AS phone"),
        'employees.address', 'employees.email', 'employees.religion','employees.material_status'
        )
        ->join('emp_leaves', 'employees.nik', '=', 'emp_leaves.emp_nik')
        ->where($where)
        ->where('employees.created_at', 'LIKE', '%' . $year . '%')
        ->get();

        return $data;
    }
}