@if($loopInit > 1)
                @for($i = 0; $i < count($getDetails); $i++)
                    @php
                    // Berikan limit terhadap progressive pesan
                    $loopInitLimit = $loopInit;
                    // dump($getDetails);
                    $newAnswerPesan = array_slice($answerPesan,0,$loopInitLimit);
                    
                    $breakLoops = false;
                    @endphp
                    {{-- Loop Semua kemungkinan list order yang ditampung --}}
                    @for($j = count($newAnswerPesan) - 2 ; $j >= 0; $j--)
                      {{-- Loop semua barang yang masuk dalam kualifikasi list order yang ada untuk diperiksa --}}
                      @for($k = 0; $k < count($answerPesan[$j]['barang_set']); $k++)
                        {{-- Pemeriksan apakah barang tersebut masuk memiliki penyesuaian atau tidak --}}
                        {{-- kalo 0 = maka sisa dibandingkan dengan sisa, kalo 1 maka sisa dibandingkan dengan sisa dan sisa + barang entry  --}}
                          @if($getDetails[$i]->barang_id == $answerPesan[$j]['barang_set'][$k]['barang_collection']['barang_id'] && $getDetails[$i]->sisa != ($answerPesan[$j]['barang_set'][$k]['barang_collection']['sisa'] + $answerPesan[$j]['barang_set'][$k]['barang_collection']['barang_entry']))

                            
                          <tr class="align-middle">
                        
                            <th scope="row">{{ $i + 1 }}</th>

                            <td>{{ $getDetails[$i]->nm_barang }}</td>

                            <td class="text-primary fw-bold"><span class="text-primary fw-bold">{{ $answerPesan[$j]['pesan_set']['pesan_id'] }}</span> ( {{ date('d, M Y',strtotime($answerPesan[$j]['pesan_set']['tanggal_pesan'])) }} )</td>

                            <td>{{ ($answerPesan[$j]['barang_set'][$k]['barang_collection']['sisa'] + $answerPesan[$j]['barang_set'][$k]['barang_collection']['barang_entry']) }}</td>

                            <td class="text-primary fw-bold"><span class="text-primary fw-bold">{{ $pesan->pesan_id }}</span> ( {{ date('d, M Y',strtotime($pesan->tanggal_pesan)) }} )</td>

                            <td>{{ $getDetails[$i]->sisa }}</td>

                            <td class="fw-bold">{{ abs($getDetails[$i]->sisa - ($answerPesan[$j]['barang_set'][$k]['barang_collection']['sisa'] + $answerPesan[$j]['barang_set'][$k]['barang_collection']['barang_entry'])) }}   
                              {!! $getDetails[$i]->sisa - ($answerPesan[$j]['barang_set'][$k]['barang_collection']['sisa'] + $answerPesan[$j]['barang_set'][$k]['barang_collection']['barang_entry']) < 0 ? '<span class="text-danger">Stok Keluar</span>' : '<span class="text-success">Stok Masuk</span>' !!}</td>

                            <td>{{ $answerPesan[$j]['barang_set'][$k]['barang_collection']['is_next'] }}</td>
                          </tr>
                          @php
                          $breakLoops = true;
                          @endphp
                          @endif
                        

                        
                        {{-- End pemeriksaan apakah barang tersebut masuk memiliki penyesuaian atau tidak --}}
                      @endfor
                      @php
                        if($breakLoops)
                        break;
                      @endphp
                      {{-- End loop semua barang yang masuk dalam kualifikasi list order yang ada untuk diperiksa --}}
                    @endfor
                    {{-- End Loop semua kemungkinan list order yang ditampung --}}
                  @endfor
                @endif