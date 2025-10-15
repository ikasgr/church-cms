<?php
$siteLogo = app_setting_asset('site_logo', 'assets/images/resources/logo-1.png');
$siteLogoAlt = app_setting('site_name', 'CMS Church');
$siteIcon = app_setting_asset('site_icon', 'assets/images/favicons/favicon-32x32.png');
$siteAddress = app_setting('site_office_address', 'Alamat gereja belum diatur');
$siteCity = app_setting('site_city', 'Kota, Provinsi');
$siteEmail = app_setting('site_email', 'info@example.com');
$sitePhone = app_setting('site_phone', '0000-0000');
$siteTicker = app_setting('site_short_name', $siteLogoAlt);
$tickerLetters = preg_split('//u', trim($siteTicker), -1, PREG_SPLIT_NO_EMPTY);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title><?= esc($title ?? 'CMS Church || Responsive HTML 5 Template') ?></title>
	<meta name="description" content="CMS Church HTML 5 Template" />
	<link rel="apple-touch-icon" sizes="180x180" href="<?= $siteIcon ?>" />
	<link rel="icon" type="image/png" sizes="32x32" href="<?= $siteIcon ?>" />
	<link rel="icon" type="image/png" sizes="16x16" href="<?= $siteIcon ?>" />
	<link rel="manifest" href="<?= base_url('assets/images/favicons/site.webmanifest') ?>" />
	<link href="https://fonts.googleapis.com/css2?family=Amita:wght@400;700&family=Outfit:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
	<link rel="stylesheet" href="<?= base_url('assets/vendors/animate/animate.min.css') ?>" />
	<link rel="stylesheet" href="<?= base_url('assets/vendors/animate/custom-animate.css') ?>" />
	<link rel="stylesheet" href="<?= base_url('assets/vendors/bootstrap/css/bootstrap.min.css') ?>" />
	<link rel="stylesheet" href="<?= base_url('assets/vendors/bootstrap-select/css/bootstrap-select.min.css') ?>" />
	<link rel="stylesheet" href="<?= base_url('assets/vendors/bxslider/jquery.bxslider.css') ?>" />
	<link rel="stylesheet" href="<?= base_url('assets/vendors/fontawesome/css/all.min.css') ?>" />
	<link rel="stylesheet" href="<?= base_url('assets/vendors/jquery-magnific-popup/jquery.magnific-popup.css') ?>" />
	<link rel="stylesheet" href="<?= base_url('assets/vendors/jquery-ui/jquery-ui.css') ?>" />
	<link rel="stylesheet" href="<?= base_url('assets/vendors/nice-select/nice-select.css') ?>" />
	<link rel="stylesheet" href="<?= base_url('assets/vendors/nouislider/nouislider.min.css') ?>" />
	<link rel="stylesheet" href="<?= base_url('assets/vendors/nouislider/nouislider.pips.css') ?>" />
	<link rel="stylesheet" href="<?= base_url('assets/vendors/odometer/odometer.min.css') ?>" />
	<link rel="stylesheet" href="<?= base_url('assets/vendors/owl-carousel/owl.carousel.min.css') ?>" />
	<link rel="stylesheet" href="<?= base_url('assets/vendors/owl-carousel/owl.theme.default.min.css') ?>" />
	<link rel="stylesheet" href="<?= base_url('assets/vendors/swiper/swiper.min.css') ?>" />
	<link rel="stylesheet" href="<?= base_url('assets/vendors/timepicker/timePicker.css') ?>" />
	<link rel="stylesheet" href="<?= base_url('assets/vendors/tiny-slider/tiny-slider.min.css') ?>" />
	<link rel="stylesheet" href="<?= base_url('assets/vendors/vegas/vegas.min.css') ?>" />
	<link rel="stylesheet" href="<?= base_url('assets/vendors/thm-icons/style.css') ?>" />
	<link rel="stylesheet" href="<?= base_url('assets/vendors/slick-slider/slick.css') ?>" />
	<link rel="stylesheet" href="<?= base_url('assets/vendors/language-switcher/polyglot-language-switcher.css') ?>" />
	<link rel="stylesheet" href="<?= base_url('assets/vendors/reey-font/stylesheet.css') ?>" />
	<link rel="stylesheet" href="<?= base_url('assets/css/church-ikasmedia.css') ?>" />
	<link rel="stylesheet" href="<?= base_url('assets/css/church-ikasmedia-responsive.css') ?>" />
	<?= $this->renderSection('meta') ?>
</head>
<body>
	<div class="loader-wrap">
		<div class="preloader">
			<div class="preloader-close">x</div>
			<div id="handle-preloader" class="handle-preloader">
				<div class="animation-preloader">
					<div class="spinner"></div>
					<div class="txt-loading">
						<?php if (empty($tickerLetters)): ?>
							<span data-text-preloader="<?= esc(mb_strtoupper($siteLogoAlt[0] ?? 'C')) ?>" class="letters-loading">
								<?= esc(mb_strtolower($siteLogoAlt[0] ?? 'C')) ?>
							</span>
						<?php else: ?>
							<?php foreach ($tickerLetters as $letter): ?>
								<?php $upper = mb_strtoupper($letter); ?>
								<span data-text-preloader="<?= esc($upper) ?>" class="letters-loading">
									<?= esc(mb_strtolower($letter)) ?>
								</span>
							<?php endforeach ?>
						<?php endif ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="page-wrapper">
		<header class="main-header main-header-one">
			<div class="main-header-one__top">
				<div class="auto-container">
					<div class="main-header-one__top-inner">
						<div class="main-header-one__top-left">
							<div class="logo-box-one">
								<a href="<?= base_url() ?>">
									<img src="<?= $siteLogo ?>" alt="<?= esc($siteLogoAlt) ?>" title="<?= esc($siteLogoAlt) ?>" style="max-width:100px;width:100%;height:auto;" />
								</a>
							</div>
						</div>
						<div class="main-header-one__top-middle">
							<div class="main-header__contact-info">
								<ul>
									<li>
										<div class="inner">
											<div class="icon-box">
												<span class="icon-globe-hemisphere"></span>
											</div>
											<div class="text-box">
												<p><?= esc($siteAddress) ?></p>
												<h4><?= esc($siteCity) ?></h4>
											</div>
										</div>
									</li>
									<li>
										<div class="inner">
											<div class="icon-box">
												<span class="icon-chat-circle"></span>
											</div>
											<div class="text-box">
												<p>Email</p>
												<h4><a href="mailto:<?= esc($siteEmail) ?>"><?= esc($siteEmail) ?></a></h4>
											</div>
										</div>
									</li>
									<li>
										<div class="inner">
											<div class="icon-box">
												<span class="icon-phone-call"></span>
											</div>
											<div class="text-box">
												<p>Telepon / WhatsApp</p>
												<h4><a href="tel:<?= preg_replace('/\D+/', '', $sitePhone) ?>"><?= esc($sitePhone) ?></a></h4>
											</div>
										</div>
									</li>
								</ul>
							</div>
						</div>
						<div class="main-header-one__top-right">
							<div class="main-header-one__top-right-inner">
								<div class="text-box">
									<h3><?= esc(app_setting('header_cta_text', 'Jadwalkan kunjungan ke gereja')) ?></h3>
								</div>
								<div class="btn-box">
									<a href="<?= base_url(app_setting('header_cta_link', 'contact')) ?>"><?= esc(app_setting('header_cta_button', 'Hubungi Kami')) ?></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="main-header-one__bottom">
				<div class="main-header-one__bottom-inner">
					<nav class="main-menu main-menu-one">
						<div class="main-menu__wrapper clearfix">
							<div class="container">
								<div class="main-menu__wrapper-inner">
									<div class="main-header-one__bottom-left">
										<div class="main-menu-box">
											<a href="#" class="mobile-nav__toggler">
												<i class="fa fa-bars"></i>
											</a>
											<ul class="main-menu__list">
												<li class="dropdown current">
													<a href="<?= base_url() ?>">Home</a>
												</li>
												<li class="dropdown">
													<a href="#">Profil</a>
													<ul>
														<li><a href="<?= base_url('about') ?>">Tentang Kami</a></li>
														<li><a href="<?= base_url('majelis') ?>">Struktur Majelis</a></li>
														<li><a href="<?= base_url('contact') ?>">Kontak</a></li>
													</ul>
												</li>
												<li class="dropdown">
													<a href="#">Berita</a>
													<ul>
														<li><a href="<?= base_url('news') ?>">Berita &amp; Renungan</a></li>
														<li><a href="<?= base_url('events') ?>">Agenda Kegiatan</a></li>
													</ul>
												</li>
												<li class="dropdown">
													<a href="#">Galeri</a>
													<ul>
														<li><a href="<?= base_url('gallery?type=photo') ?>">Foto</a></li>
														<li><a href="<?= base_url('gallery?type=video') ?>">Video</a></li>
													</ul>
												</li>
												<li><a href="<?= base_url('keuangan') ?>">Keuangan</a></li>
												<li><a href="<?= base_url('umkm') ?>">UMKM Jemaat</a></li>
												<li class="dropdown">
													<a href="#">Interaksi</a>
													<ul>
														<li><a href="<?= base_url('surveys') ?>">Survei Jemaat</a></li>
														<li><a href="<?= base_url('feedback') ?>">Masukan &amp; Saran</a></li>
														<li><a href="<?= base_url('guestbook') ?>">Buku Tamu</a></li>
													</ul>
												</li>
												<li><a href="<?= base_url('registration') ?>">Pendaftaran</a></li>
											</ul>
										</div>
									</div>
									<div class="main-header-one__bottom-right">
										<div class="btn-box2">
											<a href="<?= base_url('registration') ?>">Pendaftaran</a>
										</div>
										<div class="header-search-box">
											<a href="#" class="main-menu__search search-toggler icon-search"></a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</nav>
				</div>
			</div>
		</header>
		<div class="stricky-header stricky-header--one stricked-menu main-menu">
			<div class="sticky-header__content"></div>
		</div>
