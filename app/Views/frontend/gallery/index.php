<?= $this->extend('frontend/layouts/main') ?>

<?= $this->section('content') ?>

<section class="page-header">
    <div class="auto-container">
        <div class="page-header__inner">
            <h1>Galeri Kegiatan Gereja</h1>
            <p>Dokumentasi foto dan video pelayanan serta kegiatan jemaat.</p>
        </div>
    </div>
</section>

<section class="gallery-page">
    <div class="auto-container">
        <div class="gallery-filter">
            <form action="<?= base_url('gallery') ?>" method="get" class="gallery-filter__form">
                <div class="row clearfix">
                    <div class="col-lg-3 col-md-6">
                        <label>Jenis Media</label>
                        <select name="type" class="thm-select">
                            <option value="">Semua</option>
                            <option value="photo" <?= $filters['type'] === 'photo' ? 'selected' : '' ?>>Foto</option>
                            <option value="video" <?= $filters['type'] === 'video' ? 'selected' : '' ?>>Video</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <label>Kategori</label>
                        <select name="category" class="thm-select">
                            <option value="">Semua Kategori</option>
                            <?php foreach ($categories as $category): ?>
                                <?php $categoryName = $category['category'] ?: 'Umum'; ?>
                                <option value="<?= esc($category['category']) ?>" <?= $filters['category'] === $category['category'] ? 'selected' : '' ?>>
                                    <?= esc(ucwords($categoryName)) ?> (<?= $category['total'] ?>)
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-6 align-self-end">
                        <button type="submit" class="thm-btn"><span class="txt">Terapkan</span></button>
                    </div>
                </div>
            </form>
        </div>

        <?php if (empty($items)): ?>
            <div class="gallery-empty">
                <p>Belum ada media yang dipublikasikan untuk filter ini.</p>
            </div>
        <?php else: ?>
            <div class="row clearfix gallery-grid">
                <?php foreach ($items as $item): ?>
                    <div class="col-xl-4 col-lg-4 col-md-6 gallery-grid__item">
                        <div class="gallery-card gallery-card--<?= esc($item['type']) ?>">
                            <div class="gallery-card__image">
                                <?php if ($item['type'] === 'photo'): ?>
                                    <a href="<?= base_url('gallery/' . $item['id']) ?>">
                                        <img src="<?= base_url('uploads/gallery/' . $item['file_path']) ?>" alt="<?= esc($item['title']) ?>">
                                    </a>
                                <?php else: ?>
                                    <a href="<?= base_url('gallery/' . $item['id']) ?>" class="gallery-card__video">
                                        <div class="gallery-card__video-overlay">
                                            <span class="icon-play"></span>
                                        </div>
                                        <img src="<?= $item['thumbnail'] ? base_url('uploads/gallery/' . $item['thumbnail']) : base_url('assets/images/gallery/video-placeholder.jpg') ?>" alt="<?= esc($item['title']) ?>">
                                    </a>
                                <?php endif ?>
                            </div>
                            <div class="gallery-card__content">
                                <span class="gallery-card__category"><?= esc(ucwords($item['category'] ?: 'Umum')) ?></span>
                                <h3><a href="<?= base_url('gallery/' . $item['id']) ?>"><?= esc($item['title']) ?></a></h3>
                                <p><?= date('d F Y', strtotime($item['event_date'] ?? $item['created_at'])) ?></p>
                                <div class="gallery-card__meta">
                                    <span><i class="icon-eye"></i> <?= number_format($item['views'] ?? 0) ?> kali dilihat</span>
                                    <?php if ($item['type'] === 'video' && !empty($item['video_url'])): ?>
                                        <a class="gallery-card__meta-link" href="<?= esc($item['video_url']) ?>" target="_blank" rel="noopener">Tonton Video</a>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        <?php endif ?>
    </div>
</section>

<?= $this->endSection() ?>
