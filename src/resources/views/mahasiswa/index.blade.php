@extends('neo::template')
@section('title','Mahasiswa')
@section('content')
<main class="main-content-wrapper bg-success">
        <div class="container">
            <form action="{{route('mahasiswa.index')}}" method="get" id="filter">
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <select class="form-control" name="prodi" id="prodi">
                                <option value="semua">Semua Prodi</option>
                            @foreach ($prodi as $prodi)
                                <option value="{{$prodi['id_prodi']}}" >{{$prodi['nama_jenjang_pendidikan'].'-'.$prodi['nama_program_studi']}}</option>    
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <select class="form-control" name="semester">
                            @foreach ($semester as $sms)
                                <option value="{{$sms['id_semester']}}" >{{$sms['nama_semester']}}</option>    
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="d-grid gap-2">
                        <button type="submit" form="filter" class="btn btn-warning">Filter</button>
                    </div>
                </div>
            </div>
            </form>
        </div>
</main>
<main>
    <div class="container" style="margin-top:-20px">
        <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card bg-primary mb-3">
                                        <div class="card-body px-10 py-30">
                                            <h6 class="text-white">Mahasiswa Aktif</h6>
                                            <h1 class="text-white">{{$aktif}}</h1>
                                        </div>
                                    </div>
                                </div>   
                                <div class="col-md-4">
                                    <div class="card bg-info mb-3">
                                        <div class="card-body px-10 py-30">
                                            <h6 class="text-white">Mahasiswa Cuti</h6>
                                            <h1 class="text-white">{{$cuti}}</h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-danger mb-3">
                                        <div class="card-body px-10 py-30">
                                            <h6 class="text-white">Mahasiswa Non Aktif</h6>
                                            <h1 class="text-white">{{$non_aktif}}</h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            @php if (isset($_GET['prodi']) && isset($_GET['semester'])){
                                if($_GET['prodi']=='semua' && $_GET['semester']!=''){ @endphp
                                    <canvas id="allChart" style="width:100%"></canvas>
                                @php }else { @endphp
                                    <canvas id="filterChart" style="width:100%"></canvas>
                                @php } @endphp
                            @php }else { @endphp
                                <canvas id="allChart" style="width:100%"></canvas>
                            @php } @endphp
                        </div>
                    </div>
                </div>    
            </div>
        </div>
        <div class="col-md-12" style="margin-top:30px;">
            <div class="card">
                    <div class="card-body">
                        <div class="row">
                            @php
                            if((!isset($_GET['prodi']) && !isset($_GET['semester'])) || ($_GET['prodi']=='semua' && $_GET['semester']!='')){ @endphp
                                <div class="col-md-12">
                                        <canvas id="trendChart" style="width:100%"></canvas>
                                </div>
                                <!-- <div class="col-md-6">
                                        <canvas id="ipMahasiswa" style="width:100%"></canvas>
                                </div> -->
                            @php } @endphp
                        </div>
                    </div>
            </div>
        </div>
    </div>
</main>
@php
    $tahun = '';
    $aktif = '';
    $cuti  = '';
    $non_aktif = '';
    foreach($trend_mahasiswa as $item){
        $tahun .= "'".$item['nama_periode']."',";
        $aktif .= "'".$item['aktif']."',";
        $cuti .= "'".$item['cuti']."',";
        $non_aktif .= "'".$item['non_aktif']."',";
    }
@endphp
@push('script')
<!-- <script>
var xValues = ["IPS 0-1", "IPS 1-2", "IPS 2-3", "IPS 3-4"];
var yValues = [];
var barColors = [
  "#b91d47",
  "#00aba9",
  "#2b5797",
  "#e8c3b9",
];

new Chart("ipMahasiswa", {
  type: "pie",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    title: {
      display: true,
      text: "IPS Mahasiswa"
    }
  }
});
</script> -->
<script>
new Chart("trendChart", {
  type: "line",
  data: {
    labels: [@php echo $tahun @endphp],
    datasets: [{ 
      label:'Aktif',
      data: [@php echo $aktif @endphp],
      borderColor: "blue",
      fill: true,
    }, { 
      label:'Cuti',
      data: [@php echo $cuti @endphp],
      borderColor: "yellow",
      fill: true
    }, { 
      label:'Non Aktif',
      data: [@php echo $non_aktif @endphp],
      borderColor: "red",
      fill: true
    }]
  },
  options: {
    legend: {display: true},
    title: {
      display: true,
      text: "Trend Jumlah Mahasiswa"
    }
  }
});
</script>

<script>
new Chart("filterChart", {
  type: "line",
  data: {
    labels: [@php echo $label_semester @endphp],
    datasets: [{ 
      label:'Aktif',
      data: [@php echo $label_semester_aktif @endphp],
      borderColor: "blue",
      fill: true,
    }, { 
      label:'Cuti',
      data: [@php echo $label_semester_cuti @endphp],
      borderColor: "yellow",
      fill: true
    }, { 
      label:'Non Aktif',
      data: [@php echo $label_semester_non_aktif @endphp],
      borderColor: "red",
      fill: true
    }]
  },
  options: {
    legend: {
        display: true,
        alignContent: 'top',
    },
    title: {
      display: true,
      text: "Tren Jumlah Mahasiswa Prodi"
    }
  }
});
</script>

<script>
new Chart("allChart", {
    type: 'bar',
    data: {
        labels: [@php echo $label_prodi; @endphp], // responsible for how many bars are gonna show on the chart
        // create 12 datasets, since we have 12 items
        // data[0] = labels[0] (data for first bar - 'Standing costs') | data[1] = labels[1] (data for second bar - 'Running costs')
        // put 0, if there is no data for the particular bar
        datasets: [
            
            {
                label: 'Aktif',
                data: [@php echo $label_aktif; @endphp],
                backgroundColor: '#22aa99'
            },
            {
                label: 'Cuti',
                data: [@php echo $label_cuti; @endphp],
                backgroundColor: '#fcf41d'
            },
            {
                label: 'Non Aktif',
                data: [@php echo $label_non_aktif; @endphp],
                backgroundColor: '#fc1d1d'
            }
        ]
    },
   options: {
      responsive: true,
      legend: {
         position: 'top' // place legend on the right side of chart
      },
      scales: {
         xAxes: [{
            stacked: true // this should be set to make the bars stacked
         }],
         yAxes: [{
            stacked: true // this also..
         }]
      },
      title :{
        display :true,
        text    : 'Jumlah Mahasiswa Program Studi'
      }
   }
});
</script>
@endpush
@endsection