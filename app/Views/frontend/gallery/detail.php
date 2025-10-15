<?= $this->extend('frontend/layouts/main') ?>

<?= $this->section('content') ?>

<section class="page-header">
    <div class="auto-container">
        <div class="page-header__inner">
            <h1><?= esc($item['title']) ?></h1>
            <p><?= esc(ucwords($item['category'] ?: 'Umum')) ?> &bull; <?= date('d F Y', strtotime($item['event_date'] ?? $item['created_at'])) ?></p>
        </div>
    </div>
</section>

<section class="gallery-detail">
    <div class="auto-container">
        <div class="gallery-detail__content">
            <div class="gallery-detail__media">
                <?php if ($item['type'] === 'photo'): ?>
                    <img src="<?= base_url('uploads/gallery/' . $item['file_path']) ?>" alt="<?= esc($item['title']) ?>">
                <?php else: ?>
                    <?php if (!empty($item['video_url'])): ?>
                        <div class="gallery-detail__video">
                            <iframe src="<?= esc($item['video_url']) ?>" allowfullscreen loading="lazy"></iframe>
                        </div>
                    <?php else: ?>
                        <img src="<?= $item['thumbnail'] ? base_url('uploads/gallery/' . $item['thumbnail']) : base_url('assets/images/gallery/video-placeholder.jpg') ?>" alt="<?= esc($item['title']) ?>">
                    <?php endif ?>
                <?php endif ?>
            </div>

            <div class="gallery-detail__info">
                <?php if (!empty($item['description'])): ?>
                    <div class="gallery-detail__description">
                        <p><?= nl2br(esc($item['description'])) ?></p>
                    </div>
                <?php endif ?>

                <div class="gallery-detail__meta">
                    <div>
                        <span>Jenis</span>
                        <strong><?= $item['type'] === 'photo' ? 'Foto' : 'Video' ?></strong>
                    </div>
                    <?php if (!empty($item['category'])): ?>
                        <div>
                            <span>Kategori</span>
                            <strong><?= esc(ucwords($item['category'])) ?></strong>
                        </div>
                    <?php endif ?>
                    <div>
                        <span>Dipublikasikan</span>
                        <strong><?= date('d M Y H:i', strtotime($item['created_at'])) ?></strong>
                    </div>
                    <div>
                        <span>Jumlah Dilihat</span>
                        <strong><?= number_format($item['views'] ?? 0) ?> kali</strong>
                    </div>
                </div>

                <div class="gallery-detail__actions">
                    <a class="thm-btn thm-btn--outline" href="<?= base_url('gallery') ?>">
                        <span class="txt">Kembali ke Galeri</span>
                    </a>
                    <?php if ($item['type'] === 'video' && !empty($item['video_url'])): ?>
                        <a class="thm-btn" href="<?= esc($item['video_url']) ?>" target="_blank" rel="noopener">
                            <span class="txt">Tonton di Platform Asal</span>
                        </a>
                    <?php elseif ($item['type'] === 'photo' && !empty($item['file_path'])): ?>
                        <a class="thm-btn" href="<?= base_url('uploads/gallery/' . $item['file_path']) ?>" target="_blank" rel="noopener">
                            <span class="txt">Unduh Foto</span>
                        </a>
                    <?php endif ?>
                </div>
            </div>
        </div>

        <?php if (!empty($related)): ?>
            <div class="gallery-related">
                <div class="sec-title">
                    <div class="sec-title__tagline"><h6>Media Lainnya</h6></div>
                    <h2 class="sec-title__title">Dokumentasi terbaru</h2>
                </div>
                <div class="row clearfix gallery-grid">
                    <?php foreach ($related as $relatedItem): ?>
                        <div class="col-xl-4 col-lg-4 col-md-6 gallery-grid__item">
                            <div class="gallery-card gallery-card--<?= esc($relatedItem['type']) ?>">
                                <div class="gallery-card__image">
                                    <?php if ($relatedItem['type'] === 'photo'): ?>
                                        <a href="<?= base_url('gallery/' . $relatedItem['id']) ?>">
                                            <img src="<?= base_url('uploads/gallery/' . $relatedItem['file_path']) ?>" alt="<?= esc($relatedItem['title']) ?>">
                                        </a>
                                    <?php else: ?>
                                        <a href="<?= base_url('gallery/' . $relatedItem['id']) ?>" class="gallery-card__video">
                                            <div class="gallery-card__video-overlay">
                                                <span class="icon-play"></span>
                                            </div>
                                            <img src="<?= $relatedItem['thumbnail'] ? base_url('uploads/gallery/' . $relatedItem['thumbnail']) : base_url('assets/images/gallery/video-placeholder.jpg') ?>" alt="<?= esc($relatedItem['title']) ?>">
                                        </a>
                                    <?php endif ?>
                                </div>
                                <div class="gallery-card__content">
                                    <span class="gallery-card__category"><?= esc(ucwords($relatedItem['category'] ?: 'Umum')) ?></span>
                                    <h3><a href="<?= base_url('gallery/' . $relatedItem['id']) ?>"><?= esc($relatedItem['title']) ?></a></h3>
                                    <p><?= date('d F Y', strtotime($relatedItem['event_date'] ?? $relatedItem['created_at'])) ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        <?php endif ?>
    </div>
</section>

<?= $this->endSection() ?>
