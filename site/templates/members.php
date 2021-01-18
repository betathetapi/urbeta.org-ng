<?php

include('./_head.php'); // include header markup ?>

	<?php // TODO move this into the proper header... requires Delayed Output I suspect. Also make it async ?>
	<link rel="stylesheet" type="text/css" href="<?php echo $config->urls->templates?>styles/micromodal.css" />
	<script defer src="https://cdn.jsdelivr.net/npm/micromodal@0.4.6/dist/micromodal.min.js" integrity="sha384-nWs1M/fZYuCuFG5AUFQ+LF4nLbcbpklWvm99jW9tzUaNW1FIOXmJ+zeLwABJ6Exm" crossorigin="anonymous"></script>
	<script defer src="<?php echo $config->urls->templates ?>scripts/members.js"></script>

	<div id='content'><?php
		// Pages for individual members have view permissions disabled for guests to prevent them
		// from showing up in search results and the sitemap.
		//
		// So here, we include no-access pages in this query.
		$pageChildren = $page->children('limit=20, check_access=0, sort=-roll_number');

		foreach($pageChildren as $child) {
			echo '<div class="member-block">';

			echo '<img height="266" width="200" id="' . $child->name .'" class="member-image" src="' . $child->member_image->url . '" alt="Portrait of Beta member ' . $child->title . '" />';
			echo "<h2 class='member-name'>$child->title</h2>";

			// If JS is available, we display this in a popup instead
			echo "<noscript class='member-profile' data-name='$child->name' data-member-name='$child->title'>";

			echo "<p><strong>Major</strong>: ";
			if ($child->major) {
				echo $child->major;
			} else {
				echo "undeclared";
			}
			echo "</p>";

			if ($child->hometown) echo "<p><strong>Hometown</strong>: $child->hometown</p>";

			$now = new DateTimeImmutable();
			$joinYear = new DateTimeImmutable("@" . $child->ur_join_year);
			$gradYear = new DateTimeImmutable("@" . $child->graduation_date);
			echo "<p><strong>Year</strong>: ";
			// NOTE: 5th-year programs are relative to graduation date but everything else is
			// relative to start date because not everyone takes exactly 4 years to graduate.
			if($now > $gradYear) {
				echo "graduated";
			} elseif ($now > $gradYear->modify("-1 year") && $child->fifth_year_program) {
				echo "$child->fifth_year_program student";
			} elseif ($now > $joinYear->modify("+3 years")) {
				echo "senior";
			} elseif ($now > $joinYear->modify("+2 years")) {
				echo "junior";
			} elseif ($now > $joinYear->modify("+1 years")) {
				echo "sophomore";
			} else {
				echo "first-year";
			}

			echo "<p>$child->member_description</p>";

			echo "</noscript>";

			echo "</div>"; // .member-block
		}

		echo $pageChildren->renderPager();

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
