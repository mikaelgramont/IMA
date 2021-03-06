<?php
class Footer
{
	public static function renderFooter($color = '#1A1705')
	{
		$logout = Auth::hasAuth() ? "<a href=\"". BASE_URL . "do-logout\">Logout</a>" : "";

    $privacyPolicyUrl = BASE_URL.'privacy-policy';

		$date = date('Y');
		return <<<HTML
		<footer class="footer">
			<p>Find us on social media :</p>
			<ul class="footer-social-media-links">
				<li class="footer-social-media-link">
					<a href="https://www.facebook.com/imountainboard/">
						<svg width="100%" height="100%" viewBox="0 0 100 100" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:1.41421;">
						  <path d="M50,2c26.492,0 48,21.508 48,48c0,26.492 -21.508,48 -48,48c-26.492,0 -48,-21.508 -48,-48c0,-26.492 21.508,-48 48,-48Zm16.334,23.5l-32.667,0c-4.492,0 -8.167,3.676 -8.167,8.168l0,32.664c0,4.495 3.675,8.168 8.167,8.168l32.666,0c4.493,0.001 8.167,-3.672 8.167,-8.167l0,-32.664c0,-4.492 -3.674,-8.168 -8.166,-8.169Zm1.999,10.65l-6.849,0c-2.034,-0.003 -2.285,1.06 -2.285,3.039l-0.012,3.797l9.188,0l-1.215,7.014l0,0l-7.972,0l0,21.438l-9.188,-0.001l0,-21.437l-4.427,0l0,-7.014l4.427,0.001l0,-4.555c0,-6.189 2.67,-9.87 9.947,-9.87l8.386,0l0,7.588Z" style="fill:#1A1705;"></path>
						</svg>
					</a>
				</li>
				<li class="footer-social-media-link">
					<a href="https://www.instagram.com/imountainboard/">
						<svg width="100%" height="100%" viewBox="0 0 100 100" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:1.41421;">
						  <path d="M50,2c26.492,0 48,21.508 48,48c0,26.492 -21.508,48 -48,48c-26.492,0 -48,-21.508 -48,-48c0,-26.492 21.508,-48 48,-48Zm19.1,23.5l-38.2,0c-2.975,0 -5.387,2.414 -5.387,5.39l0,38.22c0,2.977 2.412,5.39 5.387,5.39l38.2,0c2.975,0 5.387,-2.413 5.387,-5.39l0,-38.219c0,-2.977 -2.412,-5.391 -5.387,-5.391Zm-2.302,43.267l-33.627,0c-1.082,0 -1.959,-0.877 -1.959,-1.959l0,-20.53l4.254,0c-0.294,1.175 -0.452,2.403 -0.452,3.67c0,8.306 6.73,15.039 15.032,15.039c8.302,0 15.031,-6.733 15.031,-15.04c0,-1.266 -0.157,-2.495 -0.452,-3.669l4.132,-0.001l-0.001,20.531c0.001,1.082 -0.876,1.959 -1.958,1.959Zm-16.825,-28.175c5.178,0 9.376,4.2 9.376,9.381c0,5.181 -4.198,9.38 -9.376,9.38c-5.178,0 -9.376,-4.2 -9.376,-9.38c0,-5.18 4.197,-9.381 9.376,-9.381Zm16.95,-0.07l-5.562,0c-1.082,0 -1.958,-0.878 -1.958,-1.96l0,-5.565c0,-1.083 0.877,-1.96 1.958,-1.96l5.562,0c1.083,0 1.959,0.878 1.959,1.96l0,5.565c0,1.082 -0.877,1.959 -1.959,1.96Z" style="fill:#1A1705;"></path>
						</svg>
					</a>
				</li>
				<li class="footer-social-media-link">
					<a href="https://www.youtube.com/channel/UCXb-N1ZzF1QhULPw0k_LknA/playlists">
						<svg width="100%" height="100%" viewBox="0 0 100 100" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:1.41421;">
						  <path d="M50,2c26.492,0 48,21.508 48,48c0,26.492 -21.508,48 -48,48c-26.492,0 -48,-21.508 -48,-48c0,-26.492 21.508,-48 48,-48Zm23.642,36.18c-0.5,-2.676 -2.728,-4.673 -5.287,-4.92c-6.11,-0.392 -12.244,-0.71 -18.365,-0.714c-6.122,-0.003 -12.232,0.308 -18.344,0.694c-2.568,0.248 -4.796,2.235 -5.294,4.921c-0.568,3.868 -0.852,7.773 -0.852,11.678c0,3.904 0.284,7.81 0.852,11.678c0.498,2.686 2.725,4.911 5.294,5.157c6.113,0.386 12.22,0.78 18.344,0.78c6.119,0 12.257,-0.344 18.365,-0.739c2.559,-0.249 4.787,-2.54 5.287,-5.214c0.573,-3.862 0.858,-7.762 0.858,-11.663c0,-3.898 -0.286,-7.796 -0.858,-11.658Zm-29.197,18.694l0,-14.238l13.26,7.119l-13.26,7.119Z" style="fill:#1A1705;"></path>
						</svg>
					</a>
				</li>
			</ul>
			<p class="small">IMA {$date}</p>
			<p><a href="$privacyPolicyUrl">Privacy policy</a></p>
			{$logout}
		</footer>
HTML;
	}

	public static function renderWfcFooter($color)
	{
		$logout = Auth::hasAuth() ? "<a href=\"". BASE_URL . "do-logout\">Logout</a>" : "";

		$fbUrl = FB_EVENT_URL;
		$ytUrl = YOUTUBE_URL;
		$igUrl = INSTAGRAM_URL;

		$date = date('Y');
		return <<<HTML
		<hr class="footer-separator" />
		
		<footer class="footer">
			<p>The 2019 WFC on social media :</p>
			<ul class="footer-social-media-links">
				<li class="footer-social-media-link">
					<a href="{$fbUrl}">
						<svg width="100%" height="100%" viewBox="0 0 100 100" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:1.41421;">
						  <path d="M50,2c26.492,0 48,21.508 48,48c0,26.492 -21.508,48 -48,48c-26.492,0 -48,-21.508 -48,-48c0,-26.492 21.508,-48 48,-48Zm16.334,23.5l-32.667,0c-4.492,0 -8.167,3.676 -8.167,8.168l0,32.664c0,4.495 3.675,8.168 8.167,8.168l32.666,0c4.493,0.001 8.167,-3.672 8.167,-8.167l0,-32.664c0,-4.492 -3.674,-8.168 -8.166,-8.169Zm1.999,10.65l-6.849,0c-2.034,-0.003 -2.285,1.06 -2.285,3.039l-0.012,3.797l9.188,0l-1.215,7.014l0,0l-7.972,0l0,21.438l-9.188,-0.001l0,-21.437l-4.427,0l0,-7.014l4.427,0.001l0,-4.555c0,-6.189 2.67,-9.87 9.947,-9.87l8.386,0l0,7.588Z" style="fill:{$color};"></path>
						</svg>
					</a>
				</li>
				<li class="footer-social-media-link">
					<a href="{$igUrl}">
						<svg width="100%" height="100%" viewBox="0 0 100 100" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:1.41421;">
						  <path d="M50,2c26.492,0 48,21.508 48,48c0,26.492 -21.508,48 -48,48c-26.492,0 -48,-21.508 -48,-48c0,-26.492 21.508,-48 48,-48Zm19.1,23.5l-38.2,0c-2.975,0 -5.387,2.414 -5.387,5.39l0,38.22c0,2.977 2.412,5.39 5.387,5.39l38.2,0c2.975,0 5.387,-2.413 5.387,-5.39l0,-38.219c0,-2.977 -2.412,-5.391 -5.387,-5.391Zm-2.302,43.267l-33.627,0c-1.082,0 -1.959,-0.877 -1.959,-1.959l0,-20.53l4.254,0c-0.294,1.175 -0.452,2.403 -0.452,3.67c0,8.306 6.73,15.039 15.032,15.039c8.302,0 15.031,-6.733 15.031,-15.04c0,-1.266 -0.157,-2.495 -0.452,-3.669l4.132,-0.001l-0.001,20.531c0.001,1.082 -0.876,1.959 -1.958,1.959Zm-16.825,-28.175c5.178,0 9.376,4.2 9.376,9.381c0,5.181 -4.198,9.38 -9.376,9.38c-5.178,0 -9.376,-4.2 -9.376,-9.38c0,-5.18 4.197,-9.381 9.376,-9.381Zm16.95,-0.07l-5.562,0c-1.082,0 -1.958,-0.878 -1.958,-1.96l0,-5.565c0,-1.083 0.877,-1.96 1.958,-1.96l5.562,0c1.083,0 1.959,0.878 1.959,1.96l0,5.565c0,1.082 -0.877,1.959 -1.959,1.96Z" style="fill:{$color};"></path>
						</svg>
					</a>
				</li>
				<li class="footer-social-media-link">
					<a href="{$ytUrl}">
						<svg width="100%" height="100%" viewBox="0 0 100 100" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:1.41421;">
						  <path d="M50,2c26.492,0 48,21.508 48,48c0,26.492 -21.508,48 -48,48c-26.492,0 -48,-21.508 -48,-48c0,-26.492 21.508,-48 48,-48Zm23.642,36.18c-0.5,-2.676 -2.728,-4.673 -5.287,-4.92c-6.11,-0.392 -12.244,-0.71 -18.365,-0.714c-6.122,-0.003 -12.232,0.308 -18.344,0.694c-2.568,0.248 -4.796,2.235 -5.294,4.921c-0.568,3.868 -0.852,7.773 -0.852,11.678c0,3.904 0.284,7.81 0.852,11.678c0.498,2.686 2.725,4.911 5.294,5.157c6.113,0.386 12.22,0.78 18.344,0.78c6.119,0 12.257,-0.344 18.365,-0.739c2.559,-0.249 4.787,-2.54 5.287,-5.214c0.573,-3.862 0.858,-7.762 0.858,-11.663c0,-3.898 -0.286,-7.796 -0.858,-11.658Zm-29.197,18.694l0,-14.238l13.26,7.119l-13.26,7.119Z" style="fill:{$color};"></path>
						</svg>
					</a>
				</li>
			</ul>
			<p class="small">IMA {$date}</p>
			{$logout}
		</footer>
HTML;
	}
}