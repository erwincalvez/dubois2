<?php

$form = '<form role="search" method="get" class="TOTO search-form" action="' . esc_url(home_url('/')) . '">
				<label>
					<span class="screen-reader-text">' . _x('Search for:', 'label') . '</span>
					<input type="search" class="search-field" placeholder="Recherche" value="' . get_search_query() . '" name="s" title="' . esc_attr_x('Search for:', 'label') . '" />
				</label>
				<input type="submit" class="search-submit" value="OK" />
			</form>';

echo $form;
?>