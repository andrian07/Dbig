<?php
// get json file
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://cdn01.rumahweb.com/under-construction/panduan.json");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$links = json_decode(curl_exec($ch));
curl_close($ch);
?>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">	
<title>Selamat, website <?php echo $_SERVER['HTTP_HOST'];?> telah aktif!</title>
<meta name="description" content="Gerbang Anda untuk mendunia telah terbuka. Segera buat website dan email <?php echo $_SERVER['HTTP_HOST'];?> dan mulai perjalanan bisnis Anda.">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;800&display=swap" rel="stylesheet">
<link href="https://cdn01.rumahweb.com/under-construction/style.css" rel="stylesheet">
</head>
<body>
	<div style="background: #014CA0;color:#fff;padding:10px;">
		<div class="container text-center" style="font-size:14px;font-weight:600;line-height: 20px;">Silahkan hapus file <b>index.php</b> dan gantikan dengan file website Anda untuk menghapus halaman ini.</div>
	</div>
	<section class="hero">
		<div style="background-image:url('https://cdn01.rumahweb.com/under-construction/img/dot.png');background-repeat:no-repeat;margin: -60px 0;padding: 60px 0;background-position: 30px 50px;">
			<div class="container">
				<div class="row">
					<div class="col-md-7">
						<p class="top1">Gerbang Anda untuk mendunia telah terbuka</p>
						<p class="top2"><b style="color: #FFC546;"><?php echo ucfirst($_SERVER['HTTP_HOST']);?></b><br>sudah aktif</p>
						<p class="top3">Segera bangun website, buat akun email, dan mulai mendapatkan peluang dan kemungkinan baru. <b>#thinkbig</b> <b>#growbigger</b></p>
					</div>
					<div class="col-md-5"><img src="https://cdn01.rumahweb.com/under-construction/img/hero.png" alt="<?php echo ucfirst($_SERVER['HTTP_HOST']);?> sudah aktif" width="400"></div>
				</div>
			</div>
		</div>
	</section>
	<section class="steps" style="padding: 80px 0;">
		<div class="container">
			<h2 class="text-center" style="font-size:36px; font-weight:600;color:#0D145A;line-height:50px;margin-bottom: 40px;">Yuk, Segera Manfaatkan Akun Hosting Anda</h2>
			<div class="row">
				<div class="col-md-4 col-sm-12">
					<div class="box step1">
				      	<h4>Buat Akun Email</h4>
				      	<p>Buat email nama@domainku.xyz untuk berkomunikasi dengan lebih profesional.</p>
				      	<ul>
									<?php
									foreach ($links->email as $email){
										echo '<li><a href="'.$email->url.'" title="'.$email->title.'">'.$email->title.'</a></li>';
									}
									?>
				      	</ul>
			      	</div>
			    </div>
			    <div class="col-md-4 col-sm-12">
			    	<div class="box step2">
				      	<h4>Buat Website</h4>
				      	<p>Ikuti tutorial dibawah ini untuk membuat website sendiri dengan mudah:</p>
				      	<ul>
									<?php
									foreach ($links->website as $website){
										echo '<li><a href="'.$website->url.'" title="'.$website->title.'">'.$website->title.'</a></li>';
									}
									?>
				      	</ul>
			      	</div>
			    </div>
			    <div class="col-md-4 col-sm-12">
			    	<div class="box step3">
				      	<h4>Daftar ke Google</h4>
				      	<p>Daftarkan website baru Anda ke Google agar dapat ditemukan di internet dengan mudah.</p>
				      	<ul>
									<?php
									foreach ($links->seo as $seo){
										echo '<li><a href="'.$seo->url.'" title="'.$seo->title.'">'.$seo->title.'</a></li>';
									}
									?>
				      	</ul>
			      	</div>
			    </div>
			</div>
		</div>
	</section>
	<section class="bantuan">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<h3 style="font-size: 48px;line-height:65px;color: #0D145A;margin-top: 40px;font-weight: 600;">Anda Butuh Bantuan?</h3>
					<p style="font-size: 24px;line-height: 36px;color:#8689AC;font-weight: 200;">Jangan pernah ragu untuk menghubungi kami. Orang Rumah akan selalu ada kapanpun (24 x 7) Anda membutuhkan bantuan untuk menggunakan akun hosting ini.</p>
				</div>
				<div class="col-md-6 text-center"><img src="https://cdn01.rumahweb.com/under-construction/img/bantuan.png" alt="Anda butuh bantuan?" class="img-responsive"></div>
			</div>
			&nbsp;
			<div class="row" style="margin-top:40px">
				<div class="col">
					<p><img src="https://cdn01.rumahweb.com/under-construction/img/livechat.svg"></p>
					<h4>LiveChat</h4>
					<p>Cara paling cepat dan efektif untuk mendapatkan bantuan.</p>
					<p><a href="#livechat" class="btn btn-md btn-orange livechat">Livechat</a></p>
				</div>
				<div class="col">
					<p><img src="https://cdn01.rumahweb.com/under-construction/img/email.svg"></p>
					<h4>Email &amp; Trouble Ticket</h4>
					<p>Direkomendasikan untuk kendala yang penyelesaiannya membutuhkan waktu.<br><b>Paling recommended!</b></p>
					<p><b>Sales &amp; Informasi Umum:</b><br><a href="mailto:info@rumahweb.com" title="Kirim email ke info@rumahweb.com">info@rumahweb.com</a></p>
					<p><b>Teknis:</b><br><a href="mailto:teknis@rumahweb.com" title="Kirim email ke teknis@rumahweb.com">teknis@rumahweb.com</a></p>
					<p><b>Billing:</b><br><a href="mailto:billing@rumahweb.com" title="Kirim email ke billing@rumahweb.com">billing@rumahweb.com</a></p>
					<p><b>Abuse &amp; Pelanggaran:</b><br><a href="mailto:abuse@rumahweb.com" title="Kirim email ke abuse@rumahweb.com">abuse@rumahweb.com</a></p>
				</div>
				<div class="col">
					<p><img src="https://cdn01.rumahweb.com/under-construction/img/telepon.svg"></p>
					<h4>Telepon</h4>
					<p>Anda juga dapat menghubungi kami melalui telepon 24 x 7.</p>

					<p><b>Telepon:</b><br><a href="tel:+62-274-882257" title="Ketuk untuk menelepon 0274-882257 (hunting)">0274-882257 (hunting)</a></p>
					<p><b>Telkomsel:</b><br><a href="tel:+62-822-4222-0053" title="Ketuk untuk menelepon 0822 4222 0053">0822 4222 0053</a></p>
					<p><b>Indosat:</b><br><a href="tel:+62-857-013-95-353" title="Ketuk untuk menelepon 0857 013 95 353">0857 013 95 353</a></p>
					<p><b>XL:</b><br><a href="tel:+62-877-051-20-303" title="Ketuk untuk menelepon 0877 051 20 303">0877 051 20 303</a></p>
				</div>
			</div>
		</div>
	</section>
	<footer>
		<div class="container">
		<p class="text-center" style="font-size:24px;line-height: 32px;color: #0D145A;margin:80px 0 30px 0">Hosting powered by <a href="https://www.rumahweb.com" style="font-weight: 800;color:#0D145A;text-decoration: none;">Rumahweb Indonesia</a></p>
	</div>
	</footer>
</div>
</body>
    <script type="text/javascript" src="https://chat.rumahweb.com/js/resource.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
    <script>
    $(document).ready(function(){
        $(document).on('click', '.livechat', function(x) {
            if($('.rwlivechat-area').css('display') == 'none'){
                document.getElementById("rwlivechat-check").checked = true;
            }
            else{
                document.getElementById("rwlivechat-check").checked = false;
            }
            $('.livechatbanner').hide();
            $('.livechat-btn').show();
            x.preventDefault();
        });
    });
    </script>
</html>
