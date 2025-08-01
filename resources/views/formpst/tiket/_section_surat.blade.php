<div class="row mb-3">
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="no_surat" class="form-label">No. Surat</label>
            <div class="input-group">
                <select class="form-control select2" name="form_id" id="no_surat">
                    <option value="" disabled {{ empty($prefill) ? 'selected' : '' }}>-- Pilih No. Surat --</option>
                    @foreach ($forms as $form)
                        <option value="{{ $form->id }}" data-no_surat="{{ $form->no_surat }}">
                            {{ $form->no_surat }}
                        </option>
                    @endforeach
                    <option value="lainnya">lainnya</option>
                </select>
            </div>
        </div>
        
        {{-- Untuk menyimpan no_surat aslinya (jika diperlukan) --}}
        <input type="hidden" name="no_surat" id="hidden_no_surat" value="">
        

        {{-- <div class="form-group mb-3" id="manualNoSuratContainer" style="display: none;">
            <label for="manual_no_surat" class="form-label">Masukkan No. Surat</label>
            <input type="text" id="manual_no_surat" name="manual_no_surat" class="form-control"
                placeholder="Contoh: B-123/UNIV/2025">
        </div> --}}


        <div class="form-group mb-3">
            <label for="nama_pemohon" class="form-label">Nama Pemohon</label>
            <input type="text" id="nama_pemohon" name="nama_pemohon" class="form-control"
                value="{{ old('nama_pemohon', $prefill->nama_pemohon ?? '') }}" readonly>
        </div>

        <div class="form-group mb-3">
            <label for="yang_menugaskan" class="form-label">Ditugaskan Oleh</label>
            <input type="text" id="yang_menugaskan" name="assigned_By" class="form-control"
                value="{{ old('yang_menugaskan', $prefill->yang_menugaskan ?? '') }}" readonly>
        </div>

    </div>
    <div class="col-md-6">
        <label for="pegawai" class="form-label">List Pegawai</label>

        <div class="card mb-3">
            <div class="card-pegawai">
                <ul class="list-group" id="listPegawai">
                    <li class="list-group-item">Pilih No. Surat untuk melihat pegawai.</li>
                </ul>
            </div>
        </div>
        <div id="pegawaiContainer">
            <!-- Pegawai terpilih akan ditambahkan di sini -->
            <div id="manualPegawaiSection" style="display: none;">
                <div id="pegawaiInputs">
                    <div class="input-group mb-2">
                        <input type="text" name="pegawai_nama[]" class="form-control" placeholder="Nama Pegawai">
                        <input type="text" name="pegawai_departemen[]" class="form-control" placeholder="Departemen">
                    </div>
                </div>
                <button type="button" id="tambahPegawaiBtn" class="btn btn-sm btn-primary mt-2">+
                    Tambah Pegawai</button>
            </div>
        </div>

    </div>
</div>
