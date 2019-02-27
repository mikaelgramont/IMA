<style>
	.homepage-title-container {
		background: #D8D8D8;
	    padding: 9px 9px;
	    margin: 0 -9px 5px -9px;
	}

	/* Rest of the page */
	.content-wrapper {
		flex-wrap: nowrap;
	}
	@media screen and (min-width: 640px) {
		.content-main {
		}
		.content-wrapper {
			display: flex;
		}
	}

	.link-as-button {
		background: #E82020;
		display: inline-block;
		border-radius: .5em;
		padding: .5em;
		color: #fff;
		text-decoration: none;
	}	
</style>

<div class="content-wrapper">
	<div class="content-main">
		<?php
			if ($news) {
		?>
			<div class="homepage-title-container">
				<h1 class="display-font">Latest news</h1>
			</div>
		<?php
				echo $news;
			}
		?>
        <h1 class="display-font homepage-title-container">Looking for mountainboarding info?</h1>
        <p class="paragraph">
            Hi there, welcome to the IMA's little corner of the internet.
        </p>
        <p class="paragraph">
            Whether you're an event organizer looking for help, or a mountainboarder looking for official IMA-sanctioned competition results and event calendar, we hope to provide you with the most up-to-date information.
        </p>
	</div>

</div>
