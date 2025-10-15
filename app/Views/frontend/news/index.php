<?= $this->extend('frontend/layouts/main') ?>

<?= $this->section('content') ?>

<section class="page-header">
    <div class="auto-container">
        <div class="page-header__inner">
            <h1>Berita & Warta</h1>
            <p>Dapatkan kabar dan warta pelayanan terbaru gereja.</p>
        </div>
    </div>
</section>

<section class="blog-page">
    <div class="auto-container">
        <div class="row clearfix">
            <div class="col-xl-8 col-lg-8 col-md-12">
                <?php if (empty($newsList)): ?>
                    <div class="news-block-one">
                        <div class="inner-box text-center py-60">
                            <div class="icon mb-3"><span class="icon-newspaper"></span></div>
                            <h4 class="text-gray-700">Belum ada berita pada kategori ini.</h4>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="row clearfix">
                        <?php foreach ($newsList as $news): ?>
                            <div class="col-md-6 news-block">
                                <div class="news-block-one wow fadeInUp" data-wow-delay="0ms" data-wow-duration="1500ms">
                                    <div class="inner-box">
                                        <?php if (!empty($news['featured_image'])): ?>
                                            <div class="image">
                                                <a href="<?= base_url('news/' . $news['slug']) ?>">
                                                    <img src="<?= base_url('uploads/news/' . $news['featured_image']) ?>" alt="<?= esc($news['title']) ?>">
                                                </a>
                                            </div>
                                        <?php endif ?>
                                        <div class="lower-content">
                                            <div class="category">
                                                <span><?= esc($categories[$news['category']] ?? ucfirst($news['category'])) ?></span>
                                            </div>
                                            <h3><a href="<?= base_url('news/' . $news['slug']) ?>"><?= esc($news['title']) ?></a></h3>
                                            <ul class="post-meta">
                                                <li><span class="icon-calendar"></span><?= date('d M Y', strtotime($news['published_at'])) ?></li>
                                                <li><span class="icon-visibility"></span><?= number_format((int) ($news['views'] ?? 0)) ?> dibaca</li>
                                            </ul>
                                            <p><?= esc($news['excerpt'] ?? word_limiter(strip_tags($news['content']), 30)) ?></p>
                                            <div class="btn-box">
                                                <a class="read-more" href="<?= base_url('news/' . $news['slug']) ?>">
                                                    Baca Selengkapnya<span class="icon-right-arrow21"></span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>

                    <div class="styled-pagination text-center mt-40">
                        <?= $pager->links('news', 'default_full') ?>
                    </div>
                <?php endif ?>
            </div>

            <div class="col-xl-4 col-lg-4 col-md-12">
                <aside class="sidebar">
                    <div class="sidebar-widget category-widget">
                        <div class="widget-title">
                            <h4>Kategori Berita</h4>
                        </div>
                        <ul class="category-list clearfix">
                            <li class="<?= $activeCategory === null ? 'active' : '' ?>">
                                <a href="<?= base_url('news') ?>">Semua Berita</a>
                            </li>
                            <?php foreach ($categories as $key => $label): ?>
                                <li class="<?= $activeCategory === $key ? 'active' : '' ?>">
                                    <a href="<?= base_url('news/category/' . $key) ?>"><?= esc($label) ?></a>
                                </li>
                            <?php endforeach ?>
                        </ul>
                    </div>

                    <?php if (isset($popularNews) && count($popularNews) > 0): ?>
                        <div class="sidebar-widget post-widget">
                            <div class="widget-title">
                                <h4>Terpopuler</h4>
                            </div>
                            <?php foreach ($popularNews as $item): ?>
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
