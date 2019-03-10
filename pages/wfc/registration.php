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
    cursor: pointer;
	}
  .action-button[disabled] {
    background: #888;
  }

  .add,
  .remove {
    background: #f7f7f7;
    color: #13120D;
    margin-left: 10px;
  }

  .error {
    color: #e00;
    display: inline-block;
    margin-left: 3px;
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
    color: #13120D;
  }
  .step-content {
    display: none;
    padding: 10px;
  }
  .step-content.current {
    display: block;
  }
  .formWrapper {
    max-width: 600px;
    margin: 0 auto;
  }
  .formWrapper,
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

    <div id="form-container"></div>
	</div>
</div>

<script>
  window.__registrationConstants__ = {
    costPerRider: parseFloat(<?php echo REGISTRATION_COST ?>, 10),
    serverSideProcessingUrl: '<?php echo BASE_URL ?>paypal-transaction-complete'
  }
</script>


<script>
  //(function() {
  //  var state;
  //  var stepEls;
  //  var riderCount = 1;
  //  const MAX_RIDERS = 5;
  //  const serverSideProcessingUrl = '<?php //echo BASE_URL ?>//paypal-transaction-complete';
  //  const costPerRider = parseFloat(<?php //echo REGISTRATION_COST ?>//, 10);
  //  var totalCost = riderCount * costPerRider;
  //  var hasRenderedPaypal = false;
  //
  //  const formEl = document.getElementById('registration');
  //  const errorEl = document.getElementById('paypal-generic-error');
  //
  //  function getInputForRiderId(id) {
  //    const output = `
  //        <div id="rider-container-${id}">
  //          <hr class="rider-separator" />
  //          <p>Rider ${id}</p>
  //          <div class="form-item">
  //            <label for="rider_first_name${id}">First name</label>
  //            <input type="text" id="rider_first_name${id}" name="rider_first_name[]" value="" placeholder="Rider first name">
  //          </div>
  //          <div class="form-item">
  //            <label for="rider_last_name${id}">Last name</label>
  //            <input type="text" id="rider_last_name${id}" name="rider_last_name[]" value="" placeholder="Rider last name">
  //          </div>
  //        </div>
  //    `;
  //    return output;
  //  }
  //
  //  // Sets event listeners
  //  const startEl = document.getElementById('start-button');
  //  startEl.addEventListener('click', function(e) {
  //    goToStep1();
  //  });
  //  const step1El = document.getElementById('step1-title');
  //  step1El.addEventListener('click', function(e) {
  //    goToStep1();
  //  });
  //  const continueEl = document.getElementById('continue');
  //  continueEl.addEventListener('click', function(e) {
  //    goToStep2();
  //  });
  //  const step2El = document.getElementById('step2-title');
  //  step2El.addEventListener('click', function(e) {
  //    goToStep2();
  //  });
  //  const continue2El = document.getElementById('continue2');
  //  continue2El.addEventListener('click', function(e) {
  //    goToStep3();
  //  });
  //  const addEl = document.getElementById('add');
  //  addEl.addEventListener('click', function(e) {
  //    addRider();
  //  });
  //  const removeEl = document.getElementById('remove');
  //  removeEl.addEventListener('click', function(e) {
  //    removeRider();
  //  });
  //
  //  const riderCountEl = document.getElementById('rider-count');
  //  const totalCostEl = document.getElementById('total-cost');
  //  const additionalRidersEl = document.getElementById('additional-riders');
  //
  //  const STATES = { STEP1: 'step1', STEP2: 'step2', STEP3: 'step3'};
  //
  //  function goToStep1() {
  //    state = STATES.STEP1;
  //    stepEls = formEl.getElementsByTagName('dl')[0].children;
  //    updateSteps();
  //
  //    formEl.hidden = false;
  //    startEl.classList.add('hidden');
  //
  //    formEl.scrollIntoView();
  //    document.getElementById("registrator_first_name").focus();
  //  }
  //
  //  function goToStep2() {
  //    state = STATES.STEP2;
  //    stepEls = formEl.getElementsByTagName('dl')[0].children;
  //    updateSteps();
  //
  //    continueEl.classList.add('hidden');
  //    const firstNameEl = document.getElementById("rider_first_name1");
  //    firstNameEl.value = document.getElementById("registrator_first_name").value;
  //
  //    const lastNameEl = document.getElementById("rider_last_name1");
  //    lastNameEl.value = document.getElementById("registrator_last_name").value;
  //
  //    firstNameEl.focus();
  //  }
  //
  //  function goToStep3() {
  //    state = STATES.STEP3;
  //    stepEls = formEl.getElementsByTagName('dl')[0].children;
  //    updateSteps();
  //
  //    continue2El.classList.add('hidden');
  //
  //    if (!hasRenderedPaypal) {
  //      hasRenderedPaypal = true;
  //      paypal.Buttons({
  //        createOrder: function(data, actions) {
  //          // Set up the transaction
  //          return actions.order.create({
  //            purchase_units: [{
  //              amount: {
  //                value: totalCost
  //              }
  //            }]
  //          });
  //        },
  //        onError: function(err) {
  //          console.log('Error', err);
  //          errorEl.classList.remove('hidden');
  //
  //        },
  //        onApprove: function(data, actions) {
  //          // Capture the funds from the transaction
  //          return actions.order.capture().then(function(details) {
  //            // Show a success message to your buyer
  //            console.log('Transaction details', details);
  //            console.log('Rider info', getRiderDetails());
  //            return fetch(serverSideProcessingUrl, {
  //              method: 'post',
  //              body: JSON.stringify({
  //                orderID: data.orderID,
  //                details: details,
  //                riderDetails: getRiderDetails()
  //              })
  //            });
  //          });
  //        }
  //      }).render('#paypal-button-container');
  //    }
  //  }
  //
  //  function getRiderDetails() {
  //    const inputs = formEl.querySelectorAll('.step2.step-content input');
  //    return Array.from(inputs);
  //  }
  //
  //  function addRider() {
  //    if (riderCount >= MAX_RIDERS) {
  //      riderCount = MAX_RIDERS;
  //      return;
  //    }
  //    riderCount +=1;
  //    additionalRidersEl.innerHTML += getInputForRiderId(riderCount);
  //    updateCountAndCost();
  //  }
  //
  //  function removeRider() {
  //    if (riderCount <= 1) {
  //      riderCount = 1;
  //      return;
  //    }
  //
  //    const lastRiderEl = document.getElementById(`rider-container-${riderCount}`);
  //    lastRiderEl.parentElement.removeChild(lastRiderEl);
  //    riderCount -= 1;
  //    updateCountAndCost();
  //  }
  //
  //  function updateCountAndCost() {
  //    totalCost = costPerRider * riderCount;
  //    totalCostEl.innerText = `${totalCost}`;
  //
  //    riderCountEl.innerText = riderCount > 1 ? `${riderCount} riders` : '1 rider';
  //  }
  //
  //  function updateSteps() {
  //    for(var i = 0, l = stepEls.length; i < l; i++) {
  //      stepEls[i].classList.toggle('current', stepEls[i].classList.contains(state));
  //    }
  //  }
  //
  //})();
</script>

<script src="<?PHP echo BASE_URL ?>scripts/registration-bundle.js"></script>
<!--<script src="--><?PHP //echo PAYPAL_SCRIPT_SANDBOX ?><!--"></script>-->
