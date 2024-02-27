@extends('layouts.app')
@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data Kmeans</li>
    </ol>
</nav>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Penilaian Kmeans</h6>
    </div>
    @if ($data == null or count($data) < 3)
        <div class="card-body">
            <h3>Minimal Harus terdapat 3 Data</h3>
        </div>
    @else
        <div class="card-body">
            <!-- tabel data yang akan diproses -->
            <h6>Data UMKM</h6>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Data</th>
                        <th colspan="2">Hasil Normalisasi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    ini_set('memory_limit', '2056M');
                        $no = 1;
                        foreach ($v_umkm1 as $key => $value) {
                            echo "<tr>";
                            echo "<td>" . $no++ . "</td>";
                            echo "<td>" . $value->nama_umkm . "</td>";
                            echo "<td>" . $value->norma_omset . "</td>";
                            echo "<td>" . $value->norma_asset . "</td>";
                            echo "</tr>";
                        }
                        foreach ($v_umkm2 as $key => $value) {
                            echo "<tr>";
                            echo "<td>" . $no++ . "</td>";
                            echo "<td>" . $value->nama_umkm . "</td>";
                            echo "<td>" . $value->norma_omset . "</td>";
                            echo "<td>" . $value->norma_asset . "</td>";
                            echo "</tr>";
                        }
                        foreach ($v_umkm3 as $key => $value) {
                            echo "<tr>";
                            echo "<td>" . $no++ . "</td>";
                            echo "<td>" . $value->nama_umkm . "</td>";
                            echo "<td>" . $value->norma_omset . "</td>";
                            echo "<td>" . $value->norma_asset . "</td>";
                            echo "</tr>";
                        }
                        foreach ($v_umkm as $key => $value) {
                            echo "<tr>";
                            echo "<td>" . $no++ . "</td>";
                            echo "<td>" . $value->nama_umkm . "</td>";
                            echo "<td>" . $value->norma_omset . "</td>";
                            echo "<td>" . $value->norma_asset . "</td>";
                            echo "</tr>";
                        }
                    ?>

                </tbody>
            </table>
            <!-- tabel data yang akan diproses -->

            <h6>Inisialisasi atau Penentuan Centroid Awal</h6>

            <!-- untuk penentuan centroid atau inisialisasi -->
            <table class="table table-bordered">
                <tbody align="center">
                    <?php

                    /*
                    fungsi untuk menentukan berapa jumlah centroid awal
                    */
                    $centroid = CentroidAwal($data, 3);
                    $c = 1;

                        echo "<tr>";
                            echo "<td>Usaha Mikro</td>";
                            echo "<td>" . $centroid[0][0] . "</td>";
                            echo "<td>" . $centroid[0][1] . "</td>";
                        echo "</tr>";
                        echo "<tr>";
                            echo "<td>Usaha Kecil</td>";
                            echo "<td>" . $centroid[1][0] . "</td>";
                            echo "<td>" . $centroid[1][1] . "</td>";
                        echo "</tr>";
                        echo "<tr>";
                            echo "<td>Usaha Menengah</td>";
                            echo "<td>" . $centroid[2][0] . "</td>";
                            echo "<td>" . $centroid[2][1] . "</td>";
                        echo "</tr>";

                    ?>
                </tbody>
            </table>
            <!-- untuk penentuan centroid atau inisialisasi -->

            <?php

            $iterasi = 1;
            while (true) {

                // variabel untuk menentukan masuk pada kelompok apa
                $cluster1 = 1;
                $cluster2 = 2;
                $cluster3 = 3;

                /* cara ini untuk mengubah data menjadi array atau mengambil data secara berurut pada kolom
            */
                // variabel array untuk jumlah kolom yang ada pada himpunan data
                $k1 = [];
                $k2 = [];
                // $k3 = [];

                // variabel array untuk jumlah centroid
                $cnt1 = [];
                $cnt2 = [];
                $cnt3 = [];

                // mengambil hasil dari perhitungan persamaan ED dan mangambil hasil perhitungan
                $hasil_iterasi = RumusPersamaanED($data, $centroid);

                // untuk mengambil data dari himpunan data
                foreach ($data as $key1 => $value1) {

                    $k1[] = $value1[0];
                    $k2[] = $value1[1];
                    // $k3[] = $value1[2];
                }

                // hasil dari proses perhitungan
                foreach ($hasil_iterasi as $key2 => $value2) {

                    $cnt1[] = $value2[0];
                    $cnt2[] = $value2[1];
                    $cnt3[] = $value2[2];
                }

                // mengubah data menjadi array hasil centroid
                $cluster = [$cnt1, $cnt2, $cnt3];

                // untuk mengambil hasil dari cluster
                $cls = [];

                // manampilkan data pada hasil iterasi
                for ($i = 0; $i < count($data); $i++) {

                    // untuk proses pembagian cluster
                    if ($cnt1[$i] < $cnt2[$i] && $cnt1[$i] < $cnt3[$i]) {

                        $cls[] = $cluster1;
                    } else if ($cnt2[$i] < $cnt1[$i] && $cnt2[$i] < $cnt3[$i]) {

                        $cls[] = $cluster2;
                    } else if ($cnt3[$i] < $cnt1[$i] && $cnt3[$i] < $cnt2[$i]) {

                        $cls[] = $cluster3;
                    }
                }

                // mengambil hasil untuk menentukan nilai terkecil atau jarak terdekat pada hasil cluster
                $hasil_minimal = NilaiTerkecil($cluster, $data);

                // untuk mengeksekusi apa bila terdapat nilai 0 pada index pertama
                if (!$k1[0] != 0) {
                    $k1[0] = sprintf("%02d", 0);
                }

                if (!$k2[0] != 0) {
                    $k2[0] = sprintf("%02d", 0);
                }

                /* mulai proses pencarian nilai rata - rata dari hasil pengelompokan untuk mengambil nilai yang masuk pada cluster */
                // kolom a
                $c1 = [];
                $c2 = [];
                $c3 = [];
                // kolom b
                $d1 = [];
                $d2 = [];
                $d3 = [];

                // untuk menentukan apa bila ada nilai yang memiliki cluster yang sama pada saat pembagian cluster
                for ($j = 0; $j < count($cls); $j++) {

                    // menampilkan data menjadi 1
                    for ($i = 0; $i < 1; $i++) {

                        // kolom 1 pada a
                        if ($k1[$i] and $cls[$j] == 1) {
                            $c1[] = $k1[$j];
                        } else if ($k1[$i] and $cls[$j] == 2) {
                            $c2[] = $k1[$j];
                        } else if ($k1[$i] and $cls[$j] == 3) {
                            $c3[] = $k1[$j];
                        }

                        // kolom 2 pada b
                        if ($k2[$i] and $cls[$j] == 1) {
                            $d1[] = $k2[$j];
                        } else if ($k2[$i] and $cls[$j] == 2) {
                            $d2[] = $k2[$j];
                        } else if ($k2[$i] and $cls[$j] == 3) {
                            $d3[] = $k2[$j];
                        }
                    }
                    // menampilkan data menjadi 1

                }

                // hasil penyamaan atara cluster dan data
                $cluster = [
                    [$c1, $c2, $c3],
                    [$d1, $d2, $d3],
                ];

                // untuk mengambil hasil nilai rata rata
                $nilai_rata = NilaiRatarata($cluster);

                $nilrat1 = [];
                $nilrat2 = [];
                $nilrat3 = [];

                foreach ($nilai_rata as $key => $value) {
                    $nilrat1[] = $value[0];
                    $nilrat2[] = $value[1];
                    $nilrat3[] = $value[2];
                }

                // hasil centroid baru
                $centroid_baru = [$nilrat1, $nilrat2, $nilrat3];

                // untuk mengambil hasil centroid baru
                $centroid = CentroidBaru($centroid_baru);

                $hasil_baru = [];

                $tabel_iterasi = array();

                // untuk mengambil data
                foreach ($data as $key => $value) {
                    // untuk mengambil data berdasarkan baris
                    $tabel_iterasi[$key]['data'] = $value;
                }

                // untuk mengambil hasil centroid c1, c2, c3
                foreach ($hasil_iterasi as $key => $value) {
                    // untuk mengambil jarak centroid
                    $tabel_iterasi[$key]['jarak_centroid'] = $value;
                }

                // untuk mengambil nilai terkecil atau jarak terdekat
                foreach ($hasil_minimal as $key => $value) {
                    // untuk mengambil jarak centroid
                    $tabel_iterasi[$key]['jarak_terdekat'] = $value;
                }

                // untuk mengambil cluster
                foreach ($cls as $key => $value) {
                    // untuk mengambil clustering
                    $tabel_iterasi[$key]['cluster'] = $value;
                }

                // untuk mengambil pembagian class pada penyakit
                $hasil_class = array();

                foreach ($tabel_iterasi as $key => $value) {
                    // Check if 'cluster' key exists in $value
                    if (isset($value['cluster'])) {
                        for ($i = 1; $i <= count($centroid); $i++) {
                            if ($value['cluster'] == $i) {
                                $hasil_class[$key]["class" . $i] = $value['data']['nama_umkm'];
                            }
                        }
                    }
                }

                // untuk menggabungkan kedua array
                array_push($hasil_baru, $tabel_iterasi);

            ?>

                <!-- untuk menampikan data -->
                <?php foreach ($hasil_baru as $key => $value) : ?>

                    <hr>
                    <h6>Iterasi Ke-<?= $iterasi++ ?></h6>
                    <!-- menampilkan hasil iterasi -->
                    <table  class="table table-bordered">
                        <thead>
                            <tr>
                                <th rowspan="2">No</th>
                                <th rowspan="2">Data</th>
                                <th colspan="2" rowspan="2">Hasil Normalisasi</th>
                                <th colspan="3">Jarak Ke Centroid</th>
                                <th rowspan="2">Jarak Terdekat</th>
                                <th rowspan="2">Cluster</th>
                            </tr>
                            <tr>
                                <th>Usaha Mikro</th>
                                <th>Usaha Kecil</th>
                                <th>Usaha Menengah</th>
                            </tr>

                        </thead>
                        <tbody>

                            <?php $no = 1?>

                            <?php foreach ($value as $key13 => $value13) : ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $value13['data']['nama_umkm']; ?></td>
                                    <td><?= isset($value13['data'][0]) ? $value13['data'][0] : ''; ?></td>
                                    <td><?= isset($value13['data'][1]) ? $value13['data'][1] : ''; ?></td>

                                    <td><?= number_format(isset($value13['jarak_centroid'][0]) ? $value13['jarak_centroid'][0] : '', 2, ',', '.'); ?></td>
                                    <td><?= number_format(isset($value13['jarak_centroid'][1]) ? $value13['jarak_centroid'][1] : '', 2, ',', '.'); ?></td>
                                    <td><?= number_format(isset($value13['jarak_centroid'][2]) ? $value13['jarak_centroid'][2] : '', 2, ',', '.'); ?></td>
                                    <td><?= number_format(isset($value13['jarak_terdekat']) ? $value13['jarak_terdekat'] : ''); ?></td>
                                    <td><?= isset($value13['cluster']) ? $value13['cluster'] : ''; ?></td>
                                </tr>
                            <?php endforeach; ?>


                        </tbody>
                    </table>
                    <!-- untuk menampilkan tabel -->

                <?php endforeach; ?>

                <hr>
                <h6>Mencari Nilai Rata - rata</h6>
                <!-- tabel untuk mencari nilai rata -->
                <table class="table table-bordered">
                    <tbody align="center">

                        <?php $c = 1 ?>

                        <!-- menampilkan hasil nilai rata dan centroid baru -->
                            <tr>
                                <td>Usaha Mikro</td>
                                <td><?= $centroid_baru[0][0]; ?></td>
                                <td><?= $centroid_baru[0][1]; ?></td>
                            </tr>
                            <tr>
                                <td>Usaha Kecil</td>
                                <td><?= $centroid_baru[1][0]; ?></td>
                                <td><?= $centroid_baru[1][1]; ?></td>
                            </tr>
                            <tr>
                                <td>Usaha Menengah</td>
                                <td><?= $centroid_baru[2][0]; ?></td>
                                <td><?= $centroid_baru[2][1]; ?></td>
                            </tr>

                    </tbody>
                </table>
                <!-- tabel untuk mencari nilai rata -->

            <?php

                // memanggil function cluster baru
                // dd($cls);
                // dd($centroid_baru);
                // dd($centroid, $centroid_b);
                // dd($nilai_rata);
                $cluster_baru = ClusterBaru($cls, $iterasi);
                $centroid_new = CentroidNew($centroid, $iterasi);
                // dd($centroid_new);
                // dd($cluster_baru);
                if (!$centroid_new) {

                    // berhenti
                    break;
                }
                // if (!$cluster_baru) {

                //     // berhenti
                //     break;
                // }
                // dd($cluster_baru);
            }

            ?>

            <hr>
            <h6>Hasil Perhitungan</h6>
            <!-- tabal untuk Hasil Perhitungan cluster -->
            <table  class="table table-bordered">
                <thead>
                    <tr>
                        <th>Usaha Mikro</th>
                        <th>Usaha Kecil</th>
                        <th>Usaha Menengah</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($hasil_class as $key => $value) {
                            echo "<tr>";
                                for ($i = 1; $i <= count($centroid); $i++) {
                                echo empty($value["class" . $i]) ? "<td align='center'> - </td>" : "<td>" . str_replace("_", " ", $value["class" . $i]) . "</td>";
                            }
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
            <!-- pembagian untuk Hasil Perhitungan cluster -->

            <div class="my-3">
                <form action="{{ route('data_kmeans.store') }}" method="POST">
                    @csrf
                    <?php
                        foreach ($hasil_class as $key => $value) {
                            for ($i = 1; $i <= count($centroid); $i++) {
                                $className = "class" . $i;
                                $valueOfClass = isset($value[$className]) ? $value[$className] : "";
                                echo "<input type='hidden' name='{$className}[]' value='" . str_replace("_", " ", $valueOfClass) . "'>";
                            }
                        }
                    ?>
                    <button class="btn btn-primary float-right" type="submit">Lihat Hasil</button>
                </form>
            </div>
        </div>
    @endif
    
</div>

@endsection
@push('script')
    <script>
    </script>   
@endpush