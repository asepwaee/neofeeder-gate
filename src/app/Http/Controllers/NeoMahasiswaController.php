<?php
namespace Aseplab\Neofeeder\App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Aseplab\Neofeeder\App\Helpers\Neofeeder;
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
        return view('neo::mahasiswa.index',[
            'prodi'                     =>$getProdi->getData()['data'],
            'semester'                  =>$getSemester->getData()['data'],
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
}
