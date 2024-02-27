<?php

/**
 * Write code on Method
 *
 * @return response()
 */
if (!function_exists('moneyFormat')) {
    function moneyFormat($amount)
    {
        return '$' . number_format($amount, 2);
    }
}

if (!function_exists('CentroidAwal')) {
    // fungsi untuk membuat atau mengambil nilai acak centroid pada data
    function CentroidAwal($data, $centroid)
    {
        // dd($data);
        $ctr = array(
            0 => array(
                0 => "1",
                1 => "1"
            ),
            1 => array(
                0 => "1",
                1 => "2"
            ),
            2 => array(
                0 => "2",
                1 => "3"
            ),
        );
        // dd($ctr);
        // for ($i = 0; $i < $centroid; $i++) {
        //     $ctr[] = [
        //         $data[$i][0],
        //         $data[$i][1],
        //     ];
        // }
        // mengembalikan nilai atau hasil
        return $ctr;
    }
}

if (!function_exists('RumusPersamaanED')) {
    // fungsi untuk meghitung rumus persamaan ed
    function RumusPersamaanED($kolom, $cluster)
    {
        $hasil = [];

        foreach ($kolom as $key => $value) {

            foreach ($cluster as $key1 => $cnt) {

                // $hasil[$key][] = sqrt(pow($value[0] - $cnt[0], 2) + pow($value[1] - $cnt[1], 2) + pow($value[2] - $cnt[2], 2));
                $hasil[$key][] = sqrt(pow($value[0] - $cnt[0], 2) + pow($value[1] - $cnt[1], 2));
            }
        }
        // mengambilkan nilai atau hasil
        return $hasil;
    }
}

if (!function_exists('NilaiTerkecil')) {
    // funsi untuk mengambil nilai terkecil pada hasil pembagian cluster
    function NilaiTerkecil(array $cluster, $data)
    {

        // untuk menambah 1
        $no    = 0;
        $nilai = [];
        $min   = [];

        for ($i = 0; $i < count($data); $i++) {

            foreach ($cluster as $key => $value) {

                // mengambil nilai secara berpasanagan pada key
                $nilai[$i][] = $value[$no];
            }

            $no++;
        }

        // untuk jarak terdekat menentukan nilai terkecil
        foreach ($nilai as $key => $value) {

            // menentukan nilai terkecil pada nilai
            $min[] = min($value);
        }

        // mengambilkan nilai atau hasil
        return $min;
    }
}

if (!function_exists('NilaiRatarata')) {
    // untuk mencari nilai rata pada tabel iterasi
    function NilaiRatarata(array $cluster)
    {
        $centroid_baru = [];

        foreach ($cluster as $key => $value) {

            $centroid_baru[$key] = [
                array_sum($value[0]) / count($value[0]),
                array_sum($value[1]) / count($value[1]),
                array_sum($value[2]) / count($value[2])
            ];
        }

        // mengambilkan nilai atau hasil
        return $centroid_baru;
    }
}

if (!function_exists('CentroidBaru')) {
    // untuk mengambil hasil centroid baru
    function CentroidBaru(array $centroid_baru)
    {
        // mengambilkan nilai atau hasil
        return $centroid_baru;
    }
}

if (!function_exists('CentroidNew')) {
    // untuk mengambil hasil centroid baru
    function CentroidNew(array $centroid_new, $iterasi)
    {
        // Periksa apakah indeks ada di array $cluster
        if (!array_key_exists($iterasi - 1, $centroid_new) || !array_key_exists($iterasi, $centroid_new)) {
            return false; // Atau tangani kesalahan yang sesuai
        }

        // mengambil centroid lama
        $centroid_lama = flatten_array($centroid_new[($iterasi - 1)]);

        // mengambil centroid baru
        $centroid_baru = flatten_array($centroid_new[$iterasi]);

        $jumlah_sama   = 0;

        for ($i = 0; $i < count($centroid_lama); $i++) {

            if ($centroid_lama[$i] === $centroid_baru[$i]) {

                $jumlah_sama++;
            }
        }

        // mengambilkan nilai atau hasil
        return $jumlah_sama === count($centroid_lama) ? false : true;
    }
}

if (!function_exists('ClusterBaru')) {
    // untuk menentukan sampai cluster sama lalu berhenti
    function ClusterBaru(array $cluster, $iterasi)
    {

        // Periksa apakah indeks ada di array $cluster
        if (!array_key_exists($iterasi - 1, $cluster) || !array_key_exists($iterasi, $cluster)) {
            return false; // Atau tangani kesalahan yang sesuai
        }

        // mengambil centroid lama
        $centroid_lama = flatten_array($cluster[($iterasi - 1)]);

        // mengambil centroid baru
        $centroid_baru = flatten_array($cluster[$iterasi]);

        $jumlah_sama   = 0;

        for ($i = 0; $i < count($centroid_lama); $i++) {

            if ($centroid_lama[$i] === $centroid_baru[$i]) {

                $jumlah_sama++;
            }
        }

        // mengambilkan nilai atau hasil
        return $jumlah_sama === count($centroid_lama) ? false : true;
    }
}

if (!function_exists('flatten_array')) {
    // untuk mengambil data yang akan dicocokkan
    function flatten_array($arg)
    {
        // mengambilkan nilai atau hasil
        return is_array($arg) ? array_reduce($arg, function ($c, $a) {
            return array_merge($c, flatten_array($a));
        }, []) : [$arg];
    }
}

if (!function_exists('generate_perhitungan')) {
    // untuk mengambil data yang akan dicocokkan
    function generate_perhitungan($data, $centroid)
    {
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
            return array_push($hasil_baru, $tabel_iterasi);
        }
    }
}
