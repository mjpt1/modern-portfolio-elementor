<?php
/**
 * Default portfolio content (FA + EN) — used when options are empty.
 *
 * @package HelloChildMJ
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Full default settings tree.
 *
 * @return array
 */
function mj_default_settings() {
	return array(
		'brand'        => array(
			'owner_name_fa'  => 'محسن جباره اصل',
			'owner_name_en'  => 'Mohsen Jabbarehasl',
			'meta_title_fa'  => 'محسن جباره اصل | نمونه‌کار',
			'meta_title_en'  => 'Mohsen Jabbarehasl | Portfolio',
			'meta_desc_fa'   => 'محسن جباره اصل، توسعه‌دهنده فول‌استک وب با بیش از ۱۰ سال تجربه.',
			'meta_desc_en'   => 'Mohsen Jabbarehasl is a Full-stack web developer with 10+ years of experience.',
			'default_locale' => 'fa',
			'avatar_id'      => 0,
		),
		'socials'      => array(
			'youtube'   => 'https://youtube.com',
			'instagram' => 'https://instagram.com',
			'facebook'  => 'https://facebook.com',
			'dribbble'  => 'https://dribbble.com',
			'pinterest' => 'https://pinterest.com',
			'github'    => 'https://github.com',
		),
		'home'         => array(
			'title_line1_fa'  => 'ایده‌ها را',
			'title_line1_en'  => 'Transforming Ideas',
			'title_line2_fa'  => 'به',
			'title_line2_en'  => 'Into',
			'title_accent_fa' => 'واقعیت دیجیتال',
			'title_accent_en' => 'Digital Reality',
			'subtitle_fa'     => 'طراحی و توسعه وب با تمرکز بر تجربه کاربری، عملکرد و جزئیات بصری. از ایده اولیه تا محصول نهایی، کنار شما هستم تا چیزی ماندگار بسازیم.',
			'subtitle_en'     => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Voluptate, exercitationem harum, quia nulla temporibus deleniti libero veniam vero beatae numquam ducimus illum ab similique ipsam tempore fugit quod laudantium debitis.',
		),
		'about'        => array(
			'heading_fa'            => 'داستان‌های',
			'heading_en'            => 'Captivating',
			'heading_accent_fa'     => 'جذاب',
			'heading_accent_en'     => 'stories',
			'heading_suffix_fa'     => 'طراحی‌های باشکوه می‌سازند.',
			'heading_suffix_en'     => 'birth magnificent designs.',
			'subtitle_fa'           => '۱۰ سال پیش به‌صورت فریلنسری برنامه‌نویسی را شروع کردم. از آن زمان برای آژانس‌ها دورکار کرده‌ام، به استارتاپ‌ها مشاوره داده‌ام و در ساخت محصولات دیجیتال برای کسب‌وکارها و کاربران نهایی همکاری کرده‌ام.',
			'subtitle_en'           => '10 years ago, I begin freelancing as a developer. Since then, I\'ve done remote work for agencies, consulted for startups, and collabrated on digital products for business and consumer use.',
			'counter_exp'           => 10,
			'counter_clients'       => 250,
			'counter_projects'      => 650,
			'counter_awards'        => 8,
			'counter_exp_label_fa'  => 'سال تجربه',
			'counter_exp_label_en'  => 'Years of experience.',
			'counter_cli_label_fa'  => 'مشتری راضی',
			'counter_cli_label_en'  => 'Satisfied clients.',
			'counter_prj_label_fa'  => 'پروژه تکمیل‌شده',
			'counter_prj_label_en'  => 'Finished projects.',
			'counter_awd_label_fa'  => 'جایزه برنده',
			'counter_awd_label_en'  => 'Winning awards.',
			'tab_skills_fa'         => 'مهارت‌ها',
			'tab_skills_en'         => 'skills',
			'tab_awards_fa'         => 'جوایز',
			'tab_awards_en'         => 'awards',
			'tab_experience_fa'     => 'سوابق',
			'tab_experience_en'     => 'experience',
			'tab_credentials_fa'    => 'مدارک',
			'tab_credentials_en'    => 'credentials',
			'skills'                => array(
				array(
					'title_fa' => 'توسعه وب',
					'title_en' => 'Web Development',
					'icons'    => 'HTML,CSS,JS,React,Next,WP',
				),
				array(
					'title_fa' => 'طراحی UI/UX',
					'title_en' => 'UI/UX Design',
					'icons'    => 'Figma,XD,Ps',
				),
			),
			'awards'                => array(
				array(
					'title_fa' => 'جایزه Webby — نامزد افتخاری',
					'title_en' => 'Webby Awards - Honoree',
					'stage_fa' => '۱۳۹۰–۱۳۹۱',
					'stage_en' => '2011 - 2012',
				),
				array(
					'title_fa' => 'جایزه Adobe Design Achievement — فینالیست',
					'title_en' => 'Adobe Design Achievement Awards - Finalist',
					'stage_fa' => '۱۳۸۸–۱۳۸۹',
					'stage_en' => '2009 - 2010',
				),
			),
			'experience'            => array(
				array(
					'title_fa' => 'طراح UX/UI — شرکت XYZ',
					'title_en' => 'UX/UI Designer - XYZ Company',
					'stage_fa' => '۱۳۹۱–۱۴۰۲',
					'stage_en' => '2012 - 2023',
				),
				array(
					'title_fa' => 'توسعه‌دهنده وب — آژانس ABC',
					'title_en' => 'Web Developer - ABC Agency',
					'stage_fa' => '۱۳۸۹–۱۳۹۱',
					'stage_en' => '2010 - 2012',
				),
				array(
					'title_fa' => 'کارآموز — شرکت DEF',
					'title_en' => 'Intern - DEF Corporation',
					'stage_fa' => '۱۳۸۷–۱۳۸۹',
					'stage_en' => '2008 - 2010',
				),
			),
			'credentials'           => array(
				array(
					'title_fa' => 'توسعه وب — دانشگاه ABC، لس‌آنجلس',
					'title_en' => 'Web Development - ABC University, LA, CA',
					'stage_fa' => '۱۳۹۰',
					'stage_en' => '2011',
				),
				array(
					'title_fa' => 'دیپلم علوم کامپیوتر — مؤسسه AV',
					'title_en' => 'Computer Science Diploma - AV Technical Institute',
					'stage_fa' => '۱۳۸۸',
					'stage_en' => '2009',
				),
				array(
					'title_fa' => 'گواهی طراحی گرافیک — مؤسسه ABC، لس‌آنجلس',
					'title_en' => 'Certified Graphic Designer - ABC Institute, Los Angeles, CA',
					'stage_fa' => '۱۳۸۵',
					'stage_en' => '2006',
				),
			),
		),
		'services'     => array(
			'heading_fa'  => 'خدمات من',
			'heading_en'  => 'My services',
			'subtitle_fa' => 'از برندسازی تا توسعه و سئو؛ خدماتی یکپارچه برای رشد حضور دیجیتال شما.',
			'subtitle_en' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur tempora eligendi, quisquam tempore sint reiciendis.',
			'items'       => array(
				array(
					'icon'     => '✂',
					'title_fa' => 'برندسازی',
					'title_en' => 'Branding',
					'desc_fa'  => 'ساخت هویت بصری منسجم که برند شما را متمایز و به‌یادماندنی می‌کند.',
					'desc_en'  => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
				),
				array(
					'icon'     => '✎',
					'title_fa' => 'طراحی',
					'title_en' => 'Design',
					'desc_fa'  => 'رابط‌های کاربری زیبا و کاربردی با تمرکز بر تجربه و جزئیات.',
					'desc_en'  => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
				),
				array(
					'icon'     => '🖥',
					'title_fa' => 'توسعه',
					'title_en' => 'Development',
					'desc_fa'  => 'پیاده‌سازی سریع، پایدار و مقیاس‌پذیر با تکنولوژی‌های مدرن وب.',
					'desc_en'  => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
				),
				array(
					'icon'     => '📄',
					'title_fa' => 'نگارش محتوا',
					'title_en' => 'Copywriting',
					'desc_fa'  => 'متن‌هایی شفاف و تأثیرگذار که پیام برند را درست منتقل می‌کنند.',
					'desc_en'  => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
				),
				array(
					'icon'     => '🚀',
					'title_fa' => 'سئو',
					'title_en' => 'SEO',
					'desc_fa'  => 'بهینه‌سازی برای دیده‌شدن بهتر در موتورهای جست‌وجو و رشد ارگانیک.',
					'desc_en'  => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
				),
			),
		),
		'work'         => array(
			'heading_fa'    => 'نمونه‌کارها',
			'heading_en'    => 'My work',
			'subtitle_fa'   => 'نگاهی به پروژه‌های اخیر؛ از لندینگ‌پیج تا اپلیکیشن‌های وب.',
			'subtitle_en'   => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur tempora eligendi, quisquam tempore sint reiciendis.',
			'live_label_fa' => 'مشاهده',
			'live_label_en' => 'LIVE',
			'proj_label_fa' => 'پروژه',
			'proj_label_en' => 'PROJECT',
			'projects'      => array(
				array( 'image_id' => 0, 'image_file' => 'thumb1.jpg', 'url' => 'https://example.com', 'title_fa' => 'پروژه ۱', 'title_en' => 'Project 1' ),
				array( 'image_id' => 0, 'image_file' => 'thumb2.jpg', 'url' => 'https://example.com', 'title_fa' => 'پروژه ۲', 'title_en' => 'Project 2' ),
				array( 'image_id' => 0, 'image_file' => 'thumb3.jpg', 'url' => 'https://example.com', 'title_fa' => 'پروژه ۳', 'title_en' => 'Project 3' ),
				array( 'image_id' => 0, 'image_file' => 'thumb4.jpg', 'url' => 'https://example.com', 'title_fa' => 'پروژه ۴', 'title_en' => 'Project 4' ),
				array( 'image_id' => 0, 'image_file' => 'thumb4.jpg', 'url' => 'https://example.com', 'title_fa' => 'پروژه ۵', 'title_en' => 'Project 5' ),
				array( 'image_id' => 0, 'image_file' => 'thumb1.jpg', 'url' => 'https://example.com', 'title_fa' => 'پروژه ۶', 'title_en' => 'Project 6' ),
				array( 'image_id' => 0, 'image_file' => 'thumb2.jpg', 'url' => 'https://example.com', 'title_fa' => 'پروژه ۷', 'title_en' => 'Project 7' ),
				array( 'image_id' => 0, 'image_file' => 'thumb3.jpg', 'url' => 'https://example.com', 'title_fa' => 'پروژه ۸', 'title_en' => 'Project 8' ),
			),
		),
		'testimonials' => array(
			'heading_fa'        => 'نظر',
			'heading_en'        => 'What clients',
			'heading_accent_fa' => 'مشتریان',
			'heading_accent_en' => 'say.',
			'role_fa'           => 'مشتری',
			'role_en'           => 'Customer',
			'items'             => array(
				array(
					'image_id'   => 0,
					'image_file' => 't-avt-1.png',
					'name_fa'    => 'آنا اسمیت',
					'name_en'    => 'Anne Smith',
					'msg_fa'     => 'همکاری بسیار حرفه‌ای بود. تحویل به‌موقع، ارتباط شفاف و نتیجه‌ای فراتر از انتظار ما.',
					'msg_en'     => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum expedita odit beatae, cupiditate saepe quam officia aut placeat quas neque!',
				),
				array(
					'image_id'   => 0,
					'image_file' => 't-avt-2.png',
					'name_fa'    => 'جین دو',
					'name_en'    => 'Jane Doe',
					'msg_fa'     => 'طراحی و پیاده‌سازی عالی. تیم ما از کیفیت کار و توجه به جزئیات کاملاً راضی بود.',
					'msg_en'     => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum expedita odit beatae, cupiditate saepe quam officia aut placeat quas neque!',
				),
				array(
					'image_id'   => 0,
					'image_file' => 't-avt-3.png',
					'name_fa'    => 'جان دو',
					'name_en'    => 'Jhon Doe',
					'msg_fa'     => 'فرآیند همکاری روان و خروجی نهایی دقیقاً همان چیزی بود که می‌خواستیم.',
					'msg_en'     => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum expedita odit beatae, cupiditate saepe quam officia aut placeat quas neque!',
				),
			),
		),
		'contact'      => array(
			'heading_fa'        => 'بیایید',
			'heading_en'        => "Let's",
			'heading_accent_fa' => 'در ارتباط باشیم',
			'heading_accent_en' => 'connect.',
			'name_ph_fa'        => 'نام',
			'name_ph_en'        => 'Name',
			'email_ph_fa'       => 'ایمیل',
			'email_ph_en'       => 'E-mail',
			'subject_ph_fa'     => 'موضوع',
			'subject_ph_en'     => 'Subject',
			'message_ph_fa'     => 'پیام...',
			'message_ph_en'     => 'Message...',
			'submit_fa'         => 'ارسال پیام',
			'submit_en'         => "Let's talk",
			'note_fa'           => 'فرم دمو: برای ارسال واقعی از Contact Form 7 / WPForms / Elementor Form استفاده کنید.',
			'note_en'           => 'Demo form: For real submissions use Contact Form 7 / WPForms / Elementor Form.',
		),
		'nav'          => array(
			'home_fa'         => 'خانه',
			'home_en'         => 'home',
			'about_fa'        => 'درباره من',
			'about_en'        => 'about',
			'services_fa'     => 'خدمات',
			'services_en'     => 'services',
			'work_fa'         => 'نمونه‌کارها',
			'work_en'         => 'work',
			'testimonials_fa' => 'نظرات',
			'testimonials_en' => 'testimonials',
			'contact_fa'      => 'تماس',
			'contact_en'      => 'contact',
		),
	);
}
