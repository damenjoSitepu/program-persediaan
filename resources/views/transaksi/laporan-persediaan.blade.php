<div class="">
    @php
        $previousPesan = [];

        // Mendapatkan sekumpulan array berisi pesan lengkap dengan data pesan dan barangnya
        $progressivePesan     = [];
        $progressiveNonPesan  = [];

        $answerPesan = [];
        
        foreach($getPesan as $pesans){
          // New Code

          $getDetail = DB::select("SELECT * FROM persediaan_detail INNER JOIN barang ON persediaan_detail.barang_id = barang.barang_id WHERE persediaan_detail.persediaan_id='{$pesans->persediaan_id}'");

          $arrayBarangSementara = [];
          foreach($getDetail as $detail){
              array_push($arrayBarangSementara,[
                'barang_collection'   => [
                  'barang_id'   => $detail->barang_id,
                  'nm_barang'   => $detail->nm_barang,
                  'sisa'        => $detail->sisa,
                  'barang_entry'=> $detail->barang_entry,
                  'pesan_id'    => $pesans->pesan_id,
                  'is_next'     => $detail->is_next
                ]
          ]);
          }

          // Push Data
          array_push($answerPesan,[
            'pesan_set'   => [
              'pesan_id'        => $pesans->pesan_id,
              'persediaan_id'   => $pesans->persediaan_id,
              'tanggal_pesan'   => $pesans->tanggal_pesan
            ],
            'barang_set' => $arrayBarangSementara
          ]);



          
          // End New Code

          $getDetailLists = DB::select("SELECT * FROM persediaan_detail INNER JOIN barang ON persediaan_detail.barang_id = barang.barang_id WHERE persediaan_detail.persediaan_id='{$pesans->persediaan_id}' AND persediaan_detail.is_next=1");

          $getDetailNonLists = DB::select("SELECT * FROM persediaan_detail INNER JOIN barang ON persediaan_detail.barang_id = barang.barang_id WHERE persediaan_detail.persediaan_id='{$pesans->persediaan_id}' AND persediaan_detail.is_next=0");

          // Progressive Code
          $arraySementara = [];
          foreach($getDetailLists as $list){
              array_push($arraySementara,[
                'barang_collection'   => [
                  'barang_id'   => $list->barang_id,
                  'nm_barang'   => $list->nm_barang,
                  'sisa'        => $list->sisa,
                  'barang_entry'=> $list->barang_entry,
                  'pesan_id'    => $pesans->pesan_id
                ]
          ]);
          }

          $arraySementaraNon = [];
          foreach($getDetailNonLists as $nonlist){
              array_push($arraySementaraNon,[
                'barang_collection'   => [
                  'barang_id'   => $nonlist->barang_id,
                  'nm_barang'   => $nonlist->nm_barang,
                  'sisa'        => $nonlist->sisa,
                  'barang_entry'=> $nonlist->barang_entry
                ]
          ]);
          }

          // Push Data
          array_push($progressivePesan,[
            'pesan_set'   => [
              'pesan_id'        => $pesans->pesan_id,
              'persediaan_id'   => $pesans->persediaan_id,
              'tanggal_pesan'   => $pesans->tanggal_pesan
            ],
            'barang_set' => $arraySementara
          ]);

          array_push($progressiveNonPesan,[
            'pesan_set'   => [
              'pesan_id'        => $pesans->pesan_id,
              'persediaan_id'   => $pesans->persediaan_id,
              'tanggal_pesan'   => $pesans->tanggal_pesan
            ],
            'barang_set' => $arraySementaraNon
          ]);
          // End Progressive Code
        }
    @endphp






    @foreach($getPesan as $pesan)
    @php
    $loopInit = $loop->iteration;
    // NEW - NEW CODE
    $getDetails = DB::select("SELECT * FROM pesan INNER JOIN persediaan_detail ON pesan.persediaan_id = persediaan_detail.persediaan_id INNER JOIN barang ON persediaan_detail.barang_id = barang.barang_id WHERE persediaan_detail.persediaan_id='{$pesan->persediaan_id}' ORDER BY barang.barang_id DESC, persediaan_detail.is_next DESC");
  
    // END NEW - NEW CODE 
    if($loopInit > 1){

      $arrayAnswer = [];
      // Loop setiap produk di dalam list order
      for($i = 0; $i < count($getDetails); $i++){
        // Dapatkan jumlah list order yang akan diperiksa sebelum list order terbaru
        $newAnswerPesan = array_slice($answerPesan,0,$loopInit);

        $destroyLoop = false;

        // Loop Semua kemungkinan list order yang sudah ditampung
        for($j = count($newAnswerPesan) - 2; $j >= 0; $j--){
          // loop semua barang yang ada di list order yang sudah ditampung
          for($k = 0; $k < count($answerPesan[$j]['barang_set']); $k++){
            if($getDetails[$i]->is_next == 1){
              if($getDetails[$i]->barang_id == $answerPesan[$j]['barang_set'][$k]['barang_collection']['barang_id'] && $getDetails[$i]->sisa != ($answerPesan[$j]['barang_set'][$k]['barang_collection']['sisa'] + $answerPesan[$j]['barang_set'][$k]['barang_collection']['barang_entry'])){
                array_push($arrayAnswer,[
                  'barang_id'  => $getDetails[$i]->barang_id,
                  'nm_barang' => $getDetails[$i]->nm_barang,
                  'list_before' => $answerPesan[$j]['pesan_set']['pesan_id'],
                  'stok_before' => $answerPesan[$j]['barang_set'][$k]['barang_collection']['sisa'] + $answerPesan[$j]['barang_set'][$k]['barang_collection']['barang_entry'],
                  'tanggal_before'  => $answerPesan[$j]['pesan_set']['tanggal_pesan'],
                  'list_after'  => $getDetails[$i]->pesan_id,
                  'stok_after'  => $getDetails[$i]->sisa,
                  'tanggal_after'   => $pesan->tanggal_pesan,
                  'status'      => $answerPesan[$j]['barang_set'][$k]['barang_collection']['barang_entry']
                ]);
                $destroyLoop = true;
              }elseif($getDetails[$i]->barang_id == $answerPesan[$j]['barang_set'][$k]['barang_collection']['barang_id'] && $getDetails[$i]->sisa == ($answerPesan[$j]['barang_set'][$k]['barang_collection']['sisa'] + $answerPesan[$j]['barang_set'][$k]['barang_collection']['barang_entry'])){
                $destroyLoop = true;
              }
            }else {
              if($getDetails[$i]->barang_id == $answerPesan[$j]['barang_set'][$k]['barang_collection']['barang_id'] && $getDetails[$i]->sisa != ($answerPesan[$j]['barang_set'][$k]['barang_collection']['sisa'] + $answerPesan[$j]['barang_set'][$k]['barang_collection']['barang_entry'])){
                array_push($arrayAnswer,[
                  'barang_id'  => $getDetails[$i]->barang_id,
                  'nm_barang' => $getDetails[$i]->nm_barang,
                  'list_before' => $answerPesan[$j]['pesan_set']['pesan_id'],
                  'stok_before' => $answerPesan[$j]['barang_set'][$k]['barang_collection']['sisa'] + $answerPesan[$j]['barang_set'][$k]['barang_collection']['barang_entry'],
                  'tanggal_before'  => $answerPesan[$j]['pesan_set']['tanggal_pesan'],
                  'list_after'  => $getDetails[$i]->pesan_id,
                  'stok_after'  => $getDetails[$i]->sisa,
                  'tanggal_after'   => $pesan->tanggal_pesan,
                  'status'      => $answerPesan[$j]['barang_set'][$k]['barang_collection']['barang_entry']
                ]);
                $destroyLoop = true;
              }elseif($getDetails[$i]->barang_id == $answerPesan[$j]['barang_set'][$k]['barang_collection']['barang_id'] && $getDetails[$i]->sisa == ($answerPesan[$j]['barang_set'][$k]['barang_collection']['sisa'] + $answerPesan[$j]['barang_set'][$k]['barang_collection']['barang_entry'])){
                $destroyLoop = true;
              }
            }
          }
          if($destroyLoop)
              break;
          // Loop semua barang yang ada di list order yang sudah ditampung
        }
        // End Loop semua kemungkinan list order yang sudah ditampung
      }
      // End loop setiap produk di dalam list order
    }


    $getDetailList = DB::select("SELECT * FROM persediaan_detail INNER JOIN barang ON persediaan_detail.barang_id = barang.barang_id WHERE persediaan_detail.persediaan_id='{$pesan->persediaan_id}' AND persediaan_detail.is_next=1");

    $getDetailNonList = DB::select("SELECT * FROM persediaan_detail INNER JOIN barang ON persediaan_detail.barang_id = barang.barang_id WHERE persediaan_detail.persediaan_id='{$pesan->persediaan_id}' AND persediaan_detail.is_next=0");
    @endphp

    
    @if($loopInit > 1)
      {{-- Cek apakah ada perbedaan stok penyesuaian stok antara list order selanjutnya dengan sebelumnya, jika ada, maka tampilkan adanya --}}
      @if(count($arrayAnswer) != 0)
        {{-- Generate UI --}}
        <div class="p-4 shadow my-5 border border-primary rounded">
          <div class="pb-3 border-bottom border-success">
            <h5 class="text-center"><i class="fas fa-gear text-primary"></i><span class="text-primary"> Penyesuaian Persediaan</h5>
          </div>

          {{-- LIST --}}
          @if(count($arrayAnswer) != 0)
            <table class="table mt-4">
              <thead class="bg-primary text-light">
                  <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Nama Barang</th>
                    <th scope="col">List Order ID Terakhir</th>
                    <th scope="col">Stok</th>
                    <th scope="col">List Order ID Terbaru</th>
                    <th scope="col">Stok</th>
                    <th scope="col">Penyesuaian Stok</th>
                  </tr>
              </thead>
            @php
                // dump($getDetails);
            @endphp
              <tbody>
                @foreach($arrayAnswer as $answer)
                  <tr class="align-middle {{ $answer['status'] == 0 ? 'text-danger' : 'text-dark'}}">
                    <th scope="row" style="border-right: 5px solid {{ $answer['status'] == 0 ? '#dc3545' : '#0d6efd'}}; box-sizing: border-box;">{{ $loop->iteration }}</th>
                    <td>{{ $answer['nm_barang'] }}</td>
                    <td class="fw-bold">{{ $answer['list_before'] }} - ( {{ date('l, d-M-Y',strtotime($answer['tanggal_before'])) }} )</td>
                    <td>{{ $answer['stok_before'] }}</td>
                    <td class="fw-bold">{{ $answer['list_after'] }} - ( {{ date('l, d-M-Y',strtotime($answer['tanggal_after'])) }} )</td>
                    <td>{{ $answer['stok_after'] }}</td>
                    <td class="fw-bold">
                      {{ abs($answer['stok_after'] - $answer['stok_before']) }}
                      {!!
                          $answer['stok_after'] - $answer['stok_before'] < 0 ? '<span class="text-danger">Stok Keluar</span>' : '<span class="text-success">Stok Masuk</span>'
                      !!}
                    </td>
                  </tr>
                @endforeach                   
              </tbody>
            </table>
          @endif    
      @endif
    </div>
    {{-- End Generate UI --}}
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
                  <th scope="col">Stok List Order</th>
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
                      <th scope="col">Stok Tanpa List Order</th>
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
    // dd($answerPesan);
@endphp