<?php
$siteLogo = $siteLogo ?? app_setting_asset('site_logo', 'assets/images/resources/logo-1.png');
$siteLogoAlt = $siteLogoAlt ?? app_setting('site_name', 'CMS Church');
$siteDescription = app_setting('site_description', 'Gereja yang memberitakan kasih Kristus dan melayani jemaat dengan sepenuh hati.');
$footerText = app_setting('site_footer', '&copy; ' . date('Y') . ' CMS Church. All rights reserved.');
$siteAddress = app_setting('site_office_address', 'Alamat gereja belum diatur.');
$siteCity = app_setting('site_city', 'Kota, Provinsi');
$siteProvince = app_setting('site_province', 'Provinsi');
$siteEmail = app_setting('site_email', 'info@example.com');
$sitePhone = app_setting('site_phone', '0000-0000');

$socialLinks = [
	'facebook' => app_setting('social_facebook'),
	'instagram' => app_setting('social_instagram'),
	'youtube' => app_setting('social_youtube'),
	'tiktok' => app_setting('social_tiktok'),
	'twitter' => app_setting('social_twitter'),
	'linkedin' => app_setting('social_linkedin'),
	'whatsapp' => app_setting('social_whatsapp'),
];

$menuModel = model(App\Models\MenuModel::class);
$footerMenu = $menuModel->getMenuTree('footer');
$quickLinks = !empty($footerMenu) ? $footerMenu : [
	[
		'label' => 'Tentang Kami',
		'url' => '/about'
	],
	[
		'label' => 'Kontak',
		'url' => '/contact'
	],
	[
		'label' => 'Pendaftaran',
		'url' => '/registration'
	],
	[
		'label' => 'Jadwal Ibadah',
		'url' => '/ibadah'
	],
	[
		'label' => 'Berita Gereja',
		'url' => '/news'
	],
];

$latestNews = model(App\Models\NewsModel::class)
	->where('is_published', 1)
	->where('published_at <=', date('Y-m-d H:i:s'))
	->orderBy('published_at', 'DESC')
	->select('id, title, slug, published_at, featured_image')
	->limit(2)
	->find();

?>

  <!-- FOOTER SECTION -->
  <footer class="footer-one">
    <div class="footer-one__bg" style="background-image: url(<?= base_url('assets/images/pattern/footer-v1-bg.jpg') ?>);"></div>
    <div class="shape1"><img src="<?= base_url('assets/images/shapes/footer-v1-shape1.png') ?>" alt="#"></div>
    <div class="shape2"><img src="<?= base_url('assets/images/shapes/footer-v1-shape2.png') ?>" alt="#"></div>
    <div class="shape3"><img src="<?= base_url('assets/images/shapes/footer-v1-shape3.png') ?>" alt="#"></div>
    <div class="footer">
      <div class="container">
        <div class="footer-one__top">
          <div class="row">
            <div class="col-xl-5">
              <div class="footer-one__top-text">
                <h2><?= esc(app_setting('newsletter_title', 'Berlangganan Buletin Gereja')) ?></h2>
                <p><?= esc(app_setting('newsletter_subtitle', 'Dapatkan kabar terbaru pelayanan dan kegiatan gereja.')) ?></p>
              </div>
            </div>
            <div class="col-xl-7">
              <div class="footer-one__top-form">
                <form class="subscribe-form" action="<?= base_url('contact') ?>" method="get">
                  <div class="input-box">
                    <input type="email" name="email" placeholder="Email Anda">
                  </div>
                  <button type="submit">
                    <span class="text">Kirim</span>
                    <i class="icon-send-message"></i>
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="footer-one__middel">
          <div class="row">
            <div class="col-xl-3 col-lg-6 col-md-6  wow animated fadeInUp" data-wow-delay="0.1s">
              <div class="footer-widget__single">
                <div class="footer-widget__single-about">
                  <div class="logo-box">
                    <a href="<?= base_url() ?>"><img src="<?= $siteLogo ?>" alt="<?= esc($siteLogoAlt) ?>"></a>
                  </div>
                  <div class="footer-widget__single-about-text">
                    <p><?= esc($siteDescription) ?></p>
                  </div>
                  <div class="footer-widget__single-about-btn">
                    <a class="thm-btn" href="<?= base_url('contact') ?>">
                      <span class="txt">Hubungi Kami</span>
                    </a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 wow animated fadeInUp" data-wow-delay="0.2s">
              <div class="footer-one__single footer-one__single-address">
                <div class="title">
                  <h3>Kontak</h3>
                </div>
                <ul class="footer-one__single-address-box">
                  <li>
                    <div class="title-box">
                      <h3>Alamat Gereja</h3>
                    </div>
                    <div class="inner">
                      <div class="icon-box">
                        <span class="icon-location1"></span>
                      </div>
                      <div class="content-box">
                        <p><?= nl2br(esc($siteAddress)) ?><br><?= esc($siteCity) ?>, <?= esc($siteProvince) ?></p>
                      </div>
                    </div>
                  </li>
                  <li>
                    <div class="title-box">
                      <h3>Kantor Administrasi</h3>
                    </div>
                    <div class="inner">
                      <div class="icon-box">
                        <span class="icon-phone"></span>
                      </div>
                      <div class="content-box">
                        <p><a href="tel:<?= preg_replace('/\D+/', '', $sitePhone) ?>"><?= esc($sitePhone) ?></a></p>
                        <p><a href="mailto:<?= esc($siteEmail) ?>"><?= esc($siteEmail) ?></a></p>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
            <div class="col-xl-2 col-lg-6 col-md-6 wow animated fadeInUp" data-wow-delay="0.3s">
              <div class="footer-one__single footer-one__single-explore">
                <div class="title">
                  <h3>Tautan Cepat</h3>
                </div>
                <ul class="footer-one__single-explore-list">
                  <?php foreach ($quickLinks as $link): ?>
                    <li><a href="<?= base_url(ltrim($link['url'], '/')) ?>"><?= esc($link['label']) ?></a></li>
                  <?php endforeach ?>
                </ul>
              </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6 wow animated fadeInUp" data-wow-delay="0.4s">
              <div class="footer-one__single footer-one__single-post">
                <div class="title">
                  <h3>Berita Terbaru</h3>
                </div>
                <ul class="footer-one__single-post-box">
                  <?php if (empty($latestNews)): ?>
                    <li>
                      <div class="content-box">
                        <p>Belum ada berita terbaru.</p>
                      </div>
                    </li>
                  <?php else: ?>
                    <?php foreach ($latestNews as $news): ?>
                      <?php
                        $newsImage = !empty($news['featured_image'])
                          ? base_url('uploads/news/' . $news['featured_image'])
                          : base_url('assets/images/resources/news-placeholder.jpg');
                      ?>
                      <li>
                        <div class="img-box">
                          <img src="<?= $newsImage ?>" alt="<?= esc($news['title']) ?>">
                        </div>
                        <div class="content-box">
                          <span><?= date('d M Y', strtotime($news['published_at'])) ?></span>
                          <p><a href="<?= base_url('news/' . $news['slug']) ?>"><?= esc($news['title']) ?></a></p>
                        </div>
                      </li>
                    <?php endforeach ?>
                  <?php endif ?>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="footer-one__bottom">
      <div class="container">
        <div class="bottom-inner">
          <div class="footer-one__bottom-left">
            <div class="title-box">
              <h4>Ikuti Kami</h4>
            </div>
            <div class="social-links">
              <ul>
                <?php foreach ($socialLinks as $platform => $url): ?>
                  <?php if (!$url) continue; ?>
                  <li><a href="<?= esc($url) ?>" target="_blank" rel="noopener"><span class="icon-<?= $platform === 'twitter' ? 'twitter' : ($platform === 'facebook' ? 'facebook-logo' : ($platform === 'instagram' ? 'instagram' : ($platform === 'youtube' ? 'youtube' : ($platform === 'linkedin' ? 'linkedin' : ($platform === 'tiktok' ? 'tiktok' : 'phone'))))) ?>"></span></a></li>
                <?php endforeach ?>
              </ul>
            </div>
          </div>
          <div class="copyright">
            <p><?= $footerText ?></p>
          </div>
        </div>
      </div>
    </div>
  </footer>

</div><!-- /page-wrapper -->

<div class="mobile-nav__wrapper">
  <div class="mobile-nav__overlay mobile-nav__toggler"></div>
  <div class="mobile-nav__content">
    <span class="mobile-nav__close mobile-nav__toggler">
      <i class="icon-plus"></i>
    </span>
    <div class="logo-box">
      <a href="<?= base_url() ?>" aria-label="logo image">
        <img src="<?= $siteLogo ?>" alt="<?= esc($siteLogoAlt) ?>" />
      </a>
    </div>
    <div class="mobile-nav__container"></div>
    <ul class="mobile-nav__contact list-unstyled">
      <li>
        <i class="fa fa-envelope"></i>
        <a href="mailto:<?= esc($siteEmail) ?>"><?= esc($siteEmail) ?></a>
      </li>
      <li>
        <i class="fa fa-phone-alt"></i>
        <a href="tel:<?= preg_replace('/\D+/', '', $sitePhone) ?>"><?= esc($sitePhone) ?></a>
      </li>
    </ul>
    <div class="mobile-nav__social">
      <?php foreach ($socialLinks as $platform => $url): ?>
        <?php if (!$url) continue; ?>
        <a href="<?= esc($url) ?>" target="_blank" rel="noopener" class="fab fa-<?= $platform === 'youtube' ? 'youtube' : ($platform === 'tiktok' ? 'tiktok' : ($platform === 'linkedin' ? 'linkedin-in' : $platform)) ?>"></a>
      <?php endforeach ?>
    </div>
  </div>
</div>

<div class="search-popup">
  <div class="search-popup__overlay search-toggler"></div>
  <div class="search-popup__content">
    <form action="#">
      <label for="search" class="sr-only">search here</label>
      <input type="text" id="search" placeholder="Search Here..." />
      <button type="submit" aria-label="search submit" class="thm-btn">
        <i class="icon-search"></i>
      </button>
    </form>
  </div>
</div>

<a href="#" data-target="html" class="scroll-to-target scroll-to-top">
  <i class="icon-down-arrow"></i>
</a>

<!-- JS -->
<script src="<?= base_url('assets/vendors/jquery/jquery-3.6.0.min.js') ?>"></script>
<script src="<?= base_url('assets/vendors/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('assets/vendors/bootstrap-select/js/bootstrap-select.min.js') ?>"></script>
<script src="<?= base_url('assets/vendors/bxslider/jquery.bxslider.min.js') ?>"></script>
<script src="<?= base_url('assets/vendors/circleType/jquery.circleType.js') ?>"></script>
<script src="<?= base_url('assets/vendors/circleType/jquery.lettering.min.js') ?>"></script>
<script src="<?= base_url('assets/vendors/isotope/isotope.js') ?>"></script>
<script src="<?= base_url('assets/vendors/jquery-ajaxchimp/jquery.ajaxchimp.min.js') ?>"></script>
<script src="<?= base_url('assets/vendors/jquery-appear/jquery.appear.min.js') ?>"></script>
<script src="<?= base_url('assets/vendors/jquery-magnific-popup/jquery.magnific-popup.min.js') ?>"></script>
<script src="<?= base_url('assets/vendors/jquery-migrate/jquery-migrate.min.js') ?>"></script>
<script src="<?= base_url('assets/vendors/jquery-ui/jquery-ui.js') ?>"></script>
<script src="<?= base_url('assets/vendors/jquery-validate/jquery.validate.min.js') ?>"></script>
<script src="<?= base_url('assets/vendors/nice-select/jquery.nice-select.min.js') ?>"></script>
<script src="<?= base_url('assets/vendors/nouislider/nouislider.min.js') ?>"></script>
<script src="<?= base_url('assets/vendors/odometer/odometer.min.js') ?>"></script>
<script src="<?= base_url('assets/vendors/owl-carousel/owl.carousel.min.js') ?>"></script>
<script src="<?= base_url('assets/vendors/parallax/parallax.min.js') ?>"></script>
<script src="<?= base_url('assets/vendors/swiper/swiper.min.js') ?>"></script>
<script src="<?= base_url('assets/vendors/timepicker/timePicker.js') ?>"></script>
<script src="<?= base_url('assets/vendors/tiny-slider/tiny-slider.min.js') ?>"></script>
<script src="<?= base_url('assets/vendors/typed-2.0.11/typed-2.0.11.js') ?>"></script>
<script src="<?= base_url('assets/vendors/vegas/vegas.min.js') ?>"></script>
<script src="<?= base_url('assets/vendors/wnumb/wNumb.min.js') ?>"></script>
<script src="<?= base_url('assets/vendors/wow/wow.js') ?>"></script>
<script src="<?= base_url('assets/vendors/language-switcher/jquery.polyglot.language.switcher.js') ?>"></script>
<script src="<?= base_url('assets/vendors/jarallax/jarallax.min.js') ?>"></script>
<script src="<?= base_url('assets/vendors/slick-slider/slick.js') ?>"></script>
<script src="<?= base_url('assets/vendors/jquery-circle-progress/jquery.circle-progress.min.js') ?>"></script>
<script src="<?= base_url('assets/vendors/progress-bar/knob.js') ?>"></script>
<script src="<?= base_url('assets/js/custom.js') ?>"></script>

<?= $this->renderSection('scripts') ?>
</body>
</html>
