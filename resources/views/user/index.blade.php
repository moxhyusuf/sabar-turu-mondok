<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fermata De'Kost - Form Input Data</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="header-content">
                <div class="logo">📋</div>
                <div class="header-text">
                    <h1>FERMATA DE'KOST</h1>
                    <p>Silakan lengkapi data diri Anda dengan benar</p>
                </div>
            </div>
            <div class="logo-container">
                <div class="logo-circle">
                    <img src="/assets/img/sabar.jpg" alt="Logo 1">
                </div>

                <div class="logo-circle">
                    <img src="/assets/img/kota.png" alt="Logo 3">
                </div>
            </div>
        </div>

        <div class="form-container">
            <form id="dataForm">
                <div class="form-grid">
                    <!-- Section Identitas -->
                    <div class="form-section">
                        <h3 class="section-title">Identitas</h3>

                        <div class="form-group">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-input" name="nama" required placeholder="Masukkan nama lengkap">
                        </div>

                        <div class="form-group">
                            <label class="form-label">NIK</label>
                            <input type="text" class="form-input" name="nik" required placeholder="Masukkan NIK" maxlength="16">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Alamat</label>
                            <textarea class="form-input" name="alamat" required placeholder="Masukkan alamat lengkap"></textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Kontak Person</label>
                            <input type="tel" class="form-input" name="kontak" required placeholder="Masukkan nomor telepon/WA">
                        </div>

                        <!-- Section Administrasi -->
                        <h3 class="section-title" style="margin-top: 40px;">Administrasi</h3>

                        <div class="form-group">
                            <label class="form-label">Pilihan Administrasi</label>
                            <select class="form-select" name="administrasi" required>
                                <option value="">Pilih jenis administrasi</option>
                                <option value="skiu_kelurahan">SKIU Kelurahan</option>
                                <option value="pbb">PBB</option>
                                <option value="imb">IMB</option>
                                <option value="nib">NIB</option>
                            </select>
                        </div>
                    </div>

                    <!-- Section Keterangan -->
                    <div class="form-section">
                        <h3 class="section-title">Keterangan</h3>

                        <div class="form-group">
                            <label class="form-label">Nama Pemondokan</label>
                            <input type="text" class="form-input" name="nama_pemondokan" required placeholder="Masukkan nama pemondokan">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Jenis Rumah</label>
                            <select class="form-select" name="jenis_rumah" required>
                                <option value="">Pilih jenis rumah</option>
                                <option value="putra">Putra</option>
                                <option value="perempuan">Perempuan</option>
                                <option value="campuran">Campuran</option>
                                <option value="keluarga">Keluarga</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Jumlah Kamar</label>
                            <select class="form-select" name="jumlah_kamar" required>
                                <option value="">Pilih jumlah kamar</option>
                                <option value="1-5">1-5 kamar</option>
                                <option value="6-10">6-10 kamar</option>
                                <option value=">10">>10 kamar</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Lokasi Rumah</label>
                            <select class="form-select" name="lokasi_rumah" required>
                                <option value="">Pilih lokasi rumah</option>
                                <option value="satu_atap">Satu Atap</option>
                                <option value="pisah">Pisah</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Fasilitas</label>
                            <div class="checkbox-group">
                                <div class="checkbox-item">
                                    <input type="checkbox" id="lahan_parkir" name="fasilitas[]" value="lahan_parkir">
                                    <label for="lahan_parkir">Lahan Parkir</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="pagar" name="fasilitas[]" value="pagar">
                                    <label for="pagar">Pagar</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="cctv" name="fasilitas[]" value="cctv">
                                    <label for="cctv">CCTV</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="ac_kipas" name="fasilitas[]" value="ac_kipas">
                                    <label for="ac_kipas">AC/Kipas</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="meteran_listrik" name="fasilitas[]" value="meteran_listrik">
                                    <label for="meteran_listrik">Meteran Listrik</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="wifi" name="fasilitas[]" value="wifi">
                                    <label for="wifi">WiFi</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="peraturan_penghuni" name="fasilitas[]" value="peraturan_penghuni">
                                    <label for="peraturan_penghuni">Peraturan Penghuni</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="penjaga" name="fasilitas[]" value="penjaga">
                                    <label for="penjaga">Penjaga</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="lainnya" name="fasilitas[]" value="lainnya" onchange="toggleOtherInput()">
                                    <label for="lainnya">Lainnya</label>
                                </div>
                            </div>

                            <!-- Input untuk fasilitas lainnya -->
                            <div class="form-group" id="otherFacilityGroup" style="display: none; margin-top: 20px;">
                                <label class="form-label">Sebutkan fasilitas lainnya (pisahkan dengan koma)</label>
                                <textarea class="form-input" id="otherFacilities" name="fasilitas_lainnya" placeholder="Contoh: Dapur umum, Jemuran, Taman" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="submit-btn">Submit Data</button>
            </form>
        </div>
    </div>

    <script>
        // Toggle input untuk fasilitas lainnya
        function toggleOtherInput() {
            const checkbox = document.getElementById('lainnya');
            const otherGroup = document.getElementById('otherFacilityGroup');
            const otherInput = document.getElementById('otherFacilities');

            if (checkbox.checked) {
                otherGroup.style.display = 'block';
                setTimeout(() => otherInput.focus(), 100);
            } else {
                otherGroup.style.display = 'none';
                otherInput.value = '';
            }
        }

        document.getElementById('dataForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Collect form data
            const formData = new FormData(this);
            const data = {};

            // Get all form fields
            for (let [key, value] of formData.entries()) {
                if (key === 'fasilitas[]') {
                    if (!data.fasilitas) data.fasilitas = [];
                    data.fasilitas.push(value);
                } else {
                    data[key] = value;
                }
            }

            // Handle fasilitas lainnya
            const otherFacilities = document.getElementById('otherFacilities').value;
            if (otherFacilities.trim() && document.getElementById('lainnya').checked) {
                const additionalFacilities = otherFacilities.split(',').map(f => f.trim()).filter(f => f);
                if (!data.fasilitas) data.fasilitas = [];
                data.fasilitas = data.fasilitas.concat(additionalFacilities);
            }

            // Display collected data
            console.log('Data yang dikumpulkan:', data);

            // Show success message
            const btn = this.querySelector('.submit-btn');
            const originalText = btn.textContent;
            btn.textContent = '✓ Data Berhasil Dikumpulkan!';
            btn.style.background = 'linear-gradient(135deg, #10b981 0%, #059669 100%)';

            setTimeout(() => {
                btn.textContent = originalText;
                btn.style.background = 'linear-gradient(135deg, #3b82f6 0%, #2563eb 100%)';
            }, 3000);
        });

        // Add smooth focus animations
        document.querySelectorAll('.form-input, .form-select').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.01)';
                this.parentElement.style.transition = 'transform 0.2s ease';
            });

            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });

        // Add checkbox animation
        document.querySelectorAll('.checkbox-item input').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    this.parentElement.style.borderColor = '#3b82f6';
                    this.parentElement.style.background = '#eff6ff';
                } else {
                    this.parentElement.style.borderColor = '#e2e8f0';
                    this.parentElement.style.background = 'white';
                }
            });
        });
    </script>
</body>

</html>