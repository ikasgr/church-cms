<?= $this->extend('frontend/layouts/main') ?>

<?= $this->section('content') ?>

<section class="page-header">
    <div class="auto-container">
        <div class="page-header__inner">
            <h1>Buku Tamu Jemaat</h1>
            <p>Silakan tinggalkan salam dan kesan Anda saat berkunjung ke gereja kami.</p>
        </div>
    </div>
</section>

<section class="guestbook-page">
    <div class="auto-container">
        <div class="row clearfix">
            <div class="col-lg-7">
                <div class="guestbook-form form-style-one">
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

                    <form action="<?= base_url('guestbook/submit') ?>" method="post" class="default-form">
                        <?= csrf_field() ?>
                        <div class="row clearfix">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Lengkap <span class="required">*</span></label>
                                    <input type="text" name="name" value="<?= old('name') ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" value="<?= old('email') ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>No. Telepon</label>
                                    <input type="text" name="phone" value="<?= old('phone') ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <input type="text" name="address" value="<?= old('address') ?>">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Pesan <span class="required">*</span></label>
                                    <textarea name="message" rows="5" required><?= old('message') ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="thm-btn"><span class="txt">Kirim Pesan</span></button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="guestbook-sidebar">
                    <div class="guestbook-info">
                        <h3>Mengapa Mengisi Buku Tamu?</h3>
                        <p>Salam dan kesan Anda akan menjadi penyemangat kami serta dokumentasi penting perjalanan pelayanan gereja.</p>
                    </div>

                    <?php if (!empty($entries)): ?>
                        <div class="guestbook-entries">
                            <h3>Salam Jemaat</h3>
                            <div class="guestbook-entries__list">
                                <?php foreach ($entries as $entry): ?>
                                    <div class="guestbook-entry">
                                        <div class="guestbook-entry__header">
                                            <h4><?= esc($entry['name']) ?></h4>
                                            <span class="guestbook-entry__date"><?= date('d M Y', strtotime($entry['created_at'])) ?></span>
                                        </div>
                                        <p><?= esc($entry['message']) ?></p>
                                        <?php if (!empty($entry['address'])): ?>
                                            <span class="guestbook-entry__meta">Alamat: <?= esc($entry['address']) ?></span>
                                        <?php endif ?>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="guestbook-empty">
                            <p>Belum ada pesan yang ditampilkan. Jadilah yang pertama meninggalkan salam Anda.</p>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
