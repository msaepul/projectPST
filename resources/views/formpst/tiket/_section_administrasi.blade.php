<div class="row gx-4">
    {{-- administrasi --}}
    <div class="col-md-6 mb-4">
        <div class="card p-4 h-100">
            <h6 class="mb-3">Administrasi Tiket</h6>
            <div class="mb-3">
                <label for="invoice" class="form-label">No invoice</label>
                <input type="text" id="invoice" name="invoice" class="form-control" required />
                <div class="invalid-feedback">Please enter the invoice number.</div>
            </div>
            <div class="mb-3">
                <label for="issued" class="form-label">Tanggal issued</label>
                <input type="date" id="issued" name="issued" class="form-control" required />
                <div class="invalid-feedback">Please enter the issue date.</div>
            </div>
            <div class="mb-3">
                <label for="nominal" class="form-label">Nominal Tiket</label>
                <input type="number" id="nominal" name="nominal" class="form-control" min="0" required />
                <div class="invalid-feedback">Please enter a valid nominal amount.</div>
            </div>
            <div class="mb-3">
                <label for="beban_biaya" class="form-label">Beban Biaya</label>
                <select id="beban_biaya" name="beban_biaya" class="form-select select2" required>
                    <option value="" disabled selected>-- Pilih Cabang --</option>
                    @foreach ($cabangs as $cabang)
                        <option value="{{ $cabang->nama_cabang }}">
                            {{ $cabang->nama_cabang }}
                        </option>
                    @endforeach
                </select>
                <div class="invalid-feedback">Please select cabang.</div>
            </div>
        </div>
    </div>

    <!-- Kolom Transportasi -->
    <div class="col-md-6 mb-4">
        <div class="card p-4 h-100">
            <h6 class="mb-3">Transportasi</h6>
            <div class="mb-3">
                <label for="agent" class="form-label">Agent</label>
                <select id="agent" name="agent" class="form-select select2" required>
                    <option value="" selected disabled>Pilih Agensi Perjalanan</option>
                    <option value="TxTravel">TxTravel</option>
                    <option value="Traveloka">Traveloka</option>
                </select>
                <div class="invalid-feedback">Please select an agent.</div>
            </div>
            <div class="mb-3">
                <label class="kendaraan">Kendaraan</label><br />
                <div class="form-check form-check-inline">
                    <input class="form-check-input kendaraan-checkbox" type="checkbox" id="bus" name="kendaraan[]"
                        value="Bus" />
                    <label class="form-check-label" for="bus">Bus</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input kendaraan-checkbox" type="checkbox" id="kereta" name="kendaraan[]"
                        value="kereta" />
                    <label class="form-check-label" for="kereta">Kereta</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input kendaraan-checkbox" type="checkbox" id="pesawat" name="kendaraan[]"
                        value="pesawat" />
                    <label class="form-check-label" for="pesawat">Pesawat</label>
                </div>
                <div class="invalid-feedback d-block" id="kendaraanFeedback" style="display:none;">
                    Pilih salah satu.
                </div>
            </div>

            {{-- bus --}}
            {{-- bus --}}
            <div class="mb-3" id="dropdown-bus" style="display: none;">
                <label for="bus_input" class="form-label">Nama Bus</label>
                <input type="text" id="bus_input" name="bus" class="form-control"
                    placeholder="Masukkan nama bus">
                <div class="invalid-feedback">Masukkan nama bus.</div>
            </div>

            {{-- pesawat --}}
            <div class="mb-3" id="dropdown-pesawat" style="display: none;">
                <label for="maskapai" class="form-label">Maskapai</label>
                <select id="maskapai" name="maskapai" class="form-select select2">
                    <option value="" disabled selected>-- Pilih Maskapai --</option>
                    @foreach ($maskapais as $maskapai)
                        <option value="{{ $maskapai->nama_maskapai }}">
                            {{ $maskapai->nama_maskapai }}
                        </option>
                    @endforeach
                </select>
                <div class="invalid-feedback">Please select maskapai.</div>
            </div>

            {{-- kereta --}}
            <div class="mb-3" id="dropdown-kereta" style="display: none;">
                <label for="kereta_input" class="form-label">Nama Kereta</label>
                <input type="text" id="kereta_input" name="kereta" class="form-control"
                    placeholder="Masukkan nama kereta">
                <div class="invalid-feedback">Masukkan nama kereta.</div>
            </div>

            <div>
                <label for="class" class="form-label">Class</label>
                <select id="class" name="class" class="form-select select2" required>
                    <option value="" selected hidden>Pilih Class</option>
                    <option value="Economy">Economy</option>
                    <option value="Business">Business</option>
                </select>
                <div class="invalid-feedback">Please select class.</div>
            </div>
        </div>
    </div>
</div>
