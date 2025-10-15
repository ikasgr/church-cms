<?= $this->extend('frontend/layouts/main') ?>

<?= $this->section('content') ?>

<section class="page-header">
    <div class="auto-container">
        <div class="page-header__inner">
            <h1>UMKM Jemaat</h1>
            <p>Dukung usaha jemaat dengan membeli produk-produk unggulan berikut.</p>
        </div>
    </div>
</section>

<section class="shop-page">
    <div class="auto-container">
        <div class="row">
            <div class="col-lg-3 col-md-4">
                <aside class="shop-sidebar">
                    <div class="shop-sidebar__single">
                        <h3 class="shop-sidebar__title">Kategori</h3>
                        <ul class="shop-sidebar__list">
                            <li class="<?= $activeCategory ? '' : 'current' ?>">
                                <a href="<?= base_url('umkm') ?>">Semua</a>
                            </li>
                            <?php foreach ($categories as $category): ?>
                                <li class="<?= $activeCategory == $category['slug'] ? 'current' : '' ?>">
                                    <a href="<?= base_url('umkm/kategori/' . $category['slug']) ?>">
                                        <?= esc($category['name']) ?>
                                        <span>(<?= $category['product_count'] ?? 0 ?>)</span>
                                    </a>
                                </li>
                            <?php endforeach ?>
                        </ul>
                    </div>

                    <div class="shop-sidebar__single">
                        <h3 class="shop-sidebar__title">Pencarian</h3>
                        <form action="<?= base_url('umkm') ?>" method="get" class="shop-search">
                            <div class="form-group">
                                <input type="hidden" name="category" value="<?= esc($activeCategory) ?>">
                                <input type="text" name="q" value="<?= esc($search) ?>" placeholder="Cari produk atau pelapak">
                                <button type="submit"><span class="icon-search"></span></button>
                            </div>
                        </form>
                    </div>

                    <div class="shop-sidebar__single">
                        <h3 class="shop-sidebar__title">Filter Harga</h3>
                        <form action="<?= current_url(true)->getPath() === 'umkm' ? base_url('umkm') : current_url() ?>" method="get" class="price-filter">
                            <input type="hidden" name="q" value="<?= esc($search) ?>">
                            <div class="form-group">
                                <label>Minimal</label>
                                <input type="number" name="min" value="<?= esc($priceMin) ?>" placeholder="0">
                            </div>
                            <div class="form-group">
                                <label>Maksimal</label>
                                <input type="number" name="max" value="<?= esc($priceMax) ?>" placeholder="1000000">
                            </div>
                            <button type="submit" class="thm-btn"><span class="txt">Terapkan</span></button>
                        </form>
                    </div>
                </aside>
            </div>

            <div class="col-lg-9 col-md-8">
                <div class="shop-top">
                    <div class="shop-top__left">
                        <p>Menampilkan <?= count($products) ?> produk</p>
                    </div>
                    <div class="shop-top__right">
                        <form action="<?= current_url() ?>" method="get" class="shop-sort">
                            <input type="hidden" name="q" value="<?= esc($search) ?>">
                            <input type="hidden" name="min" value="<?= esc($priceMin) ?>">
                            <input type="hidden" name="max" value="<?= esc($priceMax) ?>">
                            <select name="sort" onchange="this.form.submit()">
                                <option value="latest" <?= $sort === 'latest' ? 'selected' : '' ?>>Terbaru</option>
                                <option value="price_asc" <?= $sort === 'price_asc' ? 'selected' : '' ?>>Harga Rendah &rarr; Tinggi</option>
                                <option value="price_desc" <?= $sort === 'price_desc' ? 'selected' : '' ?>>Harga Tinggi &rarr; Rendah</option>
                                <option value="popular" <?= $sort === 'popular' ? 'selected' : '' ?>>Terlaris</option>
                                <option value="rating" <?= $sort === 'rating' ? 'selected' : '' ?>>Terbaik</option>
                            </select>
                        </form>
                    </div>
                </div>

                <?php if (empty($products)): ?>
                    <div class="alert alert-info mt-4">
                        <p>Belum ada produk yang tersedia pada kategori ini.</p>
                    </div>
                <?php else: ?>
                    <div class="row">
                        <?php foreach ($products as $product): ?>
                            <div class="col-xl-4 col-lg-6 col-md-6">
                                <div class="shop-card">
                                    <div class="shop-card__image">
                                        <?php $images = json_decode($product['images'] ?? '[]', true) ?: []; ?>
                                        <?php $cover = $images[0] ?? 'placeholder-product.jpg'; ?>
                                        <a href="<?= base_url('umkm/produk/' . $product['slug']) ?>">
                                            <img src="<?= base_url('uploads/umkm/products/' . $cover) ?>" alt="<?= esc($product['name']) ?>">
                                        </a>
                                        <?php if (!empty($product['discount_price'])): ?>
                                            <div class="shop-card__badge">Diskon</div>
                                        <?php endif ?>
                                    </div>
                                    <div class="shop-card__content">
                                        <div class="shop-card__seller">
                                            <a href="<?= base_url('umkm/pelapak/' . $product['seller_id']) ?>">
                                                <?= esc($product['seller_name']) ?>
                                            </a>
                                        </div>
                                        <h3>
                                            <a href="<?= base_url('umkm/produk/' . $product['slug']) ?>">
                                                <?= esc($product['name']) ?>
                                            </a>
                                        </h3>
                                        <p class="shop-card__category"><?= esc($product['category_name'] ?? 'Lainnya') ?></p>
                                        <div class="shop-card__price">
                                            <?php if (!empty($product['discount_price'])): ?>
                                                <span class="shop-card__price-new">Rp <?= number_format($product['discount_price'], 0, ',', '.') ?></span>
                                                <span class="shop-card__price-old">Rp <?= number_format($product['price'], 0, ',', '.') ?></span>
                                            <?php else: ?>
                                                <span class="shop-card__price-new">Rp <?= number_format($product['price'], 0, ',', '.') ?></span>
                                            <?php endif ?>
                                        </div>
                                        <div class="shop-card__meta">
                                            <span><i class="icon-shopping-bag1"></i> <?= number_format($product['sold_count'] ?? 0) ?> terjual</span>
                                            <span><i class="icon-star"></i> <?= number_format($product['rating'] ?? 0, 1) ?>/5</span>
                                        </div>
                                        <div class="shop-card__bottom">
                                            <a class="thm-btn thm-btn--outline" href="<?= base_url('umkm/produk/' . $product['slug']) ?>">
                                                <span class="txt">Detail Produk</span>
                                            </a>
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
</section>

<?= $this->endSection() ?>
