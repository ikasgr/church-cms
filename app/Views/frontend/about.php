<?= $this->extend('frontend/layouts/main') ?>

<?= $this->section('content') ?>

<!-- START ABOUT SECTION -->
<section class="about-one py-5">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6 mb-4 mb-lg-0">
        <img src="<?= base_url('assets/images/about-church.jpg') ?>" class="img-fluid rounded" alt="Tentang Gereja">
      </div>
      <div class="col-lg-6">
        <h2 class="mb-3">Tentang Gereja Kami</h2>
        <p>
          CMS Church Flobamora adalah sistem manajemen gereja modern yang membantu pelayanan menjadi
          lebih transparan, teratur, dan terhubung dengan jemaat. Melalui sistem ini, seluruh kegiatan
          gereja — dari ibadah, keuangan, hingga pengumuman — dapat dikelola secara digital dan mudah diakses.
        </p>
        <p>
          Didesain untuk gereja-gereja di NTT dan sekitarnya, CMS ini menjadi wadah pelayanan digital
          yang mengutamakan kemudahan, keamanan, dan transparansi.
        </p>
      </div>
    </div>
  </div>
</section>
<!-- END ABOUT SECTION -->

<?= $this->endSection() ?>
