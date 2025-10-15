<?= $this->extend('frontend/layouts/main') ?>

<?= $this->section('content') ?>

<section class="page-header">
    <div class="auto-container">
        <div class="page-header__inner">
            <h1>Majelis Gereja</h1>
            <p>Profil majelis dan tim pendukung pelayanan Gereja FLOBAMORA.</p>
        </div>
    </div>
</section>

<section class="team-page">
    <div class="auto-container">
        <?php if (!empty($majelis)): ?>
            <div class="row clearfix">
                <?php foreach ($majelis as $member): ?>
                    <div class="col-xl-4 col-lg-4 col-md-6 team-block">
                        <div class="team-one__single wow fadeInUp" data-wow-delay="0ms" data-wow-duration="1500ms" id="<?= esc(url_title($member['name'], '-', true)) ?>">
                            <div class="team-one__single-img">
                                <div class="team-one__single-img-bg" style="background-image:url('<?= base_url('assets/images/shapes/team-v1-shape1.png') ?>');"></div>
                                <div class="inner">
                                    <?php if (!empty($member['photo'])): ?>
                                        <img src="<?= base_url('uploads/majelis/' . $member['photo']) ?>" alt="<?= esc($member['name']) ?>">
                                    <?php else: ?>
                                        <img src="<?= base_url('assets/images/team/team-placeholder.jpg') ?>" alt="<?= esc($member['name']) ?>">
                                    <?php endif ?>
                                </div>
                            </div>
                            <div class="team-one__single-content text-center">
                                <h2><?= esc($member['name']) ?></h2>
                                <p><?= esc($member['position']) ?></p>
                                <div class="team-one__single-meta">
                                    <?php if (!empty($member['phone'])): ?>
                                        <div class="meta-item"><span class="icon-phone"></span><a href="tel:<?= esc($member['phone']) ?>"><?= esc($member['phone']) ?></a></div>
                                    <?php endif ?>
                                    <?php if (!empty($member['email'])): ?>
                                        <div class="meta-item"><span class="icon-chat-circle"></span><a href="mailto:<?= esc($member['email']) ?>"><?= esc($member['email']) ?></a></div>
                                    <?php endif ?>
                                </div>
                                <?php if (!empty($member['bio'])): ?>
                                    <div class="team-one__single-bio">
                                        <p><?= esc($member['bio']) ?></p>
                                    </div>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        <?php else: ?>
            <div class="news-block-one">
                <div class="inner-box text-center py-60">
                    <div class="icon mb-3"><span class="icon-newspaper"></span></div>
                    <p>Data majelis belum tersedia saat ini.</p>
                </div>
            </div>
        <?php endif ?>
    </div>
</section>

<?= $this->endSection() ?>
