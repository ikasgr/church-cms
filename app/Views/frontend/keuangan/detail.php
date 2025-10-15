<?= $this->extend('frontend/layouts/main') ?>

<?= $this->section('content') ?>

<section class="page-header">
    <div class="auto-container">
        <div class="page-header__inner">
            <h1>Detail Transaksi Keuangan</h1>
            <p>Rincian lengkap transaksi yang telah dicatat.</p>
        </div>
    </div>
</section>

<section class="finance-detail">
    <div class="auto-container">
        <div class="finance-detail__card">
            <div class="finance-detail__header">
                <span class="badge badge--<?= $transaction['type'] ?>">
                    <?= $transaction['type'] === 'penerimaan' ? 'Penerimaan' : 'Pengeluaran' ?>
                </span>
                <h2><?= esc($transaction['description']) ?></h2>
                <p><?= date('d F Y', strtotime($transaction['transaction_date'])) ?></p>
            </div>

            <div class="finance-detail__amount <?= $transaction['type'] === 'penerimaan' ? 'income' : 'expense' ?>">
                <h3>Jumlah Transaksi</h3>
                <p>Rp <?= number_format($transaction['amount'], 0, ',', '.') ?></p>
            </div>

            <div class="finance-detail__info">
                <div class="finance-detail__info-item">
                    <span>Kategori</span>
                    <strong><?= esc(ucwords($transaction['category'])) ?></strong>
                </div>
                <?php if (!empty($transaction['sub_category'])): ?>
                    <div class="finance-detail__info-item">
                        <span>Sub Kategori</span>
                        <strong><?= esc(ucwords($transaction['sub_category'])) ?></strong>
                    </div>
                <?php endif ?>
                <?php if (!empty($transaction['source'])): ?>
                    <div class="finance-detail__info-item">
                        <span>Sumber Dana</span>
                        <strong><?= esc($transaction['source']) ?></strong>
                    </div>
                <?php endif ?>
                <?php if (!empty($transaction['notes'])): ?>
                    <div class="finance-detail__info-item">
                        <span>Catatan</span>
                        <p><?= nl2br(esc($transaction['notes'])) ?></p>
                    </div>
                <?php endif ?>
            </div>

            <div class="finance-detail__meta">
                <div>
                    <span>Dibuat pada</span>
                    <strong><?= date('d M Y H:i', strtotime($transaction['created_at'])) ?></strong>
                </div>
                <?php if (!empty($transaction['approved_at'])): ?>
                    <div>
                        <span>Disetujui pada</span>
                        <strong><?= date('d M Y H:i', strtotime($transaction['approved_at'])) ?></strong>
                    </div>
                <?php endif ?>
            </div>

            <div class="finance-detail__actions">
                <a class="thm-btn thm-btn--outline" href="<?= base_url('keuangan') ?>">
                    <span class="txt">Kembali ke Laporan</span>
                </a>
                <?php if (!empty($transaction['attachment'])): ?>
                    <a class="thm-btn" href="<?= base_url('uploads/keuangan/' . $transaction['attachment']) ?>" target="_blank" rel="noopener">
                        <span class="txt">Lihat Lampiran</span>
                    </a>
                <?php endif ?>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
