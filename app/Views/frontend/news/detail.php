<?= $this->extend('frontend/layouts/main') ?>

<?= $this->section('content') ?>

<section class="page-header">
    <div class="auto-container">
        <div class="page-header__inner">
            <h1><?= esc($newsItem['title']) ?></h1>
            <p><?= date('d M Y', strtotime($newsItem['published_at'])) ?> · <?= esc($categories[$newsItem['category']] ?? ucfirst($newsItem['category'])) ?></p>
        </div>
    </div>
</section>

<section class="blog-details">
    <div class="auto-container">
        <div class="row clearfix">
            <div class="col-xl-8 col-lg-8 col-md-12">
                <div class="blog-details__content wow fadeInUp" data-wow-delay="0ms" data-wow-duration="1500ms">
                    <?php if (!empty($newsItem['featured_image'])): ?>
                        <div class="blog-details__image">
                            <img src="<?= base_url('uploads/news/' . $newsItem['featured_image']) ?>" alt="<?= esc($newsItem['title']) ?>">
                        </div>
                    <?php endif ?>

                    <div class="blog-details__meta">
                        <span><i class="icon-calendar"></i><?= date('d M Y', strtotime($newsItem['published_at'])) ?></span>
                        <span><i class="icon-visibility"></i><?= number_format((int) ($newsItem['views'] ?? 0)) ?> kali dibaca</span>
                        <span><i class="icon-tag"></i><?= esc($categories[$newsItem['category']] ?? ucfirst($newsItem['category'])) ?></span>
                    </div>

                    <div class="blog-details__text">
                        <?= $newsItem['content'] ?>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-4 col-md-12">
                <aside class="sidebar">
                    <div class="sidebar-widget category-widget">
                        <div class="widget-title">
                            <h4>Kategori Berita</h4>
                        </div>
                        <ul class="category-list clearfix">
                            <?php foreach ($categories as $key => $label): ?>
                                <li class="<?= $key === $newsItem['category'] ? 'active' : '' ?>">
                                    <a href="<?= base_url('news/category/' . $key) ?>"><?= esc($label) ?></a>
                                </li>
                            <?php endforeach ?>
                            <li>
                                <a href="<?= base_url('news') ?>">Semua Berita</a>
                            </li>
                        </ul>
                    </div>

                    <?php if (!empty($relatedNews)): ?>
                        <div class="sidebar-widget post-widget">
                            <div class="widget-title">
                                <h4>Berita Terkait</h4>
                            </div>
                            <?php foreach ($relatedNews as $item): ?>
                                <div class="post">
                                    <div class="content">
                                        <h5>
                                            <a href="<?= base_url('news/' . $item['slug']) ?>"><?= esc($item['title']) ?></a>
                                        </h5>
                                        <span class="date">
                                            <span class="icon-calendar"></span><?= date('d M Y', strtotime($item['published_at'])) ?>
                                        </span>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                    <?php endif ?>
                </aside>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
