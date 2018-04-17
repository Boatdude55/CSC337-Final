<?php 

$LeaderBoardTemplate = array (
		'div' => array(
				'head' => '<div class="container">',
				'content' => array(
					'quote' => array(
						'head' => '<div class="quote card center large snow-white"><q>',
						'content' => '',
						'tail' => '</q>'
					),
					'author' => array(
						'head' => '<p> -- ',
						'content' => '',
						'tail' => '<p><hr class="divider">'
					),
					'rating' => array(
						'head' => '<form id="default_user" method="post" action="quotes.php"><button class="btn" type="button" data-operator="+" onclick="changeRating(this)">+</button><input type=""text" name="rating" class="rating" value="',
						'content' => '',
						'tail' => '"><button class="btn" type="button" data-operator="-" onclick="changeRating(this)">-</button>'
					),
					'id' => array(
							'head' => '<input type="hidden" name="id" value="',
							'content' => '',
							'tail' => '">'
					),
					'flagged' =>  array(
							'head' => '<button class="btn" name="toggle" value="false" data-caller="toggle" type="button" onclick="toggleFlag(this)">flag</button><input type="hidden" name="flag" value="',
							'content' => '',
							'tail' => '"></div></form>'
					)
				),
				'tail' => '</div>'
		)
);
?>