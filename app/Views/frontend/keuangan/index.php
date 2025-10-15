<?= $this->extend('frontend/layouts/main') ?>

<?= $this->section('content') ?>

<section class="page-header">
    <div class="auto-container">
        <div class="page-header__inner">
            <h1>Transparansi Keuangan Gereja</h1>
            <p>Laporan keuangan bulanan untuk jemaat.</p>
        </div>
    </div>
</section>

<section class="finance-overview">
    <div class="auto-container">
        <div class="finance-overview__summary row clearfix">
            <div class="col-lg-4 col-md-6">
                <div class="finance-card finance-card--income">
                    <div class="finance-card__icon"><span class="icon-donation-2"></span></div>
                    <div class="finance-card__content">
                        <h3>Penerimaan</h3>
                        <p>Rp <?= number_format($totals['penerimaan'] ?? 0, 0, ',', '.') ?></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="finance-card finance-card--expense">
                    <div class="finance-card__icon"><span class="icon-donation-3"></span></div>
                    <div class="finance-card__content">
                        <h3>Pengeluaran</h3>
                        <p>Rp <?= number_format($totals['pengeluaran'] ?? 0, 0, ',', '.') ?></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="finance-card finance-card--balance">
                    <div class="finance-card__icon"><span class="icon-wallet"></span></div>
                    <div class="finance-card__content">
                        <h3>Saldo Bulan Ini</h3>
                        <p>Rp <?= number_format($balance, 0, ',', '.') ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="finance-overview__filters">
            <form action="<?= base_url('keuangan') ?>" method="get" class="finance-filter-form">
                <div class="row clearfix">
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <label>Bulan</label>
                        <select name="month" class="thm-select">
                            <?php for ($m = 1; $m <= 12; $m++): ?>
                                <?php $value = str_pad((string) $m, 2, '0', STR_PAD_LEFT); ?>
                                <option value="<?= $value ?>" <?= $filters['month'] === $value ? 'selected' : '' ?>>
                                    <?= date('F', mktime(0, 0, 0, $m, 1)) ?>
                                </option>
                            <?php endfor ?>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <label>Tahun</label>
                        <select name="year" class="thm-select">
                            <?php for ($y = date('Y'); $y >= date('Y') - 5; $y--): ?>
                                <option value="<?= $y ?>" <?= $filters['year'] === (string) $y ? 'selected' : '' ?>>
                                    <?= $y ?>
                                </option>
                            <?php endfor ?>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <label>Tipe</label>
                        <select name="type" class="thm-select">
                            <option value="">Semua</option>
                            <option value="penerimaan" <?= $filters['type'] === 'penerimaan' ? 'selected' : '' ?>>Penerimaan</option>
                            <option value="pengeluaran" <?= $filters['type'] === 'pengeluaran' ? 'selected' : '' ?>>Pengeluaran</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-12 col-sm-6 align-self-end">
                        <button type="submit" class="thm-btn"><span class="txt">Terapkan</span></button>
                    </div>
                </div>
            </form>
        </div>

        <div class="finance-overview__content row clearfix">
            <div class="col-lg-8">
                <div class="finance-table">
                    <h2>Ringkasan Transaksi</h2>
                    <?php if (empty($transactions)): ?>
                        <div class="finance-table__empty">
                            <p>Belum ada transaksi untuk periode ini.</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="finance-table__table">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Tipe</th>
                                        <th>Kategori</th>
                                        <th>Deskripsi</th>
                                        <th class="text-right">Jumlah</th>
                                        <th class="text-center">Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($transactions as $transaction): ?>
                                        <tr>
                                            <td><?= date('d M Y', strtotime($transaction['transaction_date'])) ?></td>
                                            <td>
                                                <span class="badge badge--<?= $transaction['type'] ?>">
                                                    <?= $transaction['type'] === 'penerimaan' ? 'Penerimaan' : 'Pengeluaran' ?>
                                                </span>
                                            </td>
                                            <td><?= esc(ucwords($transaction['category'])) ?></td>
                                            <td>
                                                <span><?= esc($transaction['description']) ?></span>
                                                <?php if (!empty($transaction['source'])): ?>
                                                    <small>Sumber: <?= esc($transaction['source']) ?></small>
                                                <?php endif ?>
                                            </td>
                                            <td class="text-right <?= $transaction['type'] === 'penerimaan' ? 'text-success' : 'text-danger' ?>">
                                                Rp <?= number_format($transaction['amount'], 0, ',', '.') ?>
                                            </td>
                                            <td class="text-center">
                                                <a class="finance-table__detail-link" href="<?= base_url('keuangan/detail/' . $transaction['id']) ?>">Lihat</a>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif ?>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="finance-card--sidebar">
                    <h3>Distribusi Kategori</h3>
                    <div class="finance-card--sidebar__section">
                        <h4>Penerimaan</h4>
                        <?php if (empty($categoryBreakdown['penerimaan'])): ?>
                            <p>Belum ada data.</p>
                        <?php else: ?>
                            <ul class="finance-list">
                                <?php foreach ($categoryBreakdown['penerimaan'] as $item): ?>
                                    <li>
                                        <span><?= esc(ucwords($item['category'])) ?></span>
                                        <span>Rp <?= number_format($item['total'], 0, ',', '.') ?></span>
                                    </li>
                                <?php endforeach ?>
                            </ul>
                        <?php endif ?>
                    </div>
                    <div class="finance-card--sidebar__section">
                        <h4>Pengeluaran</h4>
                        <?php if (empty($categoryBreakdown['pengeluaran'])): ?>
                            <p>Belum ada data.</p>
                        <?php else: ?>
                            <ul class="finance-list">
                                <?php foreach ($categoryBreakdown['pengeluaran'] as $item): ?>
                                    <li>
                                        <span><?= esc(ucwords($item['category'])) ?></span>
                                        <span>Rp <?= number_format($item['total'], 0, ',', '.') ?></span>
                                    </li>
                                <?php endforeach ?>
                            </ul>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="finance-overview__trend">
            <h2>Tren Taunan <?= esc($filters['year']) ?></h2>
            <div class="table-responsive">
                <table class="finance-trend-table">
                    <thead>
                        <tr>
                            <th>Bulan</th>
                            <th>Penerimaan</th>
                            <th>Pengeluaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($yearlyTrend as $monthIndex => $trend): ?>
                            <tr>
                                <td><?= date('F', mktime(0, 0, 0, $monthIndex, 1)) ?></td>
                                <td>Rp <?= number_format($trend['penerimaan'], 0, ',', '.') ?></td>
                                <td>Rp <?= number_format($trend['pengeluaran'], 0, ',', '.') ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
