<?= $this->extend('frontend/layouts/main') ?>

<?= $this->section('content') ?>

<section class="page-header">
    <div class="auto-container">
        <div class="page-header__inner">
            <h1>Pendaftaran Pelayanan Gereja</h1>
            <p>Silakan pilih jenis pendaftaran dan lengkapi formulir berikut.</p>
        </div>
    </div>
</section>

<section class="registration-page">
    <div class="auto-container">
        <?php if (!empty($successMessage)): ?>
            <div class="alert alert-success">
                <div class="alert__content">
                    <span class="icon-check"></span>
                    <p><?= esc($successMessage) ?></p>
                </div>
            </div>
        <?php endif ?>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <div class="alert__content">
                    <span class="icon-warning"></span>
                    <ul class="list-style-one">
                        <?php foreach ($errors as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach ?>
                    </ul>
                </div>
            </div>
        <?php endif ?>

        <div class="tabs-box registration-tabs">
            <ul class="tab-buttons clearfix">
                <li class="tab-btn <?= $activeType === 'baptis' ? 'active-btn' : '' ?>">
                    <a href="<?= base_url('registration?type=baptis') ?>">Baptis</a>
                </li>
                <li class="tab-btn <?= $activeType === 'sidi' ? 'active-btn' : '' ?>">
                    <a href="<?= base_url('registration?type=sidi') ?>">Sidi</a>
                </li>
                <li class="tab-btn <?= $activeType === 'nikah' ? 'active-btn' : '' ?>">
                    <a href="<?= base_url('registration?type=nikah') ?>">Pemberkatan Nikah</a>
                </li>
            </ul>
        </div>

        <div class="form-style-one registration-form">
            <form action="<?= base_url('registration/submit') ?>" method="post" enctype="multipart/form-data" class="default-form">
                <?= csrf_field() ?>
                <input type="hidden" name="type" value="<?= esc($activeType) ?>">

                <div class="row clearfix">
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label>Nama Lengkap <span class="required">*</span></label>
                            <input type="text" name="full_name" value="<?= old('full_name') ?>" required>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label>Tempat Lahir</label>
                            <input type="text" name="birth_place" value="<?= old('birth_place') ?>">
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-12">
                        <div class="form-group">
                            <label>Tanggal Lahir <span class="required">*</span></label>
                            <input type="date" name="birth_date" value="<?= old('birth_date') ?>" required>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <div class="form-group">
                            <label>Jenis Kelamin <span class="required">*</span></label>
                            <select name="gender" class="selectpicker" required>
                                <option value="">-- Pilih --</option>
                                <option value="L" <?= old('gender') === 'L' ? 'selected' : '' ?>>Laki-laki</option>
                                <option value="P" <?= old('gender') === 'P' ? 'selected' : '' ?>>Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <div class="form-group">
                            <label>No. Telepon <span class="required">*</span></label>
                            <input type="text" name="phone" value="<?= old('phone') ?>" required>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" value="<?= old('email') ?>">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label>Tanggal Diinginkan</label>
                            <input type="date" name="preferred_date" value="<?= old('preferred_date') ?>">
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12">
                        <div class="form-group">
                            <label>Alamat Lengkap <span class="required">*</span></label>
                            <textarea name="address" required><?= old('address') ?></textarea>
                        </div>
                    </div>

                    <?php if ($activeType === 'baptis'): ?>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label>Nama Orang Tua/Wali</label>
                                <input type="text" name="parent_name" value="<?= old('parent_name') ?>">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label>No. Telepon Orang Tua/Wali</label>
                                <input type="text" name="parent_phone" value="<?= old('parent_phone') ?>">
                            </div>
                        </div>
                    <?php endif ?>

                    <?php if ($activeType === 'sidi'): ?>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label>Tempat Baptis <span class="required">*</span></label>
                                <input type="text" name="baptism_place" value="<?= old('baptism_place') ?>" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label>Tanggal Baptis <span class="required">*</span></label>
                                <input type="date" name="baptism_date" value="<?= old('baptism_date') ?>" required>
                            </div>
                        </div>
                    <?php endif ?>

                    <?php if ($activeType === 'nikah'): ?>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label>Nama Pasangan <span class="required">*</span></label>
                                <input type="text" name="partner_name" value="<?= old('partner_name') ?>" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label>No. Telepon Pasangan <span class="required">*</span></label>
                                <input type="text" name="partner_phone" value="<?= old('partner_phone') ?>" required>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label>Tempat Lahir Pasangan</label>
                                <input type="text" name="partner_birth_place" value="<?= old('partner_birth_place') ?>">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label>Tanggal Lahir Pasangan</label>
                                <input type="date" name="partner_birth_date" value="<?= old('partner_birth_date') ?>">
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <label>Alamat Pasangan</label>
                                <textarea name="partner_address"><?= old('partner_address') ?></textarea>
                            </div>
                        </div>
                    <?php endif ?>

                    <div class="col-lg-12 col-md-12">
                        <div class="form-group">
                            <label>Catatan Tambahan</label>
                            <textarea name="notes" rows="3"><?= old('notes') ?></textarea>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12">
                        <div class="form-group file-upload">
                            <label>Unggah Dokumen Pendukung (opsional)</label>
                            <input type="file" name="document" accept=".pdf,.jpg,.jpeg,.png" class="form-control">
                            <small class="help-text">Format PDF/JPG/PNG maksimal 5MB.</small>
                        </div>
                    </div>
                </div>

                <div class="form-group text-center mt-4">
                    <button type="submit" class="thm-btn"><span class="txt">Kirim Pendaftaran</span></button>
                </div>
            </form>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
