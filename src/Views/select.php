
	<select name="theme" class="<?= $class ?? '' ?>" <?= empty($auto) ? '' : "onchange='this.form.submit();'" ?> >
		<?php foreach (model('ThemeModel')->findAll() as $theme): ?>

			<option value="<?= $theme->id ?>" <?= isset($selected) && $selected === $theme->id ? 'selected' : '' ?> ><?= $theme->name ?></option>

		<?php endforeach; ?>
	</select>
