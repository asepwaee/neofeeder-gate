@extends('neo::template')
@section('title','Mahasiswa')
@section('content')
<main class="main-content-wrapper bg-success">
        <div class="container">
            <form action="{{route('dosen.index')}}" method="get" id="filter">
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
                                <option value="{{$sms['id_semester']}}" >{{$sms['id_semester']}}</option>    
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
                                            <h6 class="text-white">Jumlah Dosen</h6>
                                            <h1 class="text-white">{{$dosen}}</h1>
                                        </div>
                                    </div>
                                </div>   
                                <div class="col-md-4">
                                    <div class="card bg-info mb-3">
                                        <div class="card-body px-10 py-30">
                                            <h6 class="text-white">Jumlah Dosen Homebase</h6>
                                            <h1 class="text-white">{{$is_homebase}}</h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-danger mb-3">
                                        <div class="card-body px-10 py-30">
                                            <h6 class="text-white">Jumlah Dosen Non Homebase</h6>
                                            <h1 class="text-white">{{$in_homebase}}</h1>
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
                </div>
            </div>
        </div>
    </div>
</main>

@push('script')
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
                label: 'Homebase',
                data: [@php echo $label_is_homebase; @endphp],
                backgroundColor: '#22aa99'
            },
            {
                label: 'Non Homebase',
                data: [@php echo $label_in_homebase; @endphp],
                backgroundColor: '#fcf41d'
            },
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
        text    : 'Jumlah Dosen Program Studi'
      }
   }
});
</script>
@endpush
@endsection