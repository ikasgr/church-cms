<?= $this->extend('frontend/layouts/main') ?>

<?= $this->section('content') ?>

<section class="page-header">
    <div class="auto-container">
        <div class="page-header__inner">
            <h1><?= esc($product['name']) ?></h1>
            <p><?= esc($product['category_name'] ?? 'Produk UMKM') ?> &bull; Pelapak: <?= esc($product['seller_name']) ?></p>
        </div>
    </div>
</section>

<section class="shop-details">
    <div class="auto-container">
        <div class="row">
            <div class="col-lg-6">
                <div class="shop-details__gallery">
                    <div class="shop-details__gallery-main">
                        <?php if (!empty($images)): ?>
                            <img src="<?= base_url('uploads/umkm/products/' . $images[0]) ?>" alt="<?= esc($product['name']) ?>">
                        <?php else: ?>
                            <img src="<?= base_url('assets/images/shop/shop-placeholder.jpg') ?>" alt="<?= esc($product['name']) ?>">
                        <?php endif ?>
                    </div>
                    <?php if (count($images) > 1): ?>
                        <div class="shop-details__gallery-thumb">
                            <?php foreach ($images as $image): ?>
                                <div class="thumb">
                                    <img src="<?= base_url('uploads/umkm/products/' . $image) ?>" alt="<?= esc($product['name']) ?>">
                                </div>
                            <?php endforeach ?>
                        </div>
                    <?php endif ?>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="shop-details__content">
                    <h2><?= esc($product['name']) ?></h2>
                    <div class="shop-details__meta">
                        <span><i class="icon-tag"></i> <?= esc($product['category_name'] ?? 'Lainnya') ?></span>
                        <span><i class="icon-shopping-bag1"></i> <?= number_format($product['sold_count'] ?? 0) ?> terjual</span>
                        <span><i class="icon-star"></i> <?= number_format($product['rating'] ?? 0, 1) ?>/5</span>
                    </div>
                    <div class="shop-details__price">
                        <?php if (!empty($product['discount_price'])): ?>
                            <span class="price-new">Rp <?= number_format($product['discount_price'], 0, ',', '.') ?></span>
                            <span class="price-old">Rp <?= number_format($product['price'], 0, ',', '.') ?></span>
                        <?php else: ?>
                            <span class="price-new">Rp <?= number_format($product['price'], 0, ',', '.') ?></span>
                        <?php endif ?>
                    </div>

                    <div class="shop-details__description">
                        <?= nl2br(esc($product['description'] ?? 'Deskripsi belum tersedia.')) ?>
                    </div>

                    <div class="shop-details__info">
                        <ul>
                            <li><span>Minimal Order:</span> <?= number_format($product['min_order'] ?? 1) ?> <?= esc($product['unit'] ?? 'pcs') ?></li>
                            <?php if (!empty($product['sku'])): ?><li><span>Kode Produk:</span> <?= esc($product['sku']) ?></li><?php endif ?>
                            <?php if (!empty($product['weight'])): ?><li><span>Berat:</span> <?= number_format($product['weight'], 2) ?> kg</li><?php endif ?>
                            <li><span>Stok:</span> <?= number_format($product['stock'] ?? 0) ?></li>
                        </ul>
                    </div>

                    <div class="shop-details__contact">
                        <h3>Hubungi Pelapak</h3>
                        <p><?= esc($product['seller_name']) ?></p>
                        <?php if (!empty($product['seller_phone'])): ?>
                            <a class="shop-details__contact-btn thm-btn" href="https://wa.me/<?= preg_replace('/\D+/', '', $product['seller_phone']) ?>" target="_blank">
                                <span class="txt">Hubungi via WhatsApp</span>
                            </a>
                        <?php endif ?>
                        <?php if (!empty($product['seller_email'])): ?>
                            <p><i class="icon-envelope"></i> <?= esc($product['seller_email']) ?></p>
                        <?php endif ?>
                        <?php if (!empty($product['seller_address'])): ?>
                            <p><i class="icon-pin"></i> <?= esc($product['seller_address']) ?></p>
                        <?php endif ?>
                        <div class="shop-details__contact-link">
                            <a href="<?= base_url('umkm/pelapak/' . $product['seller_id']) ?>">Lihat profil pelapak &raquo;</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if (!empty($relatedProducts)): ?>
            <div class="shop-details__related">
                <div class="sec-title">
                    <div class="sec-title__tagline"><h6>Produk Terkait</h6></div>
                    <h2 class="sec-title__title">Pilihan lainnya</h2>
                </div>
                <div class="row">
                    <?php foreach ($relatedProducts as $related): ?>
                        <?php $relImages = json_decode($related['images'] ?? '[]', true) ?: []; ?>
                        <?php $relCover = $relImages[0] ?? 'shop-placeholder.jpg'; ?>
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="shop-card">
                                <div class="shop-card__image">
                                    <a href="<?= base_url('umkm/produk/' . $related['slug']) ?>">
                                        <img src="<?= base_url('uploads/umkm/products/' . $relCover) ?>" alt="<?= esc($related['name']) ?>">
                                    </a>
                                </div>
                                <div class="shop-card__content">
                                    <h3><a href="<?= base_url('umkm/produk/' . $related['slug']) ?>"><?= esc($related['name']) ?></a></h3>
                                    <p class="shop-card__category"><?= esc($related['category_name'] ?? 'Lainnya') ?></p>
                                    <div class="shop-card__price">
                                        <?php if (!empty($related['discount_price'])): ?>
                                            <span class="shop-card__price-new">Rp <?= number_format($related['discount_price'], 0, ',', '.') ?></span>
                                            <span class="shop-card__price-old">Rp <?= number_format($related['price'], 0, ',', '.') ?></span>
                                        <?php else: ?>
                                            <span class="shop-card__price-new">Rp <?= number_format($related['price'], 0, ',', '.') ?></span>
                                        <?php endif ?>
                                    </div>
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
