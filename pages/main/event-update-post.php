<?php
define('DESTINATION_FOLDER', './images/uploads/');
move_uploaded_file($_FILES['photo']['tmp_name'], DESTINATION_FOLDER . 'test.jpg');
?>

<pre>
  <?php echo var_export($_POST, true) ?>
</pre>
<pre>
  <?php echo var_export($_FILES, true) ?>
</pre>


