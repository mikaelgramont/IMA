<?php
define('NOT_OPEN_YET', 'not_open_yet');
define('OPEN', 'open');
define('CLOSED', 'closed');

/******************************************************************************
 * EVENT CONFIG
 *****************************************************************************/
define('PAYPAL_ACCOUNT', PAYPAL_ACCOUNT_SANDBOX);
define('PAYPAL_CLIENT_ID', PAYPAL_CLIENT_ID_SANDBOX);
define('PAYPAL_SECRET', PAYPAL_SECRET_SANDBOX);
define('PAYPAL_SCRIPT', PAYPAL_SCRIPT_URL . PAYPAL_CLIENT_ID);

define('REGISTRATION_COST_ADULT_TOTAL', 50);
$REGISTRATION_COST_ADULT_TOTAL = REGISTRATION_COST_ADULT_TOTAL;
define('REGISTRATION_COST_ADULT_EACH', 25);
$REGISTRATION_COST_ADULT_EACH = REGISTRATION_COST_ADULT_EACH;

define('REGISTRATION_COST_KID_TOTAL', 40);
$REGISTRATION_COST_KID_TOTAL = REGISTRATION_COST_KID_TOTAL;
define('REGISTRATION_COST_KID_EACH', 20);
$REGISTRATION_COST_KID_EACH = REGISTRATION_COST_KID_EACH;

define('REGISTRATION_DEADLINE', '2019-05-25');

define('REGISTRATION_OPEN', OPEN);

class Translate
{
  public static $translations;
  public static $lang;
}

Translate::$lang = 'fr';
Translate::$translations = array(
  'en' => array (
    'title' => '2019 French Championships - Registration',
    'subtitle' => 'This is the official registration page.',
    'fees' => 'Registration fees',
    'feesParagraph' => <<<FEES
    <li>Registration costs are {$REGISTRATION_COST_ADULT_EACH}&euro; per event (Boardercross or Freestyle) or {$REGISTRATION_COST_ADULT_TOTAL}&euro; for both (with a bonus free T-shirt!).</li>
    <li>Reduced fees for children under the age of 14: {$REGISTRATION_COST_KID_EACH}&euro; per event or {$REGISTRATION_COST_KID_TOTAL}&euro; for both (with a bonus free T-shirt!).</li>
FEES
    ,
    'included' => 'Included',
    'includedInFees' => <<<INCLUDED
    <li>Competition registration</li>
    <li>3 meals</li>
    <li>On-site camping</li>
INCLUDED
    ,
    'deadline' => 'The deadline for online registration is May 25th 2019.',
    'notOpenYet' => 'Online registration is not open yet.',
    'closed' => 'Online registration is closed.',
  ),
  'fr' => array (
    'title' => 'Championnats de France 2019 - Inscription',
    'subtitle' => 'La page officielle d\'inscription en ligne.',
    'fees' => 'Coûts d\'inscription',
    'feesParagraph' => <<<FEES
    <li>Le prix de l'inscription est de {$REGISTRATION_COST_ADULT_EACH}&euro; par discipline (Boardercross ou Freestyle) ou {$REGISTRATION_COST_ADULT_TOTAL}&euro; les deux (avec un T-shirt gratuit!).</li>
    <li>Prix réduit pour les moins de 14 ans: {$REGISTRATION_COST_KID_EACH}&euro; par discipline ou {$REGISTRATION_COST_KID_TOTAL}&euro; les deux (avec un T-shirt gratuit!).</li>
FEES
  ,
    'included' => 'Inclus',
    'includedInFees' => <<<INCLUDED
    <li>Inscription à la compétition</li>
    <li>3 repas</li>
    <li>Camping sur place</li>
INCLUDED
  ,
    'deadline' => 'La date limite d\'enregistrement en ligne est le 25 Mai 2019.',
    'notOpenYet' => 'L\'enregistrement en ligne n\'est pas encore ouvert.',
    'closed' => 'L\'enregistrement en ligne n\'est terminé.',
  ),
);


function _($key) {
  $translations = Translate::$translations;
  $lang = Translate::$lang;

  if (!isset($translations[$lang])) {
    throw new Exception("Language '$lang' not supported");
  }

  if (!isset($translations[$lang][$key])) {
    throw new Exception("Key '$key' not present in language '$lang'");
  }

  return $translations[$lang][$key];
}

?>
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

  .registration-status {
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
    <h1 class="display-font"><?php echo _('title') ?></h1>
    <p><?php echo _('subtitle') ?></p>
    <h2 class="display-font"><?php echo _('fees') ?></h2>
    <ul><?php echo _('feesParagraph') ?></ul>
    <h2 class="display-font"><?php echo _('included') ?></h2>
    <ul><?php echo _('includedInFees') ?></ul>
    <p>
      <?php echo _('deadline') ?>
    </p>

    <?php
    switch (REGISTRATION_OPEN) {
      case NOT_OPEN_YET:
        echo "<p class='registration-status'>". _('notOpenYet') ."</p>\n";
        break;
      case CLOSED:
        echo "<p class='registration-status'>". _('closed') ."</p>\n";
        break;
    }
    ?>

    <div id="form-container"></div>
  </div>
</div>


<?php
if (REGISTRATION_OPEN == OPEN) {
  ?>
  <script>
    window.__registrationConstants__ = {
      costs: {
        adultTotal: parseFloat(<?php echo REGISTRATION_COST_ADULT_TOTAL ?>, 10),
        adultEach: parseFloat(<?php echo REGISTRATION_COST_ADULT_EACH ?>, 10),
        kidTotal: parseFloat(<?php echo REGISTRATION_COST_KID_TOTAL ?>, 10),
        kidEach: parseFloat(<?php echo REGISTRATION_COST_KID_EACH ?>, 10),
      },
      serverProcessingUrl: '<?php echo BASE_URL ?>paypal-transaction-complete'
    }
  </script>
  <script src="<?PHP echo PAYPAL_SCRIPT ?>"></script>
  <script src="<?PHP echo BASE_URL ?>scripts/2019-french-championships-bundle.js"></script>
  <?php
}
?>