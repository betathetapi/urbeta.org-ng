<?php

include('./_head.php'); // include header markup ?>

	<div id='content'><?php

		// output 'headline' if available, otherwise 'title'
		echo "<h1>" . $page->get('headline|title') . "</h1>";

		$posts = $page->children('limit=10, sort=-publish_date');

		foreach ($posts as $idx=>$post) {
			if ($idx !== 0) {
				echo "<hr class='social-hr' />";
			}

			// TODO alt texts
			if (count($post->post_images) > 1) {
				// TODO turn this into a gallery or something
				foreach ($post->post_images as $img) {
					echo "<img src='$img->url' />";
				}
			} else if (!empty($post->post_images)) {
				echo "<p>";
				echo "<img class='social-img' src='{$post->post_images->first()->url}' />";
				echo "</p>";
			}

			if ($post->post_show_title) {
				echo "<h2>$post->title</h2>";
			}

			echo $post->post_content;

			echo "<em>$post->publish_date</em>";
		}

                echo $posts->renderPager();
	?></div><!-- end content -->

	<aside id='sidebar'><?php

		// rootParent is the parent page closest to the homepage
		// you can think of this as the "section" that the user is in
		// so we'll assign it to a $section variable for clarity
		$section = $page->rootParent;

		// if there's more than 1 page in this section...
		if($section->hasChildren > 1) {
			// output sidebar navigation
			// see _init.php for the renderNavTree function
			renderNavTree($section);
		}

		// output sidebar text if the page has it
		echo $page->sidebar;

	?></aside><!-- end sidebar -->

<?php include('./_foot.php'); // include footer markup ?>
