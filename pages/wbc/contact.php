<style>
	.content-wrapper {
		flex-wrap: nowrap;
	}
  dd {
    padding-left: 20px;
    margin: 0 0 20px;
  }
  ul {
    margin: 0;
    padding: 0;
  }

	@media screen and (min-width: 640px) {
		.content-main {
		}
		.content-wrapper {
			display: flex;
		}
	}

  .link {
    white-space: nowrap;
  }
</style>

<div class="content-wrapper">
	<div class="content-main">
    <h1 class="display-font">Contact</h1>
    <p>Need to get in touch with us?<br>Send us an email at <a class="link" href="mailto:<?php echo EMAIL_IMA ?>"><?php echo EMAIL_IMA ?></a></p>
    <p>Otherwise, you can reach us on the <a class="link" href="<?php echo FB_EVENT_URL ?>">WFC19 Facebook event page</a>.</p>
	</div>
</div>
