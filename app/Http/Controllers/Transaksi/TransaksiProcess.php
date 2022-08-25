<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Rules\SelectKeeper;

class TransaksiProcess extends Controller
{
    public $Persediaan, $Barang, $Pesan;

    public function __construct()
    {
        $this->Persediaan   = new \App\Models\PersediaanModel();
        $this->Barang       = new \App\Models\BarangModel();
        $this->Pesan        = new \App\Models\PesanModel();
    }

    // Proses buat list order
    public function buatlistorder($id = 0, Request $request)
    {
        // Validasi
        $request->validate([
            'tanggal_pesan'                 => 'required',
            'supplier_id'                   => [new SelectKeeper]
        ]);

        // Dapat get pesan by id
        $getPersediaanStatus = $this->Persediaan->getLatestPersediaanId();

        // Ambil data
        $persediaan_id  = $id;
        $tanggal_pesan  = $request->tanggal_pesan;
        $supplier_id    = $request->supplier_id;
        $admin_id       = session()->get('login')['user_id'];
        // Barang
        $barang_id      = $request->barang_id;
        $tambahsisa     = $request->tambahsisa;
        $oldtambahsisa  = $request->oldtambahsisa;

        // Minimal harus ada satu barang yang stoknya ditambahkan ke dalam list order
        $triggerZeroValue = 0;
        foreach ($tambahsisa as $sisa) {
            if ($sisa != 0)
                $triggerZeroValue += 1;

            if ($sisa == '')
                return redirect()->route('transaksi-data-sub-id', ['sub' => 'detail-form-barang', 'id' => $id])->with('message', 'Tidak Boleh Mengosongkan Salah Satu Stok Untuk Setiap Barang Yang Ada Di Dalam Form Barang Ini!')->withInput();
        }

        if ($triggerZeroValue == 0 && $getPersediaanStatus->is_confirm_by_admin == 0)
            return redirect()->route('transaksi-data-sub-id', ['sub' => 'detail-form-barang', 'id' => $id])->with('message', 'Minimal Harus Ada Satu Stok Barang Yang Ditambahkan Ke Dalam List Order!')->withInput();
        elseif ($triggerZeroValue == 0 && $getPersediaanStatus->is_confirm_by_admin == 1)
            return redirect()->route('transaksi-data-sub-id', ['sub' => 'detail-form-barang', 'id' => $id])->with('message', 'Anda Sudah Pernah Membuat List Order Untuk Form Data Barang Ini Sebelumnya, dan Asumsi Kami Sekarang Anda Mencoba Untuk Memperbarui List Order Ini. Menurut Regulasi, Setidaknya Harus Ada Satu Jenis Barang Yang Dipesan Dengan Menambahkan Stok Barang Yang Tersedia Di List Input!')->withInput();

        // Simpan array
        $dataPesan = [
            'persediaan_id'     => $persediaan_id,
            'tanggal_pesan'     => $tanggal_pesan,
            'supplier_id'       => $supplier_id,
            'admin_id'          => $admin_id,
        ];

        $dataListOrder = [
            'persediaan_id'     => $persediaan_id,
            'tanggal_pesan'     => $tanggal_pesan,
            'supplier_id'       => $supplier_id,
            'admin_id'          => $admin_id,
            'barang_id'         => $barang_id,
            'barang_entry'      => $tambahsisa,
            'oldtambahsisa'     => $oldtambahsisa
        ];

        // Masukkan ke dalam pesan dengan 2 cara
        if ($this->Persediaan->getPersediaanById($id)->is_confirm_by_admin == 0) {
            // buat list order baru
            $this->Pesan->insertPesan($dataPesan);

            // Ubah status is_confirm_by_admin di dalam persediaan menjadi true karena sudah dikonfirmasi oleh admin yang bersangkutan
            $this->Persediaan->konfirmasiFormBarangAdmin($persediaan_id);

            // Update barang entry setiap barang di dalam persediaan detail
            $this->Persediaan->updateBarangEntry($dataListOrder['barang_id'], $dataListOrder['barang_entry'], $persediaan_id);

            // Tambahkan Stoknya ke dalam barang yang real time
            $this->Barang->tambahStokBarang($dataListOrder['barang_id'], $dataListOrder['barang_entry']);

            // Kembalikan 
            return redirect()->route('transaksi-data-sub-id', ['sub' => 'detail-form-barang', 'id' => $id])->with('message', 'List Order Berhasil Dibuat Dan Persediaan Berhasil Ditambahkan!');
        } else {
            // Update saja pesannya tanpa harus membuat ulang list order
            $this->Pesan->updatePesan($id, $dataPesan);

            $getDataPersediaan = $this->Persediaan->getPersediaanById($persediaan_id);

            // Kurangi semua barang di table barang menggunakan old stok lama dari list order yang telah dibuat
            $messageError = '';
            for ($i = 0; $i < count($dataListOrder['barang_id']); $i++) {
                // lacak apakah sudah pernah ada barang yang dibuat dalam form barang setelah tanggal form barang ini
                $checkPersediaanByDateExist = $this->Persediaan->checkPersediaanByDateExist($getDataPersediaan->tanggal_transaksi, $persediaan_id, $dataListOrder['barang_id'][$i]);

                // Jika barang entry yang ingin diupdate sama dengan barang entry database, maka abaikan prosedur ini
                $getSpesificBarangInPersediaan = $this->Persediaan->getSpesificBarangInPersediaan($persediaan_id, $dataListOrder['barang_id'][$i]);

                if ($getSpesificBarangInPersediaan->barang_entry != $dataListOrder['barang_entry'][$i]) {
                    if (empty($checkPersediaanByDateExist)) {
                        $this->Barang->kurangStokBarangs($dataListOrder['barang_id'][$i], $dataListOrder['oldtambahsisa'][$i]);

                        // Tambahkan Stoknya ke dalam barang yang real time
                        $this->Barang->tambahStokBarangs($dataListOrder['barang_id'][$i], $dataListOrder['barang_entry'][$i]);
                    } else {
                        for ($j = 0; $j < count($checkPersediaanByDateExist); $j++) {
                            $messageError .= "[ Barang {$checkPersediaanByDateExist[$j]->nm_barang} Pada Form Barang ID {$checkPersediaanByDateExist[$j]->persediaan_id}] ";
                        }
                    }
                }
            }

            if ($messageError != '') {
                return redirect()->route('transaksi-data-sub-id', ['sub' => 'detail-form-barang', 'id' => $id])->with('message', "{$messageError} Telah Terdeteksi. Kami Berasumsi Jika Anda Sudah Pernah Membuat List Order Data Barang Ini Pada List Order Lain Setelah Tanggal List Order Ini Hendak Diperbarui. Kami Menyarankan Anda Untuk Menghapus List Order Pada Tanggal Lain Setelah List Order Ini Yang Mengandung Data-Data Barang Yang Tercantum Di Peringatan Ini, Atau Menghapus List Order Ini Dan Membuatnya Di Tanggal Selanjutnya");
            }

            // Update barang entry setiap barang di dalam persediaan detail
            $this->Persediaan->updateBarangEntry($dataListOrder['barang_id'], $dataListOrder['barang_entry'], $persediaan_id);

            // Kembalikan 
            return redirect()->route('transaksi-data-sub-id', ['sub' => 'detail-form-barang', 'id' => $id])->with('message', 'List Order Berhasil Diperbarui!');
        }
    }

    // Proses konfirmasi form barang
    public function konfirmasiformbarang($id = 0, Request $request)
    {
        // Ambil data
        $sisa = $request->sisa;
        $barang_id = $request->barang_id;

        // Validasi form barang sisa
        foreach ($sisa as $validasiSisa) {
            if ($validasiSisa == 0)
                return redirect()->route('transaksi-extra-data-sub-id', ['sub' => 'penyesuaian-form-barang-picker', 'id' => $id])->with('message', 'Mohon Untuk Mengisi Seluruh Stok Pada Setiap Barang Di Form Barang Yang Telah Dibuat Oleh Admin Yang Bersangkutan!');
        }

        // Simpan ke dalam array
        $dataFormBarang = [
            'persediaan_id'             => $id,
            'sisa'                      => $sisa,
            'barang_id'                 => $barang_id
        ];

        // Masukkan ke dalam database persediaan detail ( barang )
        $this->Persediaan->penyesuaianFormBarang($dataFormBarang['persediaan_id'], $dataFormBarang['sisa'], $dataFormBarang['barang_id']);

        // Cek apakah sudah pernah ada 

        // Menyesuaikan jumlah stok barang dengan bagian database barang
        for ($i = 0; $i < count($dataFormBarang['barang_id']); $i++) {
            $this->Barang->penyesuaianFormBarang($dataFormBarang['barang_id'][$i], $dataFormBarang['sisa'][$i]);
        }
        // $this->Barang->penyesuaianFormBarang($dataFormBarang['barang_id'], $dataFormBarang['sisa']);

        // Konfirmasi jika persediaan ini telah selesai dikonfirmasi / disesuaikan
        $this->Persediaan->konfirmasiFormBarang($dataFormBarang['persediaan_id']);

        // Kembalikan 
        return redirect()->route('transaksi-extra-data-sub', ['sub' => 'form-barang-picker'])->with('message', 'Data Form Barang Berhasil Disesuaikan Dan Dikirimkan Kepada Admin Yang Bersangkutan Untuk Dibuatkan List Order!');
    }

    // Proses untuk membuat form barang 
    public function index(Request $request)
    {
        // Validasi
        $request->validate([
            'tanggal_transaksi'                 => 'required',
            'picker_gudang_id'                  => 'required'
        ]);

        // Dapatkan Data
        $tanggal_transaksi              = $request->tanggal_transaksi;
        $picker_gudang_id               = $request->picker_gudang_id;

        // Simpan ke dalam array
        $dataFormBarang = [
            'tanggal_transaksi'         => $tanggal_transaksi,
            'picker_gudang_id'          => $picker_gudang_id,
            'admin_id'                  => session()->get('login')['user_id'],
            'barang_id'                 => $request->barang_id
        ];

        // Cek apakah ada barang id yang hendak di tambahkan ke form barang ini, sedangkan di form barang sebelumnya sudah pernah ada barang tersebut namun belum disesuaikan 
        $rejectBarang = '';

        for ($i = 0; $i < count($dataFormBarang['barang_id']); $i++) {
            $checkPersediaanExist = $this->Persediaan->checkPersediaanExist($dataFormBarang['barang_id'][$i]);

            if (!empty($checkPersediaanExist)) {
                $rejectBarang .= "[ Barang: {$checkPersediaanExist->nm_barang} Pada Kode Form Barang ID : {$checkPersediaanExist->persediaan_id} ] ";
            }
        }

        if ($rejectBarang != '') {
            return redirect()->route('transaksi-data-sub', ['sub' => 'form-barang'])->with('message', "{$rejectBarang} Telah Terdeteksi. Anda Tidak Bisa Membuat Form Barang Dengan Daftar Barang Yang Belum Disesuaikan dan Dibuat Order List Pada Form Barang Sebelumnya.");
        }

        // Cek apakah ada barang pada form pada tanggal setelah tanggal transaksi ini akan dilakukan
        $messageError = '';
        for ($i = 0; $i < count($dataFormBarang['barang_id']); $i++) {
            $getText = $this->Persediaan->checkPersediaanAfterThisDate($tanggal_transaksi, $dataFormBarang['barang_id'][$i]);

            if (!empty($getText)) {
                for ($j = 0; $j < count($getText); $j++) {
                    $messageError .= "[ Terdeteksi Barang {$getText[$j]->nama_barang} Pada Form Barang ID: ( {$getText[$j]->id_persediaan} ) Per Tanggal ( {$getText[$j]->id_transaksi} ) ] ";
                }
            }
        }

        if ($messageError != '') {
            return redirect()->route('transaksi-data-sub', ['sub' => 'form-barang'])->with('message', "{$messageError} Anda Tidak Dapat Memilih Barang-Barang Ini Karena Sudah Pernah Dicantumkan Dalam Periode Form Barang Setelah Tanggal Calon Form Barang Ini Dibuat. Alternatif Lain Yang Bisa Diambil Untuk Dapat Memilih Barang-Barang Tersebut Adalah Dengan Menghapus Semua Form Barang Yang Berhubungan Dengannya Pada Tanggal Setelah Tanggal Form Barang Ini Dibuat.");
        }

        // Masukkan ke dalam database persediaan
        $this->Persediaan->insertPersediaan($dataFormBarang);

        // Masukkan ke dalam database persediaan detail ( barang )
        $this->Persediaan->insertPersediaanDetail($dataFormBarang['barang_id']);

        // Dapatkan data persediaan id terakhir yang dibuat oleh admin ( form barang )
        $getLatestPersediaanId = $this->Persediaan->getLatestPersediaanId();

        // Dapatkan data stok barang di data barang dan simpan ke dalam persediaan detail ( recovery_sisa ) ( tindakan preventif jika form barang di delete )
        for ($i = 0; $i < count($dataFormBarang['barang_id']); $i++) {
            $getBarang = $this->Barang->getBarangById($dataFormBarang['barang_id'][$i]);

            // Update
            $this->Persediaan->updatePersediaanDetailForSisaRecovery($getLatestPersediaanId->persediaan_id, $getBarang->barang_id, $getBarang->jumlah);
        }

        // Kembalikan 
        return redirect()->route('transaksi-data-sub', ['sub' => 'form-barang'])->with('message', 'Data Form Barang Berhasil Ditambahkan Dan Dikirimkan Kepada Picker Barang Yang Bersangkutan Untuk Diisi!');
    }

    // Proses untuk menghapus list order
    public function hapuslistorder($id = 0)
    {
        // Dapatkan data pesan
        $getPesan = $this->Pesan->getPesanByPesanId($id);
        // Dapatkan data persediaan

        $getPersediaan = $this->Persediaan->getPersediaanById($getPesan->persediaan_id);
        // Kurangi jumlah persediaan dengan barang entry di tabel persediaan detail
        $getPersediaanDetail = $this->Persediaan->getPersediaanDetailById($getPesan->persediaan_id);

        for ($i = 0; $i < count($getPersediaanDetail); $i++) {
            // Jika ada barang pada form barang di tanggal selanjutnya yang terjadi, maka tidak diizinkan untuk mengurangi stok
            $checkPersediaanExistInNextDate = $this->Persediaan->checkPersediaanByDateExist($getPersediaan->tanggal_transaksi, $getPesan->persediaan_id, $getPersediaanDetail[$i]->barang_id);
            // dd($checkPersediaanExistInNextDate);
            if (empty($checkPersediaanExistInNextDate)) {
                // Dapatkan persediaan id sebelum persediaan id form barang ini untuk memperbarui stoknya karena form list order ini akan dihapus
                $getBeforeFormBarang = $this->Persediaan->getPreviousFormBarangBeforeDeleted($id, $getPersediaanDetail[$i]->barang_id);

                if (!empty($getBeforeFormBarang)) {
                    $getNewStock = $getBeforeFormBarang->sisa + $getBeforeFormBarang->barang_entry;

                    $this->Barang->updateBarangStoks($getPersediaanDetail[$i]->barang_id, $getNewStock);
                } else {
                    $this->Barang->tambahKurangStokBarang($getPersediaanDetail[$i]->barang_id, $getPersediaanDetail[$i]->barang_entry, '-');
                }
            }
        }

        // Ubah semua stok barang entry di persediaan detail tersebut kembali menjadi 0
        $this->Persediaan->resetBarangEntryPersediaanDetail($getPesan->persediaan_id);

        // Ubah is confirm by admin di persediaan menjadi default kembali
        $this->Persediaan->resetConfirmByAdminPersediaan($getPesan->persediaan_id);

        // Delete persediaan
        $this->Persediaan->deletePersediaan($getPesan->persediaan_id);

        // Hapus pesan list order
        $this->Pesan->deletePesan($id);

        // Kembalikan 
        return redirect()->route('transaksi-data-sub', ['sub' => 'daftar-pesan'])->with('message', 'Data List Order Telah Dibatalkan dan Dihapus!');
    }

    // Proses untuk menghapus form barang
    public function hapusformbarang($id = 0)
    {
        // Get data
        $persediaan_id = $id;

        // Cek apakah persediaan detail sebelumnya sudah disesuaikan picker gudang atau belum 
        $checkPersediaan = $this->Persediaan->getPersediaanById($persediaan_id);

        if ($checkPersediaan->is_confirm == 1) {
            // Looping masing-masing barang persediaan
            // Balikkan lagi stoknya berdasarkan data form barang selanjutnya ( jika tiap-tiap barang teresebut memang ada stok penyesuaian sebelumnya )
            $getPersediaanDetail = $this->Persediaan->getPersediaanDetailById($persediaan_id);

            for ($i = 0; $i < count($getPersediaanDetail); $i++) {
                $getPreviousStock = $this->Persediaan->getPreviousFormBarangBeforeDeletedWithoutPesan($persediaan_id, $getPersediaanDetail[$i]->barang_id);

                if (!empty($getPreviousStock)) {
                    $getNewStock = $getPreviousStock->sisa + $getPreviousStock->barang_entry;
                } else {
                    $getNewStock = $getPersediaanDetail[$i]->recovery_sisa;
                }

                $this->Barang->updateBarangStoks($getPersediaanDetail[$i]->barang_id, $getNewStock);
            }
        }

        // Hapus langsung form barangnya
        $this->Persediaan->deletePersediaan($persediaan_id);

        // Kembalikan 
        return redirect()->route('transaksi-data-sub', ['sub' => 'form-barang'])->with('message', 'Data Form Barang Berhasil Dibatalkan dan Dihapus!');
    }
}


 // Kurangi sisa ( penyesuaian dari gudang ) dengan sisa_recovery ( stok awal persediaan barang sebelum disesuaikan )
                // $getDifferent = $getPersediaanDetail[$i]->sisa - $getPersediaanDetail[$i]->recovery_sisa;

                // if ($getDifferent < 0) {
                //     $getRealDifferent = abs($getDifferent);

                //     $this->Barang->tambahKurangStokBarang($getPersediaanDetail[$i]->barang_id, $getRealDifferent);
                // } else {
                //     $getRealDifferent = $getDifferent;

                //     $this->Barang->tambahKurangStokBarang($getPersediaanDetail[$i]->barang_id, $getRealDifferent, '-');
                // }
