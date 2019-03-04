<style>
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

  dt {
    padding: 5px;
  }
  dd {
    margin: 0;
  }

  .start,
  .continue {
    border: 0;
		background: #E82020;
		display: inline-block;
		border-radius: 1em;
		padding: .5em;
		color: #fff;
		text-decoration: none;
    font-size: .75em;
	}

  .start.hidden {
    display: none;
  }

  .start-wrapper {
    text-align: center;
  }

  .start {
    font-size: 1em;
  }

  .step-title {

  }
  .step-title.current {
    background: #f7f7f7;
    color: #1A1705;
  }
  .step-content {
    display: none;
  }
  .step-content.current {
    display: block;
  }
  .form-item {
    margin: 10px 0;
  }
  .form-item label {
    display: inline-block;
    width: calc(30% - 15px);
    margin-right: 10px;
    text-align: right;
    box-sizing: border-box;
  }
  .form-item input[type=text] {
    display: inline-block;
    width: 70%;
    padding: 5px;
    box-sizing: border-box;
  }
  .continue-wrapper {
    text-align: right;
  }
</style>

<div class="content-wrapper">
	<div class="content-main">
    <h1 class="display-font">Registration</h1>
    <p>This is the official online registration form page.</p>
    <p>
      Registration fees are <b><?php echo REGISTRATION_COST ?>&euro;</b> per rider.<br>
      The deadline for online registration is <?php echo REGISTRATION_DEADLINE ?>.
    </p>
    <p>
      Press the button below to start registering yourself and/or other riders. You will need a Paypal account to proceed.
    </p>

    <div class="start-wrapper">
      <button type="button" class="start" id="start-button">Start registering</button>
    </div>

    <form id="registration" hidden>
      <h2 class="display-font">Registration form</h2>
      <dl class="steps">
        <dt class="step1 step-title">1 - Your information</dt>
        <dd class="step1 step-content">
          <div class="form-item">
            <label for="registrator_first_name">First name</label>
            <input type="text" name="registrator_first_name" value="" placeholder="Your first name">
          </div>
          <div class="form-item">
            <label for="registrator_last_name">Last name</label>
            <input type="text" name="registrator_last_name" value="" placeholder="Your last name">
          </div>
          <div class="form-item">
            <label for="registrator_email">Email</label>
            <input type="text" name="registrator_email" value="" placeholder="Your email">
          </div>
          <div class="form-item continue-wrapper">
            <button type="button" class="continue">Continue</button>
          </div>
        </dd>

        <dt class="step2 step-title">2 - Registered rider(s) and price</dt>
        <dd class="step2 step-content">

        </dd>
        <dt class="step step-title step3">3 - Payment</dt>
        <dd class="step3 step-content">

        </dd>
      </dl>
    </form>
	</div>
</div>


<script>
  (function() {
    // Sets event listeners
    const startEl = document.getElementById('start-button');
    startEl.addEventListener('click', function(e) {
      startForm(document.getElementById('registration'));
    });

    const STATES = { STEP1: 'step1', STEP2: 'step2', STEP3: 'step3'};

    var state;
    var stepEls;

    function startForm(form) {
      state = STATES.STEP1;
      stepEls = form.getElementsByTagName('dl')[0].children;
      form.hidden = false;
      startEl.classList.add('hidden');
      updateSteps();


      // TODO: add focus to first name


    }

    function updateSteps() {
      for(var i = 0, l = stepEls.length; i < l; i++) {
        stepEls[i].classList.toggle('current', stepEls[i].classList.contains(state));
      }
    }

  })();
</script>
