	<div class="logo"><img src="{$admin_url}assets/img/login-logo.png"/></div>
	<div class="row text-center"><h3>CRM Portal</h3></div>
	<!-- start: LOGIN BOX -->
	<div class="box-login">
		<h3>Sign in to your account</h3>
		<p>Please enter your username and password to log in.</p>
		<div id="form-error" class="alert alert-danger no-display" style="position:absolute;top:155px;left:15px;z-index:10;width:93.5%;">
			<i class="fa fa-remove-sign"></i>
		</div>
		<form id="login-form" class="form-login">
			<fieldset>
				<div class="form-group">
					<span class="input-icon">
						<input type="text" class="form-control" name="uname" id="uname" placeholder="Username">
						<i class="fa fa-user"></i> </span>
				</div>
				<div class="form-group form-actions">
					<span class="input-icon">
						<input type="password" class="form-control password" id="passwd" name="passwd" placeholder="Password">
						<i class="fa fa-lock"></i>
						<!--<a class="forgot" href="#" data-toggle="modal" data-target="#forgot-modal">I forgot my password</a>-->
					</span>
				</div>
				<div class="form-actions">
					<button id="login-button" type="button" class="btn btn-bricky pull-right">
						Login <i class="fa fa-arrow-circle-right"></i>
					</button>
				</div>
			</fieldset>
		</form>
	</div>
	<!-- end: LOGIN BOX -->
	<!-- start: FORGOT BOX -->
	<div id="forgot-modal" class="modal fade box-forgot">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Forget Password?</h4>
				</div>
				<div class="modal-body">
					<div id="forgot-alert" class="alert alert-danger no-display" style="position:absolute;top:15px;z-index:10;width:93.5%;">
						<i class="fa fa-remove-sign"></i> Invalid Email Address.
					</div>
					<p>Enter your e-mail address below to reset your password.</p>
					<fieldset>
						<div class="form-group">
							<span class="input-icon">
								<input type="email" class="form-control" name="email" id="reset-email" placeholder="Email">
								<i class="fa fa-envelope"></i>
							</span>
						</div>
					</fieldset>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban"></i> Close</button>
					<button type="button" class="btn btn-primary" id="reset-passwd-btn"><i class="fa fa-arrow-circle-right"></i> Send</button>
				</div>
			</div>
		</div>
	</div>
	<!-- end: FORGOT BOX -->
	<!-- start: COPYRIGHT -->
	<div class="copyright">
		{date('Y')} &copy; Powered By KanaiTek, Inc.
	</div>
	<!-- end: COPYRIGHT -->