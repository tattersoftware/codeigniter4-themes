<?php
// Figure out some defaults
if (! isset($selected)) {
    helper(['themes']);
    $selected = theme()->name;
}

$data = [
    'selected' => $selected,
    'auto'     => true,
];
?>

<form name="theme-select" action="<?= site_url('themes/select') ?>" method="post">

	<?= view('Tatter\Themes\Views\select', $data) ?>

</form>
