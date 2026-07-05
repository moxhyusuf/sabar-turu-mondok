@extends('layout.app')

@section('title', 'Tambah Transaksi Manual')
@section('page-title', 'Tambah Transaksi (Walk-in)')

@section('content')
<div class="row">
    <div class="col-12">
        <form action="{{ route('pemilik_dekost.transaksi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                {{-- KOLOM KIRI: DATA PENYEWA --}}
                <div class="col-lg-6">
                    <div class="card shadow-sm border-0 mb-4" style="border-radius: 0.75rem;">
                        <div class="card-header bg-white py-3" style="border-top-left-radius: 0.75rem; border-top-right-radius: 0.75rem;">
                            <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-user-plus mr-2"></i> Data Penyewa</h5>
                        </div>
                        <div class="card-body">
                            {{-- Pilih Penyewa yang Sudah Ada --}}
                            <div class="mb-4">
                                <label class="form-label fw-bold text-muted small">PILIH PENYEWA (OPSIONAL)</label>
                                <select name="penyewa_id" id="penyewa_id" class="form-control select2 shadow-none border-light-subtle bg-light">
                                    <option value="">-- Tambah Penyewa Baru --</option>
                                    @foreach($penyewas as $p)
                                        @php
                                            $tenantKostIds = $p->bookings->pluck('kost_id')->unique()->values()->toJson();
                                        @endphp
                                        <option value="{{ $p->id }}" data-nama="{{ $p->nama }}" data-hp="{{ $p->no_hp }}" data-email="{{ $p->email }}" data-alamat="{{ $p->alamat }}" data-kost-ids="{{ $tenantKostIds }}">
                                            {{ $p->nama }} ({{ $p->no_hp }})
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted mt-1 d-block">Pilih jika penyewa sudah pernah terdaftar, atau kosongkan untuk tambah baru.</small>
                            </div>

                            <hr class="my-4 opacity-50">

                            {{-- Form Tambah Penyewa Baru --}}
                            <div id="new_penyewa_fields">
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-muted small">NAMA PENYEWA <span class="text-danger">*</span></label>
                                    <input type="text" name="nama" id="nama" class="form-control shadow-none" placeholder="Nama Lengkap">
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold text-muted small">NO. HP / WHATSAPP <span class="text-danger">*</span></label>
                                        <input type="text" name="no_hp" id="no_hp" class="form-control shadow-none" placeholder="08xxxx">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold text-muted small">EMAIL (OPSIONAL)</label>
                                        <input type="email" name="email" id="email" class="form-control shadow-none" placeholder="email@example.com">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-muted small">ALAMAT ASAL <span class="text-danger">*</span></label>
                                    <textarea name="alamat" id="alamat" class="form-control shadow-none" rows="3" placeholder="Alamat lengkap asal penyewa"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-muted small">UPLOAD FOTO KTP (OPSIONAL)</label>
                                    <div class="custom-file">
                                        <input type="file" name="ktp" class="form-control shadow-none" id="ktp">
                                    </div>
                                    <small class="text-muted mt-1 d-block">Format: JPG, PNG. Maksimal 2MB.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN: DATA KAMAR & PEMBAYARAN --}}
                <div class="col-lg-6">
                    <div class="card shadow-sm border-0 mb-4" style="border-radius: 0.75rem;">
                        <div class="card-header bg-white py-3" style="border-top-left-radius: 0.75rem; border-top-right-radius: 0.75rem;">
                            <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-bed mr-2"></i> Data Kamar & Pembayaran</h5>
                        </div>
                        <div class="card-body">
                            {{-- Pilih Kos --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted small">PILIH KAMAR / KOS <span class="text-danger">*</span></label>
                                <select name="kost_id" id="kost_id" class="form-control shadow-none border-light-subtle" required>
                                    <option value="" disabled selected>-- Pilih Kos --</option>
                                    @foreach($kosts as $k)
                                        <option value="{{ $k->id }}" data-harga="{{ $k->harga }}" {{ $k->kamar_tersedia <= 0 ? 'disabled' : '' }}>
                                            {{ $k->nama_kost }} (Sisa: {{ $k->kamar_tersedia }}) - Rp {{ number_format($k->harga, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Harga Otomatis (Readonly) --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted small">HARGA KOS (AUTO)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-light-subtle">Rp</span>
                                    <input type="text" id="display_harga" class="form-control bg-light" readonly placeholder="0">
                                    <input type="hidden" name="nominal" id="nominal">
                                </div>
                            </div>

                            {{-- Tanggal --}}
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold text-muted small">TANGGAL MASUK <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_masuk" class="form-control shadow-none" required value="{{ date('Y-m-d') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold text-muted small">TANGGAL KELUAR <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_keluar" class="form-control shadow-none" required>
                                </div>
                            </div>

                            <hr class="my-4 opacity-50">

                            {{-- Pembayaran --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted small">METODE PEMBAYARAN <span class="text-danger">*</span></label>
                                <select name="metode_pembayaran" id="metode_pembayaran" class="form-control shadow-none border-light-subtle" required>
                                    <option value="cash">Cash (Tunai)</option>
                                    <option value="transfer">Transfer</option>
                                </select>
                            </div>

                            <div id="transfer_proof_field" style="display: none;">
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-muted small">UPLOAD BUKTI TRANSFER <span class="text-danger">*</span></label>
                                    <input type="file" name="bukti_pembayaran" class="form-control shadow-none" id="bukti_pembayaran">
                                    <small class="text-muted mt-1 d-block">Wajib diupload jika metode pembayaran Transfer.</small>
                                </div>
                            </div>

                            <div id="cash_payment_fields">
                                <hr class="my-4 opacity-50">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold text-muted small">NOMINAL BAYAR <span class="text-danger">*</span></label>
                                        <div class="input-group shadow-sm" style="border-radius: 0.5rem; overflow: hidden;">
                                            <span class="input-group-text bg-primary text-white border-0">Rp</span>
                                            <input type="text" name="nominal_bayar" id="nominal_bayar" class="form-control border-0 bg-white" placeholder="0" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold text-muted small">KEMBALIAN (AUTO)</label>
                                        <div class="input-group shadow-sm" style="border-radius: 0.5rem; overflow: hidden;">
                                            <span class="input-group-text bg-light border-light-subtle text-muted border-0">Rp</span>
                                            <input type="text" id="display_kembalian" class="form-control border-0 bg-light font-weight-bold text-dark" readonly placeholder="0">
                                            <input type="hidden" name="kembalian" id="kembalian">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-info border-0 shadow-none small mt-4">
                                <i class="fas fa-info-circle mr-1"></i>
                                Transaksi ini akan ditandai sebagai <strong>Lunas</strong> dan status sewa langsung <strong>Aktif</strong>. Kamar yang dipilih akan otomatis berkurang.
                            </div>
                        </div>
                        <div class="card-footer bg-white border-top py-3 text-right" style="border-bottom-left-radius: 0.75rem; border-bottom-right-radius: 0.75rem;">
                            <a href="{{ route('pemilik_dekost.transaksi.index') }}" class="btn btn-light px-4 mr-2">Batal</a>
                            <button type="submit" id="btn-submit" class="btn btn-primary px-4 fw-bold shadow-sm">
                                <i class="fas fa-save mr-1"></i> Simpan Transaksi
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
$(function() {
    // Store all original penyewa options
    let allPenyewas = [];
    $('#penyewa_id option').each(function() {
        let val = $(this).val();
        if (val) {
            allPenyewas.push({
                id: val,
                text: $(this).text(),
                nama: $(this).data('nama') || '',
                hp: $(this).data('hp') || '',
                email: $(this).data('email') || '',
                alamat: $(this).data('alamat') || '',
                kostIds: $(this).data('kost-ids')
            });
        }
    });

    // Function to filter penyewas by kost ID
    function filterPenyewas(kostId) {
        let penyewaSelect = $('#penyewa_id');
        penyewaSelect.find('option:not([value=""])').remove();

        if (kostId) {
            allPenyewas.forEach(function(p) {
                if (p.kostIds && p.kostIds.includes(parseInt(kostId))) {
                    let option = $('<option></option>')
                        .val(p.id)
                        .text(p.text)
                        .attr('data-nama', p.nama)
                        .attr('data-hp', p.hp)
                        .attr('data-email', p.email)
                        .attr('data-alamat', p.alamat)
                        .attr('data-kost-ids', JSON.stringify(p.kostIds));
                    penyewaSelect.append(option);
                }
            });
        }
        
        penyewaSelect.val('').trigger('change');
    }

    // Sync Harga saat pilih Kos
    $('#kost_id').on('change', function() {
        let harga = $(this).find(':selected').data('harga') || 0;
        $('#display_harga').val(new Intl.NumberFormat('id-ID').format(harga));
        $('#nominal').val(harga);
        
        // Filter penyewa dropdown by selected kost_id
        filterPenyewas($(this).val());
    });

    // Run filter initially on load
    filterPenyewas($('#kost_id').val());


    // Toggle Form Penyewa Baru vs Existing
    $('#penyewa_id').on('change', function() {
        let selected = $(this).find(':selected');
        let id = selected.val();
        
        if (id) {
            // Fill but make readonly or just hide
            $('#nama').val(selected.data('nama')).attr('readonly', true);
            $('#no_hp').val(selected.data('hp')).attr('readonly', true);
            $('#email').val(selected.data('email')).attr('readonly', true);
            $('#alamat').val(selected.data('alamat')).attr('readonly', true);
            $('#ktp').attr('disabled', true);
        } else {
            // Reset and allow input
            $('#nama').val('').attr('readonly', false);
            $('#no_hp').val('').attr('readonly', false);
            $('#email').val('').attr('readonly', false);
            $('#alamat').val('').attr('readonly', false);
            $('#ktp').attr('disabled', false);
        }
    });

    // Toggle Proof Upload for Transfer & Cash Fields
    $('#metode_pembayaran').on('change', function() {
        if ($(this).val() === 'transfer') {
            $('#transfer_proof_field').slideDown();
            $('#bukti_pembayaran').attr('required', true);
            $('#cash_payment_fields').slideUp();
            $('#nominal_bayar').attr('required', false);
        } else {
            $('#transfer_proof_field').slideUp();
            $('#bukti_pembayaran').attr('required', false);
            $('#cash_payment_fields').slideDown();
            $('#nominal_bayar').attr('required', true);
        }
    }).trigger('change');

    // Real-time Calculation for Cash Payment
    $('#nominal_bayar').on('keyup', function() {
        let val = $(this).val().replace(/[^0-9]/g, '');
        $(this).val(new Intl.NumberFormat('id-ID').format(val));

        let bayar = parseInt(val) || 0;
        let harga = parseInt($('#nominal').val()) || 0;
        let diff = bayar - harga;

        if (bayar > 0 && diff >= 0) {
            $('#display_kembalian').val(new Intl.NumberFormat('id-ID').format(diff));
            $('#kembalian').val(diff);
            $('#nominal_bayar').removeClass('is-invalid').addClass('is-valid');
        } else if (bayar > 0 && diff < 0) {
            $('#display_kembalian').val(0);
            $('#kembalian').val(0);
            $('#nominal_bayar').addClass('is-invalid');
        } else {
            $('#display_kembalian').val(0);
            $('#kembalian').val(0);
            $('#nominal_bayar').removeClass('is-invalid is-valid');
        }
    });

    // Form Submission Validation
    $('form').on('submit', function(e) {
        let metode = $('#metode_pembayaran').val();
        if (metode === 'cash') {
            let bayar = parseInt($('#nominal_bayar').val().replace(/[^0-9]/g, '')) || 0;
            let harga = parseInt($('#nominal').val()) || 0;

            if (bayar < harga) {
                e.preventDefault();
                alert('Nominal bayar tidak boleh kurang dari harga kost!');
                $('#nominal_bayar').focus();
                return false;
            }
        }
    });
});
</script>
@endpush
@endsection
