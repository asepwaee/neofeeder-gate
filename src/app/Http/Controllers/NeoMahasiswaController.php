<?php
namespace Aseplab\Neofeeder\App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Aseplab\Neofeeder\App\Helpers\NeoFeeder;
use Yajra\DataTables\DataTables;
class NeoMahasiswaController extends Controller
{
    
    public function index()
    {
        $getProdi = new NeoFeeder([
            'act' => 'GetProdi',
            'filter' => "status ='A'",
            'order' => "id_jenjang_pendidikan desc"
        ]);
        // dd($getProdi->getData()['data']);
        $getSemester = new NeoFeeder([
            'act' => 'GetListPeriodePerkuliahan',
            'order' => 'id_semester desc'
        ]);
        // $sms = $getSemester->getData();
        // dd($sms);
        // dd($this->_group_by($sms,$sms['data']));
        if(isset($_GET['prodi']) && isset($_GET['semester'])){
            if($_GET['prodi']=='semua' && $_GET['semester']!=''){
                $getSemesterAktif = new NeoFeeder([
                    'act' => 'GetListPeriodePerkuliahan',
                    'order' => "id_semester desc",
                    'limit' => "1"
                ]);
                $semesterAktif = $getSemesterAktif->getData()['data'][0]['id_semester'];
                $aktif = 0;
                $cuti = 0;
                $non_aktif=0;
                $getRekapMahasiswa = new Neofeeder([
                    'act' => 'GetRekapJumlahMahasiswa',
                    'filter'=>"id_periode = '$_GET[semester]'"
                ]);
                $rekapMhs = $getRekapMahasiswa->getData()['data'];
                $label_prodi ='';
                $label_aktif ='';
                $label_cuti ='';
                $label_non_aktif ='';
                foreach ($rekapMhs as $rekap){
                    $label_prodi .= "'".$rekap['nama_program_studi']."',"; 
                    $label_aktif .= "'".$rekap['aktif']."',"; 
                    $label_cuti .= "'".$rekap['cuti']."',"; 
                    $label_non_aktif .= "'".$rekap['non_aktif']."',"; 
                    $aktif += $rekap['aktif'];
                    $cuti += $rekap['cuti'];
                    $non_aktif += $rekap['non_aktif'];
                }
                $label_semester='';
                $label_semester_aktif='';
                $label_semester_cuti='';
                $label_semester_non_aktif='';

                $getTrendMahasiswa = new Neofeeder([
                    'act' => 'GetRekapJumlahMahasiswa',
                    'filter'=> "nama_periode NOT LIKE '%Pendek%' ",
                    'order'=> 'id_periode asc'
                ]);
                $trend = $getTrendMahasiswa->getData()['data'];
                foreach ($trend as $item) {
                    $id_periode = $item['id_periode'];
                    $nama_periode = $item['nama_periode'];
                    
                    if (!isset($grouped_data[$id_periode])) {
                        $grouped_data[$id_periode] = array(
                            'aktif' => 0,
                            'cuti' => 0,
                            'non_aktif' => 0
                        );
                    }
                    
                    $grouped_data[$id_periode]['nama_periode'] = $nama_periode;
                    $grouped_data[$id_periode]['aktif'] += intval($item['aktif']);
                    $grouped_data[$id_periode]['cuti'] += intval($item['cuti']);
                    $grouped_data[$id_periode]['non_aktif'] += intval($item['non_aktif']);
                }
                // dd($getProdi->getData()['data']);

            }else{
                $aktif = 0;
                $cuti = 0;
                $non_aktif=0;
                $getRekapMahasiswa = new Neofeeder([
                    'act' => 'GetRekapJumlahMahasiswa',
                    'filter'=>"id_prodi = '$_GET[prodi]' and id_periode='$_GET[semester]'"
                ]);
                $rekapMhs = $getRekapMahasiswa->getData()['data'];
                // dd($rekapMhs);
                $label_prodi ='';
                $label_aktif ='';
                $label_cuti ='';
                $label_non_aktif ='';
                foreach ($rekapMhs as $rekap){
                    $aktif = $rekap['aktif'];
                    $cuti = $rekap['cuti'];
                    $non_aktif = $rekap['non_aktif'];
                    $label_non_aktif .= "'".$rekap['non_aktif']."',"; 
                    $aktif = $rekap['aktif'];
                    $cuti = $rekap['cuti'];
                    $non_aktif = $rekap['non_aktif'];
                }
                $getSemesterProdi = new NeoFeeder([
                    'act' => 'GetRekapJumlahMahasiswa',
                    'order' => 'id_periode asc',
                    'filter' => "id_prodi='$_GET[prodi]'",
                    'limit'=>""
                ]);
                $label_semester='';
                $label_semester_aktif='';
                $label_semester_cuti='';
                $label_semester_non_aktif='';
                $smsProdi = $getSemesterProdi->getData()['data'];
                // dd($smsProdi);
                foreach($smsProdi as $prodi){
                    $label_semester .= "'".$prodi['nama_periode']."',";
                    $label_semester_aktif .= $prodi['aktif'].",";
                    $label_semester_cuti .= $prodi['cuti'].",";
                    $label_semester_non_aktif .= $prodi['non_aktif'].",";
                }
                // dd($label_semester_non_aktif);
                $grouped_data = [];
                // $nm_semester = new NeoFeeder([
                //     'act' => 'GetListPeriodePerkuliahan',
                //     'filter'=> "id_prodi='$_GET[prodi]' and id_semester='$_GET[semester]' ",
                // ]);
                // $dt = $nm_semester->getData()['data'];
                // $prodi = $dt['nama_program_studi']
            }
        }else{
                $getSemesterAktif = new NeoFeeder([
                    'act' => 'GetListPeriodePerkuliahan',
                    'order' => "id_semester desc",
                    'limit' => "1"
                ]);
                $semesterAktif = $getSemesterAktif->getData()['data'][0]['id_semester'];
                $aktif = 0;
                $cuti = 0;
                $non_aktif=0;
                $getRekapMahasiswa = new Neofeeder([
                    'act' => 'GetRekapJumlahMahasiswa',
                    'filter'=>"id_periode = '20222'",
                    'order'=> 'nama_program_studi desc'
                ]);
                $rekapMhs = $getRekapMahasiswa->getData()['data'];
                $label_prodi ='';
                $label_aktif ='';
                $label_cuti ='';
                $label_non_aktif ='';
                foreach ($rekapMhs as $rekap){
                    $label_prodi .= "'".$rekap['nama_program_studi']."',"; 
                    $label_aktif .= "'".$rekap['aktif']."',"; 
                    $label_cuti .= "'".$rekap['cuti']."',"; 
                    $label_non_aktif .= "'".$rekap['non_aktif']."',"; 
                    $aktif += $rekap['aktif'];
                    $cuti += $rekap['cuti'];
                    $non_aktif += $rekap['non_aktif'];
                }
                $label_semester='';
                $label_semester_aktif='';
                $label_semester_cuti='';
                $label_semester_non_aktif='';

                $getTrendMahasiswa = new Neofeeder([
                    'act' => 'GetRekapJumlahMahasiswa',
                    'filter'=> "nama_periode NOT LIKE '%Pendek%' ",
                    'order'=> 'id_periode asc',
                    'limit'=> ''
                ]);
                
                $trend = $getTrendMahasiswa->getData()['data'];
                foreach ($trend as $item) {
                    $id_periode = $item['id_periode'];
                    $nama_periode = $item['nama_periode'];
                    
                    if (!isset($grouped_data[$id_periode])) {
                        $grouped_data[$id_periode] = array(
                            'aktif' => 0,
                            'cuti' => 0,
                            'non_aktif' => 0
                        );
                    }
                    
                    $grouped_data[$id_periode]['nama_periode'] = $nama_periode;
                    $grouped_data[$id_periode]['aktif'] += intval($item['aktif']);
                    $grouped_data[$id_periode]['cuti'] += intval($item['cuti']);
                    $grouped_data[$id_periode]['non_aktif'] += intval($item['non_aktif']);
                }

                
        }
        $dataSms = $getSemester->getData()['data'];
        // Create an empty array to store grouped data
        $groupedData = [];
        // Iterate through the data and create grouped format
        foreach ($dataSms as $entry) {
            $idSemester = $entry['id_semester'];
            $namaSemester = $entry['nama_semester'];

            // Check if the semester is already in the grouped format
            if (!isset($groupedData[$idSemester])) {
                $groupedData[$idSemester] = [
                    'id_semester' => $idSemester,
                    'nama_semester' => $namaSemester
                ];
            }
        }

        // Now, $groupedData contains the grouped format data with id_semester and nama_semester
        $groupedData = array_values($groupedData); // Convert the associative array to indexed array if needed
        // dd($groupedData);
        return view('neo::mahasiswa.index',[
            'prodi'                     =>$getProdi->getData()['data'],
            'semester'                  =>$groupedData,
            // jumlah mahasiswa
            'aktif'                     =>$aktif,
            'cuti'                      =>$cuti, 
            'non_aktif'                 =>$non_aktif, 
            //  grafik perprodi   
            'label_prodi'               =>$label_prodi,
            'label_aktif'               =>$label_aktif,
            'label_cuti'                =>$label_cuti,
            'label_non_aktif'           =>$label_non_aktif,
            // grafik persemester
            'label_semester'            =>$label_semester,
            'label_semester_aktif'      =>$label_semester_aktif,
            'label_semester_cuti'       =>$label_semester_cuti,
            'label_semester_non_aktif'  =>$label_semester_non_aktif,
            // trend mahasiswa
            'trend_mahasiswa'           =>$grouped_data
        ]);
    }

    public function data(){
        return view('neo::mahasiswa.data');
    }

    public function get_data(){
        $getDataMahasiswa = new Neofeeder([
            'act' => 'GetAktivitasKuliahMahasiswa',
            'filter'=>"id_semester = '$_GET[semester]' and id_status_mahasiswa='$_GET[status]'",
        ]);
        $data = $getDataMahasiswa->getData()['data'];
        return Datatables::of($data)->make(true);
    }
}