@extends('layout.v_wrapper')
@section('title')
    Daftar PAK
@endsection
@push('ext_header')
    @include('layout.css_tables')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.min.js"
        integrity="sha512-L0Shl7nXXzIlBSUUPpxrokqq4ojqgZFQczTYlGjzONGTDAcLremjwaWv5A+EDLnxhQzY5xUZPWLOLqYRkY0Cbw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.cjs"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.cjs.map"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.js"
        integrity="sha512-7DgGWBKHddtgZ9Cgu8aGfJXvgcVv4SWSESomRtghob4k4orCBUTSRQ4s5SaC2Rz+OptMqNk0aHHsaUBk6fzIXw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.js.map"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"
        integrity="sha512-ZwR1/gSZM3ai6vCdI+LVF1zSq/5HznD3ZSTk7kajkaj4D292NLuduDCO1c/NT8Id+jE58KYLKT7hXnbtryGmMg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js.map"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"
        integrity="sha512-CQBWl4fJHWbryGE+Pc7UAxWMUMNMWzWxF4SQo9CgkJIN1kx6djDQZjh3Y8SZ1d+6I+1zze6Z7kHXO7q3UyZAWw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/helpers.cjs"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/helpers.cjs.map"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/helpers.js"
        integrity="sha512-08S2icXl5dFWPl8stSVyzg3W14tTISlNtJekjsQplv326QtsmbEVqL4TFBrRXTdEj8QI5izJFoVaf5KgNDDOMA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/helpers.js.map"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/helpers.min.js"
        integrity="sha512-JG3S/EICkp8Lx9YhtIpzAVJ55WGnxT3T6bfiXYbjPRUoN9yu+ZM+wVLDsI/L2BWRiKjw/67d+/APw/CDn+Lm0Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/index.d.ts"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/index.umd.d.ts"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/types.d.ts"></script>
@endpush
@push('ext_footer')
    @include('layout.js_tables')
    <script>
        function getRandomColor(alpha) {
            var r = Math.floor(Math.random() * 256);
            var g = Math.floor(Math.random() * 256);
            var b = Math.floor(Math.random() * 256);
            return 'rgba(' + r + ',' + g + ',' + b + ',' + alpha + ')';
        }

        function getRandomDarkColor(color) {
            // Convert color to RGB
            var r = parseInt(color.substring(1, 3), 16);
            var g = parseInt(color.substring(3, 5), 16);
            var b = parseInt(color.substring(5, 7), 16);

            // Darken the color
            r = Math.floor(r * 0.8);
            g = Math.floor(g * 0.8);
            b = Math.floor(b * 0.8);

            // Convert back to hex
            var darkColor = '#' + ('0' + r.toString(16)).slice(-2) +
                ('0' + g.toString(16)).slice(-2) +
                ('0' + b.toString(16)).slice(-2);
            return darkColor;
        }

        function toDataset(dataRadar) {
            var predikat = dataRadar.getAttribute('predikat');
            var nilaiKinerja = dataRadar.getAttribute('nilaiKinerja');
            var nilaiPerilaku = dataRadar.getAttribute('nilaiPerilaku');
            var periode = dataRadar.getAttribute('periode');
            if (predikat.toLowerCase().trim() == "sangat baik") {
                predikat = 5;
            } else if (predikat.toLowerCase().trim() == "baik") {
                predikat = 4;
            } else if (predikat.toLowerCase().trim() == "butuh perbaikan") {
                predikat = 3;
            } else if (predikat.toLowerCase().trim() == "kurang") {
                predikat = 2;
            } else if (predikat.toLowerCase().trim() == "sangat kurang") {
                predikat = 1;
            }

            if (nilaiKinerja.toLowerCase().trim() == "di atas ekspektasi") {
                nilaiKinerja = 5;
            } else if (nilaiKinerja.toLowerCase().trim() == "sesuai ekspektasi") {
                nilaiKinerja = 3;
            } else if (nilaiKinerja.toLowerCase().trim() == "di bawah ekspektasi") {
                nilaiKinerja = 1;
            }

            if (nilaiPerilaku.toLowerCase().trim() == "di atas ekspektasi") {
                nilaiPerilaku = 5;
            } else if (nilaiPerilaku.toLowerCase().trim() == "sesuai ekspektasi") {
                nilaiPerilaku = 3;
            } else if (nilaiPerilaku.toLowerCase().trim() == "di bawah ekspektasi") {
                nilaiPerilaku = 1;
            }

            var backgroundColor = getRandomColor(0.2);
            var borderColor = getRandomDarkColor(backgroundColor);

            return {
                label: periode,
                data: [predikat, nilaiKinerja, nilaiPerilaku],
                backgroundColor: backgroundColor,
                borderColor: borderColor,
                borderWidth: 1
            };
        }

        var count = document.getElementById('dataRadar').getAttribute('count');
        var datasets = [];
        for (let index = 0; index < count; index++) {
            var dataRadar = document.querySelector('#dataRadar_' + index);
            datasets.push(toDataset(dataRadar));
        }

        var ctx = document.getElementById('radarChart').getContext('2d');
        var radarChart = new Chart(ctx, {
            type: 'radar',
            data: {
                labels: ['Predikat', 'Nilai Kinerja', 'Nilai Perilaku'],
                datasets: datasets
            },
            options: {
                scales: {
                    y: {
                        max: 5,
                        min: 0,
                        ticks: {
                            stepSize: 1
                        }
                    },
                    r: {
                        beginAtZero: true,
                        angleLines: {
                            display: false
                        },
                        max: 5,
                        min: 0,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
        radarChart.canvas.parentNode.style.height = "80vh";
        radarChart.canvas.parentNode.style.width = "80vw";
    </script>
@endpush
@section('content')
    <div class="col-lg-12">
        <div class="card-header align-items-center d-flex">
        </div><!-- end card header -->
        <div class="card">
            <div class="card-body">
                <div class="flex-shrink-0 alert alert-primary">
                    Daftar PAK Oleh Pejabat Fungsional
                </div>
                <div class="row text-dark">
                    <div class="col-3">Nama</div>
                    <div class="col">{{ $user->name ?? '-' }}</div>
                </div>
                <div class="row text-dark">
                    <div class="col-3">Tempat, Tanggal Lahir</div>
                    <div class="col">
                        {{ $user->userDetail->tempat_lahir ?? '-' }},
                        {{ substr($user->userDetail->tanggal_lahir ?? '-', 0, 10) }}
                    </div>
                </div>
                <div class="row text-dark">
                    <div class="col-3">Jenis Kelamin</div>
                    <div class="col">{{ $user->userDetail->jenis_kelamin ?? '-' }}</div>
                </div>
                <div class="row text-dark">
                    <div class="col-3">Jabatan</div>
                    <div class="col">{{ $user->jabatan->jabatan->name ?? '-' }}</div>
                </div>
                <div class="row text-dark">
                    <div class="col-3">Jenjang</div>
                    <div class="col">{{ $user->jabatan->jenjang->name ?? '-' }}</div>
                </div>
                <div class="row text-dark">
                    <div class="col-3">Pangkat</div>
                    <div class="col">{{ $user->pangkat->pangkat->name ?? '-' }}</div>
                </div>
                <div class="row text-dark">
                    <div class="col-3">Unit Kerja</div>
                    <div class="col">{{ $user->unitKerja->name ?? '-' }}</div>
                </div>
                <div class="row text-dark">
                    <div class="col-3">Alamat Unit Kerja</div>
                    <div class="col">{{ $user->unitKerja->alamat ?? '-' }}</div>
                </div>
            </div>
        </div>
        <div class="card card-body">
            <div class="row" id="dataRadar" count="{{ count($userPakList ?? []) }}">
                <div class="col-6">
                    <table class="main-table table table-bordered nowrap align-middle w-100">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal Mulai-Selesai</th>
                                <th>Nama</th>
                                <th>Nilai</th>
                                <th>File</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($userPakList))
                                @foreach ($userPakList as $index => $userPak)
                                    <tr id="dataRadar_{{ $index }}" predikat="{{ $userPak->predikat }}"
                                        nilaiKinerja="{{ $userPak->nilai_kinerja }}"
                                        nilaiPerilaku="{{ $userPak->nilai_perilaku }}"
                                        periode="{{ $userPak->tgl_mulai }} - {{ $userPak->tgl_selesai }}">
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $userPak->tgl_mulai }}-{{ $userPak->tgl_selesai }}</td>
                                        <td>
                                            Nilai Kinerja <br>
                                            Nilai Perilaku <br>
                                            Predikat
                                        </td>
                                        <td>
                                            {{ $userPak->nilai_kinerja ?? '-' }} <br>
                                            {{ $userPak->nilai_perilaku ?? '-' }} <br>
                                            {{ $userPak->predikat ?? '-' }} <br>
                                        </td>
                                        <td>
                                            <a class="link link-info" href="javascript:void(0);"
                                                onclick="previewModal({{ json_encode($userPak->file_doc_ak ?? '') }}, 'Dokumen Angkat Kredit')">
                                                Dokumen Angkat Kredit <i class=" las la-eye"></i>
                                            </a>
                                            <br>
                                            <a class="link link-info" href="javascript:void(0);"
                                                onclick="previewModal({{ json_encode($userPak->file_hasil_eval ?? '') }}, 'Dokumen Hasil Evaluasi')">
                                                Dokumen Hasil Evaluasi <i class=" las la-eye"></i>
                                            </a>
                                            <br>
                                            <a class="link link-info" href="javascript:void(0);"
                                                onclick="previewModal({{ json_encode($userPak->file_dok_konversi ?? '') }}, 'Dokumen Hasil Konversi')">
                                                Dokumen Hasil Konversi <i class=" las la-eye"></i>
                                            </a>
                                        </td>
                                        <td>
                                            @if ($userPak->task_status == 'APPROVE')
                                                <span class="badge bg-success">
                                                    diterima
                                                </span>
                                            @else
                                                <span class="badge bg-warning">
                                                    menunggu verifikasi
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                @if ($userPak->task_status != 'APPROVE')
                                                    <form
                                                        action="{{ route('/monitoring_kinerja/pemetaan_kinerja/detail/edit', ['id' => $userPak->id]) }}"
                                                        method="post" class="float-start me-1">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit"
                                                            class="btn btn-sm btn-soft-success waves-effect btn-sm waves-light"
                                                            name="task_status" value="APPROVE">
                                                            <i class=""></i>Terima
                                                        </button>
                                                    </form>
                                                    <button type="button" data-bs-toggle="modal"
                                                        data-bs-target="#tolak{{ $userPak->id }}"
                                                        class="btn btn-sm btn-soft-danger waves-effect btn-sm waves-light">
                                                        <i class=""></i>Tolak
                                                    </button>
                                                @else
                                                    -
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="tolak{{ $userPak->id }}" tabindex="-1"
                                        aria-labelledby="exampleModalgridLabel" aria-modal="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger ">
                                                    <h5 class="modal-title text-white" id="exampleModalgridLabel">
                                                        Anda Menolak Data Riwayat Ini
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Silahkan masukan komen pada field dibawah!</p>
                                                    <form method="POST"
                                                        action="{{ route('/monitoring_kinerja/pemetaan_kinerja/detail/edit', ['id' => $userPak->id]) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="row g-3"> <!--end col-->
                                                            <div class="col-lg-12">
                                                                <div>
                                                                    <input type="text" hidden
                                                                        value="{{ $userPak->id }}" name="id">
                                                                    <input type="text" hidden value="REJECT"
                                                                        name="task_status">
                                                                    <label for="exampleFormControlTextarea5"
                                                                        class="form-label">Komen</label>
                                                                    <textarea class="form-control" id="exampleFormControlTextarea5" rows="3" name="comment"></textarea>
                                                                </div>
                                                                <input type="text" hidden value="id_riwayat">
                                                            </div> <!--end col-->
                                                            <div class="col-lg-12">
                                                                <div class="hstack gap-2 justify-content-end">
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-soft-light text-dark"
                                                                        data-bs-dismiss="modal">Tutup</button>
                                                                    <button type="submit"
                                                                        class="btn btn-sm btn-soft-danger">Tolak</button>
                                                                </div>
                                                            </div> <!--end col-->
                                                        </div> <!--end row-->
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <canvas id="radarChart" class="float-end"></canvas>
            </div>
        </div>
        @include('widget.modal-doc')
    </div>
@endsection
