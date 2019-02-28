<style>
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

  .sanctioned {
    text-align: center;
    margin: 10px 60px;
    font-size: 0.8em;
  }
  .sanctioned a {
    text-decoration: none;
  }
	.link-as-button {
		background: #E82020;
		display: inline-block;
		border-radius: .5em;
		padding: .5em;
		color: #fff;
		text-decoration: none;
	}
  .registration-button-container {
    text-align: center;
    font-size: 1.3em;
    margin-bottom: 10px;
  }
  .more {
    text-align: center;
    font-size: .8em;
  }
  .down {
    display: block;
    margin: 0 auto;
    width: 15px;
    height: 15px;
  }
</style>

<div class="content-wrapper">
	<div class="content-main">
    <p class="sanctioned">
      A mountainboard competition sanctioned by the <a href="<?php echo IMA_URL ?>">IMA</a>
    </p>
    <p class="full">
      <img src="<?php echo BASE_URL ?>images/poster.jpg" alt="The official event poster">
    </p>
    <p class="registration-button-container">
      <a href="<?php echo BASE_URL ?>registration" class="link-as-button">Register</a>
    </p>
    <p class="more">
      More details<br>
      <img src="<?php echo BASE_URL ?>images/down-arrow.svg" alt="" class="down">
    </p>
	</div>
</div>
