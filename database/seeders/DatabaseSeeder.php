<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Period;
use App\Models\Setting;
use App\Models\Village;
use App\Models\UserLevel;
use App\Models\SubDistrict;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        UserLevel::create([
            'id' => '1',
            'name' => 'HR/GA',
        ]);
        
        UserLevel::create([
            'id' => '2',
            'name' => 'Divisi',
        ]);

        User::create([
            'nip' => 'HR202311050001',
            'fullname' => 'HR E CUTI',
            'username' => 'hr_123',
            'gender' => 'M',
            'phone' => '08986564321',
            'email' => 'hr@gmail.com',
            'password' => Hash::make('111111'),
            'level_id' => 1,
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => 'hr_123',
        ]);

        $sub_districs = [
            'Balaraja', 'Cikupa', 'Cisauk', 'Cisoka', 'Curug', 'Gunung Kaler', 'Jambe', 'Jayanti', 'Kelapa Dua', 'Kemiri', 'Kosambi', 'Kresek', 'Kronjo', 'Legok', 'Mauk', 'Mekar Baru', 'Pengadegan', 'Pakuhaji', 'Panongan', 'Pasar Kamis', 'Rajeg', 'Sepatan', 'Sepatan Timur', 'Sindang Jaya', 'Solear', 'Sukadiri', 'Sukamulya', 'Teluknaga', 'Tigaraksa'
        ];
        foreach ($sub_districs as $val) {
            SubDistrict::create(['name' => $val]);
        }
        
        $villages = [
            1 => [
                'Cangkudu','Gembong','Saga','Sentul','Jaya','Sukamurni','Talagasari','Tobat','Balaraja'
            ],
            2 => [
                'Bitung Jaya','Bojong','Budi Mulya','Cibadak','Cikupa','Dukuh','Pasir Gadung','Pasir Jaya','Sukadamai','Sukanagara','Talaga','Talagasari','Bunder','Sukamulya'
            ],
            3 => [
                'Cibogo', 'Dangdang', 'Mekar Wangi', 'Sampora', 'Suradita', 'Cisauk'
            ],
            4 => [
                'Bojong Loa','Carenang','Caringin','Cempaka','Cibugel','Cisoka','Jeungjing','Karangharja','Selapajang','Sukatani'
            ],
            5 => [
                'Cukanggalih','Curug Wetan','Kadu','Kadu Jaya','Binong','Curug Kulon','Sukabakti'
            ],
            6 => [
                'Cibetok','Cipaeh','Gunung Kaler','Kandawati','Kedung','Onyam','Rancagede','Sidoko','Tamiang'
            ],
            7 => [
                'Ancol Pasir','Daru','Jambe','Kutruk','Mekarsari','Pasir Barat','Ranca Buaya','Sukamanah','Taban','Tipar Raya'
            ],
            8 => [
                'Cikande','Dangdeur','Jayanti','Pabuaran','Pangkat','Pasir Gintung','Pasir Muncang','Sumurbandung'
            ],
            9 => [
                'Curug Sangereng','Bencongan','Bencongan Indah','Bojong Nangka','Kelapa Dua','Pakulonan Barat'
            ],
            10 => [
                'Karang Anyar','Kemiri','Klebet','Legok Suka Maju','Lontar','Patramanggala','Ranca Labuh'
            ],
            11 => [
                'Belimbing','Cengklong','Jati Mulya','Kosambi Timur','Rawa Burung','Rawa Rengas','Salembaran Jati','Dadap','Kosambi Barat','Salembaran Jaya'
            ],
            12 => [
                'Jengkol','Kemuning','Koper','Kresek','Pasir Ampo','Patrasana','Rancailat','Renged','Talok'
            ],
            13 => [
                'Bakung','Blukbuk','Cirumpak','Kronjo','Muncung','Pagedangan Ilir','Pagedangan Udik','Pagenjahan','Pasilian','Pasir'
            ],
            14 => [
                'Babat','Bojongkamal','Caringin','Ciangir','Cirarab','Kemuning','Legok','Palasari','Rancagong','Serdang Wetan','Babakan'
            ],
            15 => [
                'Banyu Asih','Gunung Sari','Jatiwaringin','Kedung Dalem','Ketapang','Marga Mulya','Mauk Barat','Sasak','Tanjung Anom','Tegal Kunir Kidul','Tegal Kunir Lor','Mauk Timur'
            ],
            16 => [
                'Cijeruk','Gandaria','Jenggot','Kedaung','Klutuk','Kosambi Dalam','Mekarbaru','Waliwis'
            ],
            17 => [
                'Cicalengka','Cihuni','Cijantra','Jatake','Kadu Sirung','Karang Tengah','Lengkong Kulon','Malang Nengah','Pagedangan','Situ Gadung','Medang',
            ],
            18 => [
                'Buaran Bambu','Buaran Mangga','Bunisari','Gaga','Kalibaru','Kiara Payung','Kohod','Kramat','Laksana','Paku Alam','Rawa Boni','Sukawali','Surya Bahari','Pakuhaji',
            ],
            19 => [
                'Ciakar','Mekar Jaya','Panongan','Peusar','Ranca Iyuh','Ranca Kalapa','Serdang Kulon','Mekar Bakti',
            ],
            20 => [
                'Gelam Jaya','Pangadegan','Pasar Kemis','Suka Asih','Sukamantri','Kuta Baru','Kutabumi','Kuta Jaya','Sindangsari',
            ],
            21 => [
                'Daon','Jambu Karya','Lembangsari','Mekarsari','Pangarengan','Rajeg','Rajeg Mulya','Ranca Bango','Sukamanah','Sukasari','Tanjakan','Tanjakan Mekar','Sukatani',
            ],
            22 => [
                'Karet','Kayu Agung','Kayu Bongkok','Mekar Jaya','Pisangan Jaya','Pondok Jaya','Sarakan','Sepatan',
            ],
            23 => [
                'Gempol Sari','Jati Mulya','Kampung Kelor','Kedaung Barat','Lebak Wangi','Pondok Kelor','Sangiang','Tanah Merah',
            ],
            24 => [
                'Badak Anom','Sindangasih','Sindang Jaya','Sindangpanon','Sindangsono','Sukaharja','Wanakerta',
            ],
            25 => [
                'Cikareo','Cikasungka','Cikuya','Cireundeu','Munjul','Pasanggrahan','Solear',
            ],
            26 => [
                'Buaran Jati','Gintung','Karang Serang','Kosambi','Mekar Kondang','Pekayon','Rawa Kidang','Sukadiri',
            ],
            27 => [
                'Benda','Bunar','Buniayu','Kaliasin','Kubang','Merak','Parahu','Sukamulya',
            ],
            28 => [
                'Babakan Asem','Bojong Renged','Kampung Besar','Kampung Melayu Barat','Kampung Melayu Timur','Keboncau','Lemo','Muara','Pangkalan','Tanjung Burung','Tanjung Pasir','Tegal Angus','Teluknaga',
            ],
            29 => [
                'Bantar Panjang','Cileles','Cisereh','Margasari','Matagara','Pasir Bolang','Pasir Nangka','Pematang','Pete','Sodong','Tapos','Tegalsari','Kadu Agung','Tigaraksa',
            ],
        ];
        $x = 0;
        foreach ($villages as $row) {
            $x++;
            $i = 1;
            foreach ($row as $val) {
                Village::create(['sub_district_id' => $x, 'name' => $val]);
            }
        }

    }
}
