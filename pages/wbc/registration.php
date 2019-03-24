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

  .remove-button {
    background: transparent;
    border: none;
    padding: 0;
    margin: 0 1em;
    cursor: pointer;
  }
  .remove-icon {
    width: 1em;
    fill: #f7f7f7;
  }
  .remove-button[disabled] .remove-icon {
    fill: #888;
  }
  .error {
    color: #e00;
    display: inline-block;
    margin-left: 3px;
  }
  .tip {
    font-size: .85em;
    text-align: center;
    margin-top: 10px;
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
  .form-item label,
  .form-item .label {
    display: inline-block;
    width: calc(35% - 15px);
    margin-right: 10px;
    text-align: right;
    box-sizing: border-box;
    vertical-align: middle;
  }
  .form-item .radio-label {
    text-align: initial;
    width: auto;
  }

  input::placeholder,
  .emptySelect {
    color: #888;
    opacity: 1.0;
  }
  .emptySelect:focus {
    color: initial;
  }
  .form-item input[type=email],
  .form-item input[type=text],
  .form-item select,
  .checkbox-wrapper {
    display: inline-block;
    width: 65%;
    padding: 5px;
    box-sizing: border-box;
    vertical-align: middle;
  }
  .checkbox-wrapper {
   padding: 0;
  }
  .form-item input[type=checkbox] {
    margin-left: 0;
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
  .rider-name,
  .rider-competitions {
    margin: 0 0 5px;
  }
  .rider-competitions .label {
    vertical-align: top;
  }
  .competition-item {
    display: inline-block;
  }
  .error-display {
    margin: 0 auto;
    max-width: 30em;
    display: block;
  }
  .error-code {
    padding: 2em;
    background: #ddd;
    color: #222;
  }
  .transaction {
    text-transform: uppercase;
    font-weight: bold;
  }
  .registered-riders {
    list-style-type: none;
  }
  .registered-riders li {
    padding-bottom: 20px;
    border-bottom: 1px solid;
    margin-bottom: 20px;
    margin-right: 20px;
  }
  .rider-detail {
    padding-right: 10px;
    font-weight: bold;
  }
</style>

<svg class="hidden">
  <defs>
    <g id="remove-icon">
      <path d="M255,0C114.75,0,0,114.75,0,255s114.75,255,255,255s255-114.75,255-255S395.25,0,255,0z M382.5,346.8l-35.7,35.7
			L255,290.7l-91.8,91.8l-35.7-35.7l91.8-91.8l-91.8-91.8l35.7-35.7l91.8,91.8l91.8-91.8l35.7,35.7L290.7,255L382.5,346.8z"/>
    </g>
  </defs>
</svg>

<div class="content-wrapper">
	<div class="content-main">
    <h1 class="display-font">Registration</h1>
    <p>This is the official registration form.</p>
    <p>
      Registration fees are <b><?php echo REGISTRATION_COST ?>&euro;</b> per rider and include:
    </p>
    <ul>
      <li>entry to the competition</li>
      <li>rider dinner on friday and saturday evenings</li>
      <li>drinks during the competition (water and sport drinks)</li>
      <li>swag!</li>
    </ul>
    <p>
      The deadline for online registration is <b><?php echo REGISTRATION_DEADLINE ?></b>.
    </p>

    <div id="form-container"></div>
	</div>
</div>

<script>
  window.__registrationConstants__ = {
    costPerRider: parseFloat(<?php echo REGISTRATION_COST ?>, 10),
    serverProcessingUrl: '<?php echo BASE_URL ?>paypal-transaction-complete'
  }
</script>
<script src="<?PHP echo PAYPAL_SCRIPT ?>"></script>
<script src="<?PHP echo BASE_URL ?>scripts/registration-bundle.js"></script>
