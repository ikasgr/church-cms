<?= $this->extend('frontend/layouts/main') ?>

<?= $this->section('content') ?>

<section class="page-header">
    <div class="auto-container">
        <div class="page-header__inner">
            <h1>Survei &amp; Jajak Pendapat Jemaat</h1>
            <p>Ikuti survei yang kami sediakan untuk membantu peningkatan pelayanan gereja.</p>
        </div>
    </div>
</section>

<section class="survey-list">
    <div class="auto-container">
        <?php if (empty($surveys)): ?>
            <div class="alert alert-info">
                <div class="alert__content">
                    <span class="icon-info"></span>
                    <p>Belum ada survei yang tersedia saat ini.</p>
                </div>
            </div>
        <?php else: ?>
            <div class="row clearfix">
                <?php foreach ($surveys as $survey): ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="survey-card">
                            <div class="survey-card__status <?= $survey['is_open'] ? 'is-open' : 'is-closed' ?>">
                                <?= $survey['is_open'] ? 'Sedang Berlangsung' : 'Ditutup' ?>
                            </div>
                            <h3 class="survey-card__title">
                                <a href="<?= base_url('survey/' . $survey['id']) ?>"><?= esc($survey['title']) ?></a>
                            </h3>
                            <?php if (!empty($survey['description'])): ?>
                                <p class="survey-card__excerpt"><?= esc(word_limiter(strip_tags($survey['description']), 20)) ?></p>
                            <?php endif ?>
                            <ul class="survey-card__meta list-style-one">
                                <li><strong>Periode</strong> <?= date('d M Y', strtotime($survey['start_date'])) ?> &ndash; <?= date('d M Y', strtotime($survey['end_date'])) ?></li>
                                <li><strong>Total Responden</strong> <?= number_format($survey['response_count']) ?></li>
                                <li><strong>Tipe</strong> <?= $survey['type'] === 'poll' ? 'Jajak Pendapat' : 'Kuesioner' ?></li>
                            </ul>
                            <div class="survey-card__actions">
                                <a class="thm-btn <?= $survey['is_open'] ? '' : 'thm-btn--outline' ?>" href="<?= base_url('survey/' . $survey['id']) ?>">
                                    <span class="txt"><?= $survey['is_open'] ? 'Isi Survei' : 'Lihat Detail' ?></span>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        <?php endif ?>
    </div>
</section>

<?= $this->endSection() ?>
