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

  .video-embed-wrapper {
    position: relative;
    height: 0;
    padding-top: 56.25%;
  }

  .video-embed-wrapper iframe {
    position: absolute;
    width: 100%;
    height: 100%;
    left: 0;
    top: 0;
  }

  .live-coverage {
    text-align: center;
    display: block;
    color: #F7F7F7;
    text-decoration: none;
    margin: 20px;
  }

  .live {
    text-transform: uppercase;
    color: #f00;
  }

</style>

<div class="content-wrapper">
	<div class="content-main">
    <p class="sanctioned">
      An <a href="<?php echo IMA_URL ?>">IMA</a>-sanctioned Mountainboard competition
    </p>

    <a class="live-coverage" href="https://www.mountainboardworld.org/news/17-2019-wbc" target="_blank">
      Check out our <span class="live">live coverage</span> of the event on the IMA's main site!
    </a>

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
      <p>
        The World Boardercross Championship is back in 2019, and it will take place September 6th-7th in Bukovac,
        Serbia!
      </p>

      <div class="video-embed-wrapper">
        <iframe class="embed" src="https://www.youtube.com/embed/k_QbR2aoClo" frameborder="0"
                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
        </iframe>
      </div>

    </section>
	</div>
</div>
