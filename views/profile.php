<?php
/** @var  $userData */
foreach ($userData as $key => $param):
    ?>
    <p><strong><?= $key ?>:</strong> <?= htmlspecialchars($param, ENT_QUOTES, 'UTF-8') ?></p>
<?php
endforeach;