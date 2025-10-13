<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title><?= esc($title ?? 'CMS Church || Responsive HTML 5 Template') ?></title>
	<meta name="description" content="CMS Church HTML 5 Template" />
	<link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('assets/images/favicons/apple-touch-icon.png') ?>" />
	<link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('assets/images/favicons/favicon-32x32.png') ?>" />
	<link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('assets/images/favicons/favicon-16x16.png') ?>" />
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
						<span data-text-preloader="I" class="letters-loading">i</span>
						<span data-text-preloader="K" class="letters-loading">k</span>
						<span data-text-preloader="A" class="letters-loading">a</span>
						<span data-text-preloader="S" class="letters-loading">s</span>
						<span data-text-preloader="M" class="letters-loading">m</span>
						<span data-text-preloader="E" class="letters-loading">e</span>
						<span data-text-preloader="D" class="letters-loading">d</span>
						<span data-text-preloader="I" class="letters-loading">i</span>
						<span data-text-preloader="A" class="letters-loading">a</span>
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
									<img src="<?= base_url('assets/images/resources/logo-1.png') ?>" alt="Awesome Logo" title="" />
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
												<p>The Strand, 14 sector Australia</p>
												<h4>Melbourne, Australia</h4>
											</div>
										</div>
									</li>
									<li>
										<div class="inner">
											<div class="icon-box">
												<span class="icon-chat-circle"></span>
											</div>
											<div class="text-box">
												<p>You may send an email</p>
												<h4><a href="mailto:info@example.com">info@example.com</a></h4>
											</div>
										</div>
									</li>
									<li>
										<div class="inner">
											<div class="icon-box">
												<span class="icon-phone-call"></span>
											</div>
											<div class="text-box">
												<p>Helpline and support</p>
												<h4><a href="tel:8857002451">88 57 00 24 51</a></h4>
											</div>
										</div>
									</li>
								</ul>
							</div>
						</div>
						<div class="main-header-one__top-right">
							<div class="main-header-one__top-right-inner">
								<div class="text-box">
									<h3>You can make a difference today!</h3>
								</div>
								<div class="btn-box">
									<a href="<?= base_url('donation.html') ?>">Donation</a>
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
												<li><a href="<?= base_url('about.html') ?>">About</a></li>
												<li class="dropdown">
													<a href="#">Donations</a>
													<ul>
														<li><a href="<?= base_url('donation.html') ?>">Donation</a></li>
														<li><a href="<?= base_url('donation-list.html') ?>">Donation List</a></li>
														<li><a href="<?= base_url('donation-single.html') ?>">Donation Details</a></li>
													</ul>
												</li>
												<li class="dropdown">
													<a href="#">Events</a>
													<ul>
														<li><a href="<?= base_url('events.html') ?>">Events</a></li>
														<li><a href="<?= base_url('events-single.html') ?>">Events Details</a></li>
													</ul>
												</li>
												<li class="dropdown">
													<a href="#">Pages</a>
													<ul>
														<li><a href="<?= base_url('volunteers.html') ?>">Volunteers 01</a></li>
														<li><a href="<?= base_url('become-volunteer.html') ?>">Volunteer 02</a></li>
														<li><a href="<?= base_url('portfolio.html') ?>">Portfolio</a></li>
														<li><a href="<?= base_url('faq.html') ?>">Faq</a></li>
														<li><a href="<?= base_url('shop.html') ?>">Shop</a></li>
														<li><a href="<?= base_url('shop-details.html') ?>">Shop Details</a></li>
														<li><a href="<?= base_url('cart.html') ?>">Cart</a></li>
														<li><a href="<?= base_url('checkout.html') ?>">Checkout</a></li>
														<li><a href="<?= base_url('404.html') ?>">404</a></li>
													</ul>
												</li>
												<li class="dropdown">
													<a href="#">Blog</a>
													<ul>
														<li><a href="<?= base_url('blog.html') ?>">Blog</a></li>
														<li><a href="<?= base_url('blog-list.html') ?>">Blog List</a></li>
														<li><a href="<?= base_url('blog-details.html') ?>">Blog Details</a></li>
													</ul>
												</li>
												<li><a href="<?= base_url('contact.html') ?>">Contact</a></li>
											</ul>
										</div>
									</div>
									<div class="main-header-one__bottom-right">
										<div class="btn-box1">
											<a href="<?= base_url('contact.html') ?>">Join us now </a>
										</div>
										<div class="btn-box2">
											<a href="<?= base_url('volunteers.html') ?>">Become a Volunteer</a>
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
