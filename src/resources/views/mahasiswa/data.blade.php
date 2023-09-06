@extends('neo::template')
@section('title','Mahasiswa Aktif')
@section('content')
<main class="main-content-wrapper bg-success">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h3 class="text-white">Data Mahasiswa @php if($_GET['status']=='A'){echo
                    "Aktif";}elseif($_GET['status']=='C'){echo "Cuti";}else{echo "Non Aktif";} @endphp Tahun Akademik
                    @php echo
                    $_GET['semester'] @endphp</h3>
            </div>
            <div class="col-md-6">
                <button class="btn btn-warning float-end" data-bs-toggle="tooltip"
                    title="Fitur Dalam Pengembangan">Export Data</button>
            </div>
        </div>
    </div>
</main>
<main>
    <div class="container" style="margin-top:-30px;">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table" id="data-table">
                            <thead>
                                <tr>
                                    <th>NIM</th>
                                    <th>Nama</th>
                                    <th>Prodi</th>
                                    <th>Angkatan</th>
                                    <th>Status</th>
                                    <!-- Add more columns as needed -->
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@push('script')
<script>
const url =
    "{{ route('mahasiswa.data.get',['semester'=>$_GET['semester'],'prodi'=>$_GET['prodi'],'status'=>$_GET['status']]) }}";
const parseResult = new DOMParser().parseFromString(url, "text/html");
const parsedUrl = parseResult.documentElement.textContent;
$('#data-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: parsedUrl,
    columns: [{
            data: 'nim'
        },
        {
            data: "nama_mahasiswa"
        },
        {
            data: "nama_program_studi"
        },
        {
            data: "angkatan"
        },
        {
            data: "nama_status_mahasiswa"
        }
    ]
});
</script>

<script>
// Initialize tooltips
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
})
</script>
@endpush
@endsection