<?php
/**
 * The template for the administrative widget that confirms Exhibit data integrity.
 *
 * @package Custom Child Theme Post types
 * @since 1.1.0
 */

?>

<p>This widget analyzes all Exhibit records, checking for records which need
their location adjusted while we launch the new location features.</p>

<p><strong>The following records may need to be edited:</strong></p>

<?php
$total = 0;
$match = 0;
$miss = 0;

if ( $query->have_posts() ) {
	echo '<ol>';
	while ( $query->have_posts() ) {
		$query->the_post();
		$location_info = get_exhibit_location();

		$acf_location = get_field( 'location' );
		$cat_location = $location_info['name'];

		if ( $acf_location === $cat_location ) {
			++$match;
		} else {
			++$miss;
			echo '<li>';
			the_title();
			echo '<br>';
			echo esc_html( $acf_location ) . '<br>';
			echo esc_html( $cat_location ) . '<br>';
			echo '</li>';
		}

		++$total;
	}
	echo '</ol>';

	wp_reset_postdata();
} else {
	esc_html( 'There are no Exhibit records to anlayze.' );
};

echo esc_html( "${total} exhibits were found" ) . '<br>';
echo esc_html( "${match} good records" ) . '<br>';
echo esc_html( "${miss} records have issues" ) . '<br>';
?>
