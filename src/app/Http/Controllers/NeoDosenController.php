<?php
namespace Aseplab\Neofeeder\App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Aseplab\Neofeeder\App\Helpers\NeoFeeder;
class NeoDosenController extends Controller
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
            }
        }else{
                $getSemesterAktif = new NeoFeeder([
                    'act' => 'GetListPeriodePerkuliahan',
                    'order' => "id_semester desc",
                    'limit' => "1"
                ]);
                $semesterAktif = $getSemesterAktif->getData()['data'][0]['id_semester'];
                $dosen = 0;
                $is_homebase = 0;
                $in_homebase=0;
                $getRekapDosen = new Neofeeder([
                    'act' => 'GetRekapJumlahDosen',
                    'filter'=>"id_periode = '2022'",
                    'order'=> 'nama_program_studi desc'
                ]);
                $rekapDosen = $getRekapDosen->getData()['data'];

                $label_prodi ='';
                $label_is_homebase ='';
                $label_in_homebase ='';
                
                foreach ($rekapDosen as $item) {
                    $nama_program_studi = $item['nama_program_studi'];
                    $is_homebase = (int)$item['is_homebase'];
                
                    if (!isset($groupedData[$nama_program_studi])) {
                        $groupedData[$nama_program_studi] = [
                            'nama_program_studi' => $nama_program_studi,
                            'is_home_base' => 0,
                            'is_non_home_base' => 0,
                        ];
                    }
                
                    if ($is_homebase) {
                        $groupedData[$nama_program_studi]['is_home_base'] += (int)$item['jumlah_dosen_homebase'];
                    } else {
                        $groupedData[$nama_program_studi]['is_non_home_base'] += (int)$item['jumlah_dosen_homebase'];
                    }
                }
                
                $result = ['data' => array_values($groupedData)];

                foreach($result['data'] as $dataitem){
                    $dosen += ($dataitem['is_home_base']+$dataitem['is_non_home_base']);
                    $is_homebase += $dataitem['is_home_base'];
                    $in_homebase += $dataitem['is_non_home_base'];

                    $label_prodi .= "'".$dataitem['nama_program_studi']."',";
                    $label_is_homebase .= "'".$dataitem['is_home_base']."',";
                    $label_in_homebase .= "'".$dataitem['is_non_home_base']."',";
                     
                }
        }
        return view('neo::dosen.index',[
            'prodi'                     =>$getProdi->getData()['data'],
            'semester'                  =>$getSemester->getData()['data'],
            // jumlah mahasiswa
            'dosen'                     =>$dosen,
            'is_homebase'               =>$is_homebase, 
            'in_homebase'               =>$in_homebase, 
            //  grafik perprodi   
            'label_prodi'               =>$label_prodi,
            'label_is_homebase'         =>$label_is_homebase,
            'label_in_homebase'         =>$label_in_homebase,
        ]);
    }
}