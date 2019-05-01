<?php
/******************************************************************************
 * TODO 1: move all this stuff into external classes
 *****************************************************************************/

class Translate
{
  public static $translations;
  public static $lang;
}

function t($key) {
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


$defaultLanguage = 'en';
$languageFilePath = realpath(__DIR__. '/../../../translations');
$translationFilePaths = Utils::getFilesInFolder($languageFilePath, "*.json");
$regex = "/.*([a-z]{2})\.json/";
$availableLanguages = array('en');
foreach ($translationFilePaths as $translationFilePath) {
  preg_match($regex, $translationFilePath,$matches);
  if ($matches && sizeof($matches) == 2) {
    $availableLanguages[] = $matches[1];
  }
}

$config = PaymentConfigList::getConfig(PaymentConfigList::CDF_2019);
$langQueryArg = isset($_GET['lang']) ? $_GET['lang'] : null;
$lang = Utils::pickUserLanguageInList($availableLanguages, $defaultLanguage, $langQueryArg);
if ($lang === $defaultLanguage) {
  $jsTranslations = json_encode(new stdClass());
} else {
  $jsTranslations = file_get_contents($languageFilePath . "/" . $lang . ".json");
}

Translate::$lang = $lang;

/******************************************************************************
 * End of TODO 1
 *****************************************************************************/


/******************************************************************************
 * TODO 2: create translation entries, then create a PHP script to parse them
 * and save them to a JS file (from scratch everytime) so that it gets picked
 * up by the JS translation extraction process.
 *****************************************************************************/

Translate::$translations = array(
  'en' => array (
    'title' => '2019 French Championships - Registration',
    'subtitle' => 'This is the official registration page.',
    'fees' => 'Registration fees',
    'feesParagraph' => <<<FEES
    <li>Registration costs are {$config->costs->adultEach}&euro; per event (Boardercross or Freestyle) or {$config->costs->adultTotal}&euro; for both (with a bonus free T-shirt!).</li>
    <li>Reduced fees for children under the age of 14: {$config->costs->kidTotal}&euro; per event or {$config->costs->kidEach}&euro; for both (with a bonus free T-shirt!).</li>
    <li>Non-riders can register in order get the same meals as riders (same price).</li>
FEES
    ,
    'included' => 'Included',
    'includedInFees' => <<<INCLUDED
    <li>Competition registration</li>
    <li>3 meals with each event: lunch and dinner on day 1, lunch on day 2</li>
    <li>On-site camping</li>
INCLUDED
    ,
    'deadline' => 'The deadline for online registration is '.$config->deadline.'.',
    'notOpenYet' => 'Online registration is not open yet.',
    'closed' => 'Online registration is closed.',
  ),
  'fr' => array (
    'title' => 'Championnats de France 2019 - Inscription',
    'subtitle' => 'La page officielle d\'inscription en ligne.',
    'fees' => 'Coûts d\'inscription',
    'feesParagraph' => <<<FEES
    <li>Le prix de l'inscription est de {$config->costs->adultEach}&euro; par discipline (Boardercross ou Freestyle) ou {$config->costs->adultTotal}&euro; les deux (avec un T-shirt offert!).</li>
    <li>Prix réduit pour les moins de 14 ans: {$config->costs->kidEach}&euro; par discipline ou {$config->costs->kidTotal}&euro; les deux (avec un T-shirt offert!).</li>
    <li>Les accompagnants peuvent s'inscrire pour avoir accès aux mêmes repas que les riders (prix identique).</li>
FEES
  ,
    'included' => 'Inclus',
    'includedInFees' => <<<INCLUDED
    <li>Inscription à la compétition</li>
    <li>3 repas pour chaque évènement: midi et soir pour le premier jour, midi le second jour</li>
    <li>Camping sur place</li>

INCLUDED
  ,
    'deadline' => 'La date limite d\'enregistrement en ligne est le '.$config->deadline.'.',
    'notOpenYet' => 'L\'enregistrement en ligne n\'est pas encore ouvert.',
    'closed' => 'L\'enregistrement en ligne n\'est terminé.',
  ),
);
/******************************************************************************
 * End of TODO 2
 *****************************************************************************/



/******************************************************************************
 * TODO 3: move CSS and SVG to a file and inline it with PHP.
 *****************************************************************************/
?>
<style>
  /* Rest of the page */
  .content-wrapper {
    flex-wrap: nowrap;
  }
  .content-main {
    margin-bottom: 20px;
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
    background: #13120D;
    color: #f7f7f7;
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
    fill: #13120D;
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
    background: #13120D;
    color: #f7f7f7;
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
    outline: 1px solid #13120D;
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
  .form-item .checkbox-label,
  .form-item .radio-label {
    text-align: initial;
    width: auto;
  }

  .form-item .radio-label {
    margin-left: 5px;
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
    <h1 class="display-font"><?php echo t('title') ?></h1>
    <p><?php echo t('subtitle') ?></p>
    <h2 class="display-font"><?php echo t('fees') ?></h2>
    <ul><?php echo t('feesParagraph') ?></ul>
    <h2 class="display-font"><?php echo t('included') ?></h2>
    <ul><?php echo t('includedInFees') ?></ul>
    <p>
      <?php echo t('deadline') ?>
    </p>

    <?php
    switch ($config->status) {
      case PaymentConfigList::NOT_OPEN_YET:
        echo "<p class='registration-status'>". t('notOpenYet') ."</p>\n";
        break;
      case PaymentConfigList::CLOSED:
        echo "<p class='registration-status'>". t('closed') ."</p>\n";
        break;
    }
    ?>

    <div id="form-container"></div>
  </div>
</div>


<?php
if ($config->status == PaymentConfigList::OPEN) {
  ?>
  <script>
  window.__registrationConstants__ = {
      paymentType: <?php echo json_encode($config->paymentType) ?>,
      costs: <?php echo json_encode($config->costs) ?>,
      serverProcessingUrl: '<?php echo $config->serverProcessingUrl ?>',
      translations: <?php echo $jsTranslations ?>,
      language: '<?php echo $lang ?>',
  };
  </script>
  <script src="<?PHP echo $config->paypalScript ?>"></script>
  <script src="<?php echo $config->jsBundle ?>"></script>
  <?php
}
?>