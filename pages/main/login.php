<?php
	// The actual redirect takes place in index.php
	$redirect = isset($_REQUEST['redirect-after-login']) ? $_REQUEST['redirect-after-login'] : BASE_URL . "admin";
	$error = isset($_REQUEST['error']) ? $_REQUEST['error'] : "";
?>
<style>
	.login-form {
		display: flex;
		flex-direction: column;
		margin: 4em auto;
		width: 320px;
		padding: 2em;
		background: #d8d8d8;
	}	
	.row {
		display: flex;
		margin: 1em 0;
	}
	.row:last-child {
		margin-bottom: 0;
	}
	.row-label {
		display: inline-block;
		margin-right: 1em;
		width: 80px;
	}
	.text-input {
		flex: 1 0;
	}
	.submit-row {
		flex-direction: row-reverse; 
	}
	.button {
		display: inline-block;
    	margin: .25em;
		color: #fff;
		background: #E82020;
		border: 2px solid #C80000;
		font-size: 1em;		
	}
	.message-wrapper {
		color: #f00;
		font-size: 1.25em;
	}
</style>

<form class="login-form" action="<?php echo BASE_URL ?>do-login" method="POST">
	<?php
		if ($error) {
	?>
	<div class="message-wrapper"><?php echo $error ?></div>
	<?php
		}
	?>
	<div class="row">
		<label for="email" class="row-label">Email</label>
		<input class="text-input" type="text" id="email" name="email" />
	</div>
	<div class="row">
		<label for="password" class="row-label">Password</label>
		<input class="text-input" type="password" id="password" name="password" />
	</div>
	<div class="row submit-row">
		<input class="button" type="submit" name="submit" value="Login" />
	</div>
	<?php if ($redirect) { ?>
		<input type="hidden" value="<?php echo $redirect ?>" name="redirect-after-login" />
	<?php } ?>
</form>