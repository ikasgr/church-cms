<?= $this->extend('frontend/layouts/main') ?>

<?= $this->section('content') ?>

<section class="page-header">
    <div class="auto-container">
        <div class="page-header__inner">
            <h1>Pelapak: <?= esc($seller['business_name']) ?></h1>
            <p><?= esc($seller['description'] ?? 'Pelapak UMKM jemaat') ?></p>
        </div>
    </div>
</section>

<section class="seller-details">
    <div class="auto-container">
        <div class="row">
            <div class="col-lg-4">
                <div class="seller-details__sidebar">
                    <div class="seller-details__profile">
                        <div class="seller-details__avatar">
                            <?php if (!empty($seller['logo'])): ?>
                                <img src="<?= base_url('uploads/umkm/sellers/' . $seller['logo']) ?>" alt="<?= esc($seller['business_name']) ?>">
                            <?php else: ?>
                                <img src="<?= base_url('assets/images/team/team-placeholder.jpg') ?>" alt="<?= esc($seller['business_name']) ?>">
                            <?php endif ?>
                        </div>
                        <h2><?= esc($seller['business_name']) ?></h2>
                        <p class="seller-details__owner">Pemilik: <?= esc($seller['owner_name'] ?? '-') ?></p>
                        <div class="seller-details__rating">
                            <span><i class="icon-star"></i> <?= number_format($seller['rating'] ?? 0, 1) ?>/5</span>
                            <span><i class="icon-shopping-bag1"></i> <?= number_format($seller['total_products'] ?? 0) ?> produk</span>
                        </div>
                    </div>

                    <div class="seller-details__contact">
                        <h3>Kontak</h3>
                        <ul>
                            <?php if (!empty($seller['phone'])): ?>
                                <li><span><i class="icon-phone-call"></i></span> <?= esc($seller['phone']) ?></li>
                            <?php endif ?>
                            <?php if (!empty($seller['email'])): ?>
                                <li><span><i class="icon-envelope"></i></span> <?= esc($seller['email']) ?></li>
                            <?php endif ?>
                            <?php if (!empty($seller['address'])): ?>
                                <li><span><i class="icon-pin"></i></span> <?= esc($seller['address']) ?></li>
                            <?php endif ?>
                        </ul>
                        <?php if (!empty($seller['phone'])): ?>
                            <a class="thm-btn thm-btn--outline" href="https://wa.me/<?= preg_replace('/\D+/', '', $seller['phone']) ?>" target="_blank">
                                <span class="txt">Hubungi Pelapak</span>
                            </a>
                        <?php endif ?>
                    </div>

                    <div class="seller-details__stats">
                        <h3>Statistik</h3>
                        <ul>
                            <li><span>Total Penjualan:</span> Rp <?= number_format($seller['total_sales'] ?? 0, 0, ',', '.') ?></li>
                            <li><span>Produk Aktif:</span> <?= number_format($seller['total_products'] ?? 0) ?></li>
                            <li><span>Ulasan:</span> <?= number_format($seller['total_reviews'] ?? 0) ?></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="seller-details__products">
                    <div class="sec-title">
                        <div class="sec-title__tagline"><h6>Produk Pelapak</h6></div>
                        <h2 class="sec-title__title">Temukan produk unggulan</h2>
                    </div>

                    <?php if (empty($products)): ?>
                        <div class="alert alert-info">
                            <p>Belum ada produk yang ditampilkan oleh pelapak ini.</p>
                        </div>
                    <?php else: ?>
                        <div class="row">
                            <?php foreach ($products as $product): ?>
                                <?php $images = json_decode($product['images'] ?? '[]', true) ?: []; ?>
                                <?php $cover = $images[0] ?? 'shop-placeholder.jpg'; ?>
                                <div class="col-xl-4 col-lg-6 col-md-6">
                                    <div class="shop-card">
                                        <div class="shop-card__image">
                                            <a href="<?= base_url('umkm/produk/' . $product['slug']) ?>">
                                                <img src="<?= base_url('uploads/umkm/products/' . $cover) ?>" alt="<?= esc($product['name']) ?>">
                                            </a>
                                            <?php if (!empty($product['discount_price'])): ?>
                                                <div class="shop-card__badge">Diskon</div>
                                            <?php endif ?>
                                        </div>
                                        <div class="shop-card__content">
                                            <h3><a href="<?= base_url('umkm/produk/' . $product['slug']) ?>"><?= esc($product['name']) ?></a></h3>
                                            <div class="shop-card__price">
                                                <?php if (!empty($product['discount_price'])): ?>
                                                    <span class="shop-card__price-new">Rp <?= number_format($product['discount_price'], 0, ',', '.') ?></span>
                                                    <span class="shop-card__price-old">Rp <?= number_format($product['price'], 0, ',', '.') ?></span>
                                                <?php else: ?>
                                                    <span class="shop-card__price-new">Rp <?= number_format($product['price'], 0, ',', '.') ?></span>
                                                <?php endif ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
