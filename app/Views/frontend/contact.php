<?= $this->extend('frontend/layouts/main') ?>

<?= $this->section('content') ?>

<!-- START CONTACT SECTION -->
<section class="contact-one py-5 bg-light">
  <div class="container">
    <div class="text-center mb-5">
      <h2>Hubungi Kami</h2>
      <p>Silakan hubungi kami untuk informasi lebih lanjut atau pelayanan gereja.</p>
    </div>

    <div class="row">
      <div class="col-md-6">
        <form action="#" method="post">
          <div class="mb-3">
            <label for="name" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" id="name" name="name" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>
          <div class="mb-3">
            <label for="message" class="form-label">Pesan</label>
            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Kirim Pesan</button>
        </form>
      </div>

      <div class="col-md-6">
        <h4>Alamat Gereja</h4>
        <p>
          Jl. Flobamora Raya No.12, Kota Kupang, Nusa Tenggara Timur<br>
          <strong>Telepon:</strong> (0380) 123456<br>
          <strong>Email:</strong> info@churchflobamora.org
        </p>

        <div class="mt-4">
          <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3944.5166!2d123.588!3d-10.178!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTDCsDEwJzQxLjEiUyAxMjPCsDM1JzI1LjkiRQ!5e0!3m2!1sen!2sid!4v1610000000000" 
            width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy">
          </iframe>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- END CONTACT SECTION -->

<?= $this->endSection() ?>
