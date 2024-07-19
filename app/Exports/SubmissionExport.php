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
            'NIK Karyawan',
            'Nama Lengkap',
            'Jenis Kelamin',
            'Jenis Pengajuan',
            'Dari Tanggal',
            'Sampai Tanggal',
            'Persetujuan 1',
            'Disetujui Oleh',
            'Persetujuan 2',
            'Disetujui Oleh',
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
            'D' => [
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                    // 'wrapText' => true,
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
        ->select('employees.nik', 'employees.fullname', 
        DB::raw('(CASE WHEN employees.gender = "M" THEN "Laki-laki" ELSE "Perempuan" END) AS gender'),
        'emp_leaves.leave_type', 'emp_leaves.start_date', 'emp_leaves.end_date', 
        DB::raw('(CASE WHEN emp_leaves.approved1 = "Y" THEN "Pengajuan Disetujui" 
            WHEN emp_leaves.approved1 = "X" THEN "Menunggu Persetujuan" 
            ELSE "Pengajuan Ditolak" 
        END) AS approved1'), 
        'emp_leaves.approved1_by',
        DB::raw('(CASE 
            WHEN emp_leaves.approved1 = "N" THEN "-"
            WHEN emp_leaves.approved2 = "X" THEN "Menunggu Persetujuan"
            WHEN emp_leaves.approved2 = "Y" THEN "Pengajuan Disetujui"
            WHEN emp_leaves.approved2 = "N" THEN "Pengajuan Ditolak"
            ELSE "-"
        END) AS approved2'),
        'emp_leaves.approved2_by'
        )
        ->join('emp_leaves', 'employees.nik', '=', 'emp_leaves.emp_nik')
        ->where($where)
        ->where('employees.created_at', 'LIKE', '%' . $year . '%')
        ->get();

        return $data;
    }
}