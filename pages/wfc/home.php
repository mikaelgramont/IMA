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
  .more a {
    color: #F7F7F7;
    text-decoration: none;
  }
  .down {
    display: block;
    margin: 0 auto;
    width: 15px;
    height: 15px;
  }

  .embed {
    width: 100%;
    height: 240px;
  }
  @media screen and (min-width: 640px) {
    height: 480px;
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
      <a href="#details">More details</a><br>
      <img src="<?php echo BASE_URL ?>images/down-arrow.svg" alt="" class="down">
    </p>

    <section>
      <a id="details"></a>
      <p>The World Freestyle Championships is back in 2019, and it will take place July 26-27th in Moszczenica, Poland!</p>
      <p>The IMA is excited to see the WFC go to Poland this year, as the mountainboard scene there has been buzzing for many years now.</p>

      <iframe class="embed" src="https://www.youtube.com/embed/D_2xNcpw7co" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

      <p>Dawid Rząca's home spot of Mosquito Park is the chosen venue for this year's competition, and it will have features for all levels of riding, so come join us in Poland!</p>
    </section>
	</div>
</div>
