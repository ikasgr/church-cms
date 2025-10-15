<?= $this->extend('frontend/layouts/main') ?>

<?= $this->section('content') ?>

<section class="page-header">
    <div class="auto-container">
        <div class="page-header__inner">
            <h1>Masukan &amp; Saran Jemaat</h1>
            <p>Sampaikan aspirasi Anda untuk mendukung pelayanan gereja yang lebih baik.</p>
        </div>
    </div>
</section>

<section class="feedback-page">
    <div class="auto-container">
        <div class="row clearfix">
            <div class="col-lg-7">
                <div class="feedback-form form-style-one">
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

                    <form action="<?= base_url('feedback/submit') ?>" method="post" class="default-form">
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
                                    <label>Kategori <span class="required">*</span></label>
                                    <select name="type" required>
                                        <option value="">-- Pilih --</option>
                                        <?php foreach ($types as $value => $label): ?>
                                            <option value="<?= $value ?>" <?= old('type') === $value ? 'selected' : '' ?>><?= esc($label) ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Judul Pesan <span class="required">*</span></label>
                                    <input type="text" name="subject" value="<?= old('subject') ?>" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Isi Pesan <span class="required">*</span></label>
                                    <textarea name="message" rows="5" required><?= old('message') ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="thm-btn"><span class="txt">Kirim Masukan</span></button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="feedback-sidebar">
                    <div class="feedback-info">
                        <h3>Mengapa Masukan Anda Penting?</h3>
                        <p>Setiap saran dan kritik Anda membantu kami meningkatkan pelayanan yang lebih relevan dan berdampak bagi jemaat.</p>
                    </div>

                    <?php if (!empty($recentFeedback)): ?>
                        <div class="feedback-recent">
                            <h3>Masukan Terbaru</h3>
                            <ul class="feedback-recent__list">
                                <?php foreach ($recentFeedback as $item): ?>
                                    <li class="feedback-recent__item">
                                        <h4><?= esc($item['subject']) ?></h4>
                                        <p><?= esc(word_limiter(strip_tags($item['message']), 20)) ?></p>
                                        <span class="feedback-recent__meta">Ditanggapi <?= date('d M Y', strtotime($item['responded_at'])) ?></span>
                                    </li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    <?php endif ?>

                    <div class="feedback-contact">
                        <h3>Bantuan Layanan</h3>
                        <p>Hubungi kantor gereja untuk bantuan lebih lanjut atau tindak lanjut masukan Anda.</p>
                        <ul class="list-style-one">
                            <li>Email: <a href="mailto:<?= esc(app_setting('site_email', 'info@example.com')) ?>"><?= esc(app_setting('site_email', 'info@example.com')) ?></a></li>
                            <li>Telepon: <a href="tel:<?= preg_replace('/\D+/', '', app_setting('site_phone', '0000-0000')) ?>"><?= esc(app_setting('site_phone', '0000-0000')) ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
