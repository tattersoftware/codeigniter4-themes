
	<select name="theme" class="<?= $class ?? '' ?>" <?= empty($auto) ? '' : "onchange='this.form.submit();'" ?> >
		<?php foreach (model('ThemeModel')->findAll() as $theme): ?>

			<option <?= isset($selected) && $selected === $theme->name ? 'selected' : '' ?>>
				<?= $theme->name ?>
			</option>

		<?php endforeach; ?>
	</select>
