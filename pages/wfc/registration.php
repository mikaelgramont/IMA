<style>
	/* Rest of the page */
	.content-wrapper {
		flex-wrap: nowrap;
	}
	@media screen and (min-width: 640px) {
		.content-main {
      width: 100%;
		}
		.content-wrapper {
			display: flex;
		}
	}

  dt {
    padding: 5px;
  }
  dl,
  dd {
    margin: 0;
  }

  .action-button {
    border: 0;
		background: #E82020;
		display: inline-block;
		border-radius: 1em;
		padding: .5em;
		color: #fff;
		text-decoration: none;
    font-size: .75em;
	}

  .add,
  .remove {
    background: #f7f7f7;
    color: #1A1705;
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
    padding: 8px;
    margin-bottom: 1px;
  }
  .step-title.clickable {
    cursor: pointer;
  }
  .step-title.current {
    background: #f7f7f7;
    color: #1A1705;
  }
  .step-content {
    display: none;
    padding: 10px;
  }
  .step-content.current {
    display: block;
  }
  .form {
    max-width: 600px;
    margin: 0 auto;
  }
  .form,
  .step-title {
    outline: 1px solid #f7f7f7;
  }
  .form-title {
    padding: 8px;
    margin: 0;
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
  .form-item input[type=email],
  .form-item input[type=text] {
    display: inline-block;
    width: 70%;
    padding: 5px;
    box-sizing: border-box;
  }
  .continue-wrapper {
    text-align: right;
  }
  .summary1,
  .summary2 {
    margin: 10px 0;
    text-align: right;
  }
  .summary p {
    margin: 0 1em;
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
      <button type="button" class="start action-button" id="start-button">Start registering</button>
    </div>

    <form id="registration" hidden class="form">
      <h2 class="display-font form-title">Registration form</h2>
      <dl class="steps">
        <dt class="step1 step-title clickable" id="step1-title">1 - Your information</dt>
        <dd class="step1 step-content">
          <div class="form-item">
            <label for="registrator_first_name">First name</label>
            <input type="text" id="registrator_first_name" name="registrator_first_name" value="" placeholder="Your first name">
          </div>
          <div class="form-item">
            <label for="registrator_last_name">Last name</label>
            <input type="text" id="registrator_last_name" name="registrator_last_name" value="" placeholder="Your last name">
          </div>
          <div class="form-item">
            <label for="registrator_email">Email</label>
            <input type="email" name="registrator_email" value="" placeholder="Your email">
          </div>
          <div class="form-item continue-wrapper">
            <button type="button" id="continue" class="action-button">Continue</button>
          </div>
        </dd>

        <dt class="step2 step-title clickable" id="step2-title">2 - Registered rider(s) and price</dt>
        <dd class="step2 step-content">
          <p>You can register yourself or several riders.</p>

          <p>Rider 1</p>
          <div class="form-item">
            <label for="rider_first_name1">First name</label>
            <input type="text" id="rider_first_name1" name="rider_first_name[]" value="" placeholder="Rider first name">
          </div>
          <div class="form-item">
            <label for="rider_last_name1">Last name</label>
            <input type="text" id="rider_last_name1" name="rider_last_name[]" value="" placeholder="Rider last name">
          </div>

          <div id="additional-riders"></div>

          <hr class="rider-separator" />
          <div class="summary1">
            <button type="button" id="add" class="action-button add">Add a rider</button>
            <button type="button" id="remove" class="action-button remove">Remove a rider</button>
          </div>
          <div class="summary2">
            <span id="rider-count">1 rider</span> - <span id="total">Total: <span id="total-cost">35</span> &euro;</span>
          </div>
          <div class="form-item continue-wrapper">
            <button type="button" id="continue2" class="action-button">Continue</button>
          </div>
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
    var state;
    var stepEls;
    let riderCount = 1;
    const MAX_RIDERS = 5;
    const costPerRider = parseFloat(<?php echo REGISTRATION_COST ?>, 10);

    const formEl = document.getElementById('registration');

    function getInputForRiderId(id) {
      const output = `
          <div id="rider-container-${id}">
            <hr class="rider-separator" />
            <p>Rider ${id}</p>
            <div class="form-item">
              <label for="rider_first_name${id}">First name</label>
              <input type="text" id="rider_first_name${id}" name="rider_first_name[]" value="" placeholder="Rider first name">
            </div>
            <div class="form-item">
              <label for="rider_last_name${id}">Last name</label>
              <input type="text" id="rider_last_name${id}" name="rider_last_name[]" value="" placeholder="Rider last name">
            </div>
          </div>
      `;
      return output;
    }

    // Sets event listeners
    const startEl = document.getElementById('start-button');
    startEl.addEventListener('click', function(e) {
      goToStep1();
    });
    const step1El = document.getElementById('step1-title');
    step1El.addEventListener('click', function(e) {
      goToStep1();
    });
    const continueEl = document.getElementById('continue');
    continueEl.addEventListener('click', function(e) {
      goToStep2();
    });
    const step2El = document.getElementById('step2-title');
    step2El.addEventListener('click', function(e) {
      goToStep2();
    });
    const continue2El = document.getElementById('continue2');
    continue2El.addEventListener('click', function(e) {
      goToStep3();
    });
    const addEl = document.getElementById('add');
    addEl.addEventListener('click', function(e) {
      addRider();
    });
    const removeEl = document.getElementById('remove');
    removeEl.addEventListener('click', function(e) {
      removeRider();
    });

    const riderCountEl = document.getElementById('rider-count');
    const totalCostEl = document.getElementById('total-cost');
    const additionalRidersEl = document.getElementById('additional-riders');

    const STATES = { STEP1: 'step1', STEP2: 'step2', STEP3: 'step3'};


    function goToStep1() {
      state = STATES.STEP1;
      stepEls = formEl.getElementsByTagName('dl')[0].children;
      updateSteps();

      formEl.hidden = false;
      startEl.classList.add('hidden');

      formEl.scrollIntoView();
      document.getElementById("registrator_first_name").focus();
    }

    function goToStep2() {
      state = STATES.STEP2;
      stepEls = formEl.getElementsByTagName('dl')[0].children;
      updateSteps();

      continueEl.classList.add('hidden');
      const firstNameEl = document.getElementById("rider_first_name0");
      firstNameEl.value = document.getElementById("registrator_first_name").value;

      const lastNameEl = document.getElementById("rider_last_name0");
      lastNameEl.value = document.getElementById("registrator_last_name").value;

      firstNameEl.focus();
    }

    function goToStep3() {
      state = STATES.STEP3;
      stepEls = formEl.getElementsByTagName('dl')[0].children;
      updateSteps();

      continue2El.classList.add('hidden');
    }

    function addRider() {
      if (riderCount >= MAX_RIDERS) {
        riderCount = MAX_RIDERS;
        return;
      }
      riderCount +=1;
      additionalRidersEl.innerHTML += getInputForRiderId(riderCount);
      updateCountAndCost();
    }

    function removeRider() {
      if (riderCount <= 1) {
        riderCount = 1;
        return;
      }

      const lastRiderEl = document.getElementById(`rider-container-${riderCount}`);
      lastRiderEl.parentElement.removeChild(lastRiderEl);
      riderCount -= 1;
      updateCountAndCost();
    }

    function updateCountAndCost() {
      const totalCost = costPerRider * riderCount;
      totalCostEl.innerText = `${totalCost}`;

      riderCountEl.innerText = riderCount > 1 ? `${riderCount} riders` : '1 rider';
    }

    function updateSteps() {
      for(var i = 0, l = stepEls.length; i < l; i++) {
        stepEls[i].classList.toggle('current', stepEls[i].classList.contains(state));
      }
    }

  })();
</script>
