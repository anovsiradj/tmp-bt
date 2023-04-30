<?php

use Blogger\Contents\EntryPost;
use Blogger\Tags\IncludablePosts;
use Blogger\Tags\Section;
use Blogger\Tags\WidgetBlog;

require __DIR__ . '/settings.php';

$sectionMain = new Section([
	'id' => 'main',
]);

?><!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="/node_modules/bs-v5/dist/css/bootstrap.min.css">

	<title>DevLog</title>
</head>
<body>
	<div class="col-md-7 mx-auto p-3 py-md-5">

		<header class="d-flex align-items-center pb-3 mb-5 border-bottom">
			<a href="/" class="d-flex align-items-center text-dark text-decoration-none">
				<span class="fs-4">Starter template</span>
			</a>
		</header>

		<?php $sectionMain->open() ?>
			<?php
			$widgetBlog = new WidgetBlog();
			$widgetBlog->open();
			?>
				<?php
				$includablePosts = new IncludablePosts(['dataPosts' => $dataPosts]);
				$includablePosts->content(function(EntryPost $post) { ?>
					<article>
					  <h2><?= $post->title ?></h2>
					  <p><?= $post->getCreated() ?></p>

					  <?= $post->content ?>
					</article>
				<?php }); ?>
			<?php $widgetBlog->close() ?>
		<?php $sectionMain->close() ?>

		<footer class="pt-5 my-5 text-muted border-top">
			Created by the Bootstrap team &middot; &copy; 2021
		</footer>
	</div>

	<script src="/node_modules/bs-v5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
