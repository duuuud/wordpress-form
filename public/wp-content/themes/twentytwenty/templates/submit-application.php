<?php

/**
 * Template Name: Submit Application
 * Template Post Type: post, page
 *
 */

include (get_template_directory() . '/template-parts/form-submit-validation.php');

get_header('submit');
?>

<main id="site-content">

	<?php

	if (have_posts()) {

		while (have_posts()) {

			$getJsonData = file_get_contents(__DIR__ . '/countries.json');
			$jsonData = json_decode($getJsonData, true);
			
	?>

			<div id="container" class="container">
					<?php the_post() ?>
						<div id="post-<?php the_ID() ?>" class="post">
						<h1 class="title">SUBMIT YOUR APPLICATION</h1>
						<div class="entry-content">
							<h2 class="form-title">Personal Information</h2>
							<?php	
								include (get_template_directory() . '/template-parts/form-submit-error.php');
							?>
							<form action="<?php the_permalink(); ?>" id="submitForm" method="post">
								
								<p class="form-content">Please fill in all mandatory fields</p>

								<ul class="fields-content">
									<li>
										<label for="fName" class="<?php if($has_fName) echo 'active-label' ?>" >*First Name</label>
										<input type="text" name="fName" id="fName" value="<?php if($has_fName) echo $_POST['fName'];?>" />
										<?php if($fNameError != '') { ?>
											<span class="error"><?=$fNameError;?></span>
										<?php } ?>
									</li>
									<li>
										<label for="lName" class="<?php if($has_lName) echo 'active-label' ?>">*Last Name</label>
										<input type="text" name="lName" id="lName" value="<?php if($has_lName) echo $_POST['lName'];?>" />
										<?php if($lNameError != '') { ?>
											<span class="error"><?=$lNameError;?></span>
										<?php } ?>
									</li>
									<li>
										<label for="email" class="<?php if($has_email) echo 'active-label' ?>">*Email</label>
										<input type="text" name="email" id="email" value="<?php if($has_email) echo $_POST['email'];?>" />
										<?php if($emailError != '') { ?>
											<span class="error"><?=$emailError;?></span>
										<?php } ?>
									</li>
									<li>
										<label for="phoneNumber" class="<?php if($has_phoneNumber) echo 'active-label' ?>">*Phone Number</label>
										<input type="tel" name="phoneNumber" id="phoneNumber" value="<?php if($has_phoneNumber) echo $_POST['phoneNumber'];?>" />
										<?php if($phoneNumberError != '') { ?>
											<span class="error"><?=$phoneNumberError;?></span>
										<?php } ?>
									</li>
									<li>
										<select name="chooseCountry" id="chooseCountry">
											<option value="-1">*Choose Country</option>
											<?php foreach($jsonData as $key=>$value): ?>
												<option value="<?=$value['code'] ?>" <?php if($has_chooseCountry && $_POST['chooseCountry'] === $value['code']){ echo 'selected=selected'; }  ?>><?= $value['name'] ?></option>
											<?php endforeach; ?>
										</select>
										<?php if($chooseCountryError != '') { ?>
											<span class="error"><?=$chooseCountryError;?></span>
										<?php } ?>
									</li>
									<li>
										<label for="birthDate" class="<?php if($has_birthDate) echo 'active-label' ?>">*Date of Birth</label>
										<input type="text" name="birthDate" id="birthDate" value="<?php if($has_birthDate) echo $_POST['birthDate'];?>" />
										<?php if($birthDateError != '') { ?>
											<span class="error"><?=$birthDateError;?></span>
										<?php } ?>
									</li>
								</ul>
								<div class="agree">
									<input type="checkbox" name="agree" id="agree" value="1">
									<label for="agree">
											I have read and agree to the <a href="#">Terms and Conditions</a> and the <a href="#">Privacy Policy</a>
									</label>
								</div>
								
								<div class="submit-zone">
									<button type="submit" class="btn">SUBMIT ></button>
								</div>
								<input type="hidden" name="submitted" id="submitted" value="true" />
							</form>
							<img src="<?= bloginfo('template_url') . '/assets/images/image.svg' ?>" alt="" class="decore">
						</div>
					</div>	
			</div>
	<?php
		}
	}
	?>
</main>


<?php get_footer('submit'); ?>