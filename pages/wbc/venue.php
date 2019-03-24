<style>
  .content-main section {
    margin: 20px 0;
  }
  .content-wrapper {
    flex-wrap: nowrap;
  }
  .centered {
    text-align: center;
  }
  .photo {
    max-width: 100%;
    margin: .5em 0;
  }
  .map {
    display: block;
    margin: 0 auto;
    box-sizing: border-box;
    padding: 0 10px;
    width: 100%;
    height: 60vh;
  }
	@media screen and (min-width: 640px) {
		.content-wrapper {

		}
    .map {
      width: 800px;
      height: 600px;
    }
  }

</style>

<div class="content-wrapper">
	<div class="content-main">
    <h1 class="display-font">Venue</h1>

    <section>
      <h2 class="display-font">The track and features</h2>
      <p>
        TODO: write about the track
      </p>


    </section>

    <section>
      <h2 class="display-font">How to get there</h2>
      <p>The event is located at the following address:</p>

      <p class="centered">
        Novi Sad<br>
        Serbia<br>
      </p>

      <p class="centered">
        <a href="">Open in Google Maps</a>
      </p>

      <iframe class="map" style="border:0" allowfullscreen="" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1131.949946751469!2d20.352651747493383!3d49.96792688346666!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47163b8f82232385%3A0xc278dc0d0f71aa7d!2zNDnCsDU4JzA0LjUiTiAyMMKwMjEnMTEuNiJF!5e1!3m2!1sfr!2sfr!4v1551535564458" frameborder="0"></iframe>
    </section>

    <section>
      <h2 class="display-font">How to get there</h2>
      <p>
        The closest Airport is.
        <img class="photo" src="<?php echo BASE_URL ?>/images/map2.png" alt="Map from Katowice">
      </p>
    </section>
	</div>
</div>
