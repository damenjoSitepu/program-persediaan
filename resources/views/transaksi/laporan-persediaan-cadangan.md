<div class="">
    @php
    $previousPesan = [];

    // Mendapatkan sekumpulan array berisi pesan lengkap dengan data pesan dan barangnya
    $progressivePesan = [];
    $progressiveAnswer = [];

    foreach($getPesan as $pesans){
    $getDetailLists = DB::select("SELECT * FROM persediaan_detail INNER JOIN barang ON persediaan_detail.barang_id = barang.barang_id WHERE persediaan_detail.persediaan_id='{$pesans->persediaan_id}' AND persediaan_detail.is_next=1");

    // Progressive Code
    $arraySementara = [];
    foreach($getDetailLists as $list){
    array_push($arraySementara,[
    'barang_collection' => [
    'barang_id' => $list->barang_id,
    'nm_barang' => $list->nm_barang,
    'sisa' => $list->sisa,
    'barang_entry'=> $list->barang_entry
    ]
    ]);
    }

    // Push Data
    array_push($progressivePesan,[
    'pesan_set' => [
    'pesan_id' => $pesans->pesan_id,
    'persediaan_id' => $pesans->persediaan_id,
    'tanggal_pesan' => $pesans->tanggal_pesan
    ],
    'barang_set' => $arraySementara
    ]);
    // End Progressive Code
    }
    @endphp

    @foreach($getPesan as $pesan)
    @php
    $loopInit = $loop->iteration;

    $getDetailList = DB::select("SELECT * FROM persediaan_detail INNER JOIN barang ON persediaan_detail.barang_id = barang.barang_id WHERE persediaan_detail.persediaan_id='{$pesan->persediaan_id}' AND persediaan_detail.is_next=1");

    $getDetailNonList = DB::select("SELECT * FROM persediaan_detail INNER JOIN barang ON persediaan_detail.barang_id = barang.barang_id WHERE persediaan_detail.persediaan_id='{$pesan->persediaan_id}' AND persediaan_detail.is_next=0");

    // Progressive Code
    if($loopInit > 1){
    // $arraySementaras = [];
    $countList = 0;
    for($i = 0; $i < count($getDetailList); $i++){ $breakLoop=false; for($j=count($progressivePesan) - 2; $j> 0; $j--){

        for($k = 0; $k < count($progressivePesan[$j]['barang_set']); $k++){ if($getDetailList[$i]->barang_id == $progressivePesan[$j]['barang_set'][$k]['barang_collection']['barang_id']){
            $countList++;
            $breakLoop = true;
            }
            }
            if($breakLoop)
            break;
            }


            }
            }


            // End Progressive Code
            @endphp

            {{-- Cek apakah ada perbedaan stok penyesuaian stok antara list order selanjutnya dengan sebelumnya, jika ada, maka tampilkan adanya --}}

            @if($loopInit > 1)
            @if($countList != 0)
            @for($i = 0; $i < count($getDetailList); $i++) @php // Berikan limit terhadap progressive pesan $loopInitLimit=$loopInit; $newProgressivePesan=array_slice($progressivePesan,0,$loopInitLimit); $breakLoops=false; @endphp @for($j=count($newProgressivePesan) - 2; $j>= 0; $j--)
                @for($k = 0; $k < count($progressivePesan[$j]['barang_set']); $k++) @if($getDetailList[$i]->barang_id == $progressivePesan[$j]['barang_set'][$k]['barang_collection']['barang_id'] && $getDetailList[$i]->sisa != ($progressivePesan[$j]['barang_set'][$k]['barang_collection']['sisa'] + $progressivePesan[$j]['barang_set'][$k]['barang_collection']['barang_entry']))
                    {{-- Generate UI --}}
                    <div class="p-4 shadow my-5 ">
                        <div class="pb-3 border-bottom border-success">
                            <h5><i class="fas fa-scroll text-success"></i><span class="text-success"> Penyesuaian Persediaan Antara</h5>
                            <h6><span class="text-danger">List Order ID: {{ $progressivePesan[$j]['pesan_set']['pesan_id'] }} - [ Persediaan ID: {{ $progressivePesan[$j]['pesan_set']['persediaan_id'] }} ] ( {{ date('l, j-M-Y',strtotime($pesan->tanggal_pesan)) }} )</span> dan <span class="text-primary">List Order ID: {{ $pesan->pesan_id }} - [ Persediaan ID: {{ $pesan->persediaan_id }} ] ( {{ date('l, j-M-Y',strtotime($pesan->tanggal_pesan)) }} )</span></h6>
                        </div>

                        <h6 class="text-primary mt-4 fw-bold text-decoration-underline mb-4"><i class="fas fa-list-check"></i> Masuk List Order</h6>

                        <table class="table table-hover mt-4">
                            <thead class="bg-primary text-light">
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Nama Barang</th>
                                    <th scope="col">( Pembelian + Penyesuaian ) List Order {{ $progressivePesan[$j]['pesan_set']['pesan_id'] }}</th>
                                    <th scope="col">Penyesuaian List Order {{ $pesan->pesan_id }} </th>
                                    <th scope="col">Status Stok</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr class="align-middle">
                                    <th scope="row">{{ $i + 1 }}</th>
                                    <td>{{ $getDetailList[$i]->nm_barang }}</td>
                                    <td>{{ $progressivePesan[$j]['barang_set'][$k]['barang_collection']['sisa'] + $progressivePesan[$j]['barang_set'][$k]['barang_collection']['barang_entry']}}</td>
                                    <td>{{ $getDetailList[$i]->sisa }}</td>
                                    <td class="fw-bold">{{ abs($getDetailList[$i]->sisa - ($progressivePesan[$j]['barang_set'][$k]['barang_collection']['sisa'] + $progressivePesan[$j]['barang_set'][$k]['barang_collection']['barang_entry'])) }}
                                        {!! $getDetailList[$i]->sisa - ($progressivePesan[$j]['barang_set'][$k]['barang_collection']['sisa'] + $progressivePesan[$j]['barang_set'][$k]['barang_collection']['barang_entry']) < 0 ? '<span class="text-danger">Keluar</span>' : '<span class="text-success">Masuk</span>' !!}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>


                    {{-- End Generate UI --}}
                    @php
                    $breakLoops = true;
                    @endphp
                    @endif
                    @endfor
                    @php
                    if($breakLoops)
                    break;
                    @endphp
                    @endfor
                    @endfor
                    @endif
                    @endif

                    <div class="p-4 shadow my-5">
                        <div class="d-flex justify-content-between align-items-center w-75 border-bottom border-primary">
                            <h5><i class="fas fa-scroll text-danger"></i> List Order ID: {{ $pesan->pesan_id }} - [ Persediaan ID: {{ $pesan->persediaan_id }} ]</h5>
                            <small class="text-primary fs-6 fw-bold">Per Tanggal ( {{ date('l, j-M-Y',strtotime($pesan->tanggal_pesan)) }} )</small>
                        </div>


                        @if(count($getDetailList) > 0)
                        <h6 class="text-primary mt-4 fw-bold text-decoration-underline mb-4"><i class="fas fa-list-check"></i> Masuk List Order</h6>

                        <table class="table table-hover">
                            <thead class="bg-primary text-light">
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Nama Barang</th>
                                    <th scope="col">Stok Awal</th>
                                    <th scope="col">Pembelian</th>
                                    <th scope="col">Stok Akhir</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($getDetailList as $list)
                                <tr class="align-middle">
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $list->nm_barang }}</td>
                                    <td>{{ $list->sisa }}</td>
                                    <td>{{ $list->barang_entry }}</td>
                                    <td>{{ $list->barang_entry + $list->sisa }}</td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                        @endif

                        @if(count($getDetailNonList) > 0)
                        <h6 class="text-danger mt-4 fw-bold text-decoration-underline mb-4"><i class="fas fa-list-check"></i> Tidak Termasuk List Order</h6>

                        <table class="table table-hover">
                            <thead class="bg-danger  text-light">
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Nama Barang</th>
                                    <th scope="col">Stok Konstan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($getDetailNonList as $list)
                                <tr class="align-middle">
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $list->nm_barang }}</td>
                                    <td>{{ $list->sisa }}</td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                        @endif
                    </div>
                    @endforeach
</div>

@php
// dd($previousProgressivePesan);
// dd($previousProgressiveAnswer);
// dd($progressivePesan);
@endphp