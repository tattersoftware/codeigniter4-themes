
<form name="theme-select" action="<?= site_url('themes/select') ?>" method="post">

	<?= view('Tatter\Themes\Views\select', ['class' => $class ?? '', 'selected' => $selected ?? theme()->id, 'auto' => $auto ?? true]) ?>

</form>
