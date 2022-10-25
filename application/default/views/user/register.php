<div class="breadcrumb-section">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="page-title">
					<h2 class="py-2">Đăng ký tài khoản</h2>
				</div>
			</div>
		</div>
	</div>
</div>
<?= @$this->errors ?>
<section class="register-page section-b-space">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h3>Đăng ký tài khoản</h3>
				<div class="theme-card">
					<form action="" method="post" id="admin-form" class="theme-form">
						<div class="form-row">
							<div class="col-md-6">
								<label for="username" class="required">Tên tài khoản</label>
								<input type="text" id="form[username]" name="form[username]" value="" class="form-control">
							</div>
							<div class="col-md-6">
								<label for="fullname">Họ và tên</label>
								<input type="text" id="form[fullname]" name="form[fullname]" value="" class="form-control">
							</div>
							<div class="col-md-6">
								<label for="email" class="required">Email</label>
								<input type="email" id="form[email]" name="form[email]" value="" class="form-control">
							</div>
							<div class="col-md-6">
								<label for="telephone" class="required">Số điện thoại</label>
								<input type="telephone" id="form[telephone]" name="form[telephone]" value="" class="form-control">
							</div>
							<div class="col-md-6">
								<label for="address" class="required">Địa chỉ</label>
								<input type="address" id="form[address]" name="form[address]" value="" class="form-control">
							</div>
							<div class="col-md-6">
								<label for="password" class="required">Mật khẩu</label>
								<input type="password" id="form[password]" name="form[password]" value="" class="form-control">
							</div>
						</div>
						<input type="hidden" id="form[token]" name="form[token]" value="1599208957">
						<button type="submit" id="submit" name="form[submit]" value="Tạo tài khoản" class="btn btn-solid">Tạo tài khoản</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>

<div class="phonering-alo-phone phonering-alo-green phonering-alo-show" id="phonering-alo-phoneIcon">
	<div class="phonering-alo-ph-circle"></div>
	<div class="phonering-alo-ph-circle-fill"></div>
	<a href="tel:0905744470" class="pps-btn-img" title="Liên hệ">
		<div class="phonering-alo-ph-img-circle"></div>
	</a>
</div>