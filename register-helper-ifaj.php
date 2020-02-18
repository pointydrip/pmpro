<?php
 
// We have to put everything in a function called on init, so we are sure Register Helper is loaded.
function my_pmprorh_init() {
	// Don't break if Register Helper is not loaded.
	if ( ! function_exists( 'pmprorh_add_registration_field' ) ) {
		return false;
	}

	// Define the fields.
	$fields = array();
	$fields[] = new PMProRH_Field(
		'country',							// input name, will also be used as meta key
		'select',								// type of field
		array(
			'label'		=> 'Country',		// custom field label
			'profile'	=> true,			// show in user profile
			'required'	=> true,			// make this field required
			'showrequired' => true,
			'levels'		=> array(1,2,3,4,5),	// only levels 1 and 2 should have the company field
			'options' => array(				// <option> elements for select field
				''		=> '',			// blank option - cannot be selected if this field is required
				'argentina'        => 'Argentina',
                                'australia'        => 'Australia',
                                'austria'        => 'Austria',
                                'bangladesh'        => 'Bangladesh',
                                'belgium'        => 'Belgium',
                                'burundi'        => 'Burundi',
                                'burkina_faso'        => 'Burkina Faso',
                                'cameroon'        => 'Cameroon',
                                'canada'        => 'Canada',
                                'congo'        => 'Democratic Republic Of Congo',
                                'croatia'        => 'Croatia',
                                'czech_republic'        => 'Czech Republic',
                                'denmark'        => 'Denmark',
                                'finland'        => 'Finland',
                                'georgia'        => 'Georgia',
                                'germany'        => 'Germany',
                                'ghana'        => 'Ghana',
                                'great_britain'        => 'Great Britain',
                                'guinea'        => 'Guinea',
                                'hungary'        => 'Hungary',
                                'india'        => 'India',
                                'iran'        => 'Iran',
                                'ireland'        => 'Ireland',
                                'israel'        => 'Israel',
                                'italy'        => 'Italy',
                                'japan'        => 'Japan',
                                'kenya'        => 'Kenya',
                                'liberia'        => 'Liberia',
                                'madagascar'        => 'Madagascar',
                                'mexico'        => 'Mexico',
                                'netherlands'        => 'Netherlands',
                                'new_zealand'        => 'New Zealand',
                                'nigeria'        => 'Nigeria',
                                'norway'        => 'Norway',
                                'pakistan'        => 'Pakistan',
                                'philippines'        => 'Philippines',
                                'romania'        => 'Romania',
                                'rwanda'        => 'Rwanda',
                                'serbia_and_montenegro'        => 'Serbia And Montenegro',
                                'senegal'        => 'Senegal',
                                'slovakia'        => 'Slovakia',
                                'slovenia'        => 'Slovenia',
                                'somalia'        => 'Somalia',
                                'south africa'        => 'South Africa',
                                'spain'        => 'Spain',
                                'sweden'        => 'Sweden',
                                'switzerland'        => 'Switzerland',
                                'the_gambia'        => 'The Gambia',
                                'togo'        => 'Togo',
                                'turkey'        => 'Turkey',
                                'ukraine'        => 'Ukraine',
                                'tanzania'        => 'United Republic Of Tanzania',
                                'usa'        => 'United States',
			)
		)
	);
	$fields[] = new PMProRH_Field(
		'title2',							// input name, will also be used as meta key
		'select2',								// type of field
		array(
			'label'		=> 'What is your title or profession',	// custom field label
			'size'		=> 40,				// input size
			'profile'	=> true,
			'required'	=> true,
			'showrequired' => true,
			'levels'		=> array(1,2,3,4,5),
			'options'	=> array(
				'journalist'	=> 'Journalist',
				'editor'	=> 'Editor',
				'publisher'	=> 'Publisher',
				'advertiser'	=> 'Advertiser',
			)
		)
	);
	$fields[] = new PMProRH_Field(
		'organization',							// input name, will also be used as meta key
		'text',							// type of field
		array(
			'label' => 'What company/organization are you with?',
			'profile'	=> true,
			'required'	=> true,
			'showrequired' => true,
			'levels'		=> array(1,2,3,4,5),
		)
	);
	$fields[] = new PMProRH_Field(
		'freelance',							// input name, will also be used as meta key
		'radio',							// type of field
		array(
			'label' => 'Do you do freelance work?',
			'profile'	=> true,
			'required'	=> true,
			'showrequired' => true,
			'levels'		=> array(1,2,3,4),
			'options'	=> array(
				'yes'	=> 'Yes',
				'no'	=> 'No',
			)
		)
	);
	$fields[] = new PMProRH_Field(
		'format',	
		'select2',								
		array(
			'label'		=> 'Enter one or more keywords that summarize format of work you do.',
			'options' => array(			
				''		=> '',			
				'print'	=> 'Print',	
				'photography'	=> 'Photography',	
				'social'	=> 'Social Media',	
				'websites'	=> 'websites',	
				'radio'	=> 'Radio',
				'video'	=> 'Video',
				'other'	=> 'Other',
			),
			'profile'	=> true,			// show in user profile
			'levels'	=> array(1,2,3,4)	
		)
	);
	$fields[] = new PMProRH_Field(
		'expertise',	
		'select2',								
		array(
			'label'		=> 'Enter one or more keywords that summarize your areas of expertise.',
			'options' => array(			
				''		=> '',			
				'ag-policy'        => 'Ag policy',
                                'agri-business'        => 'Agri-business',
                                'arable/row-crops'        => 'Arable/row crops',
                                'beef'        => 'Beef',
                                'biotechnology'        => 'Biotechnology',
                                'conservation'        => 'Conservation',
                                'dairy'        => 'Dairy',
                                'energy'        => 'Energy',
                                'environment'        => 'Environment',
                                'equestrian'        => 'Equestrian',
                                'farm-buildings'        => 'Farm buildings',
                                'farm-diversification'        => 'Farm diversification',
                                'farm-management'        => 'Farm management',
                                'farm-safety'        => 'Farm safety',
                                'fiber'        => 'Fiber',
                                'floriculture'        => 'Floriculture',
                                'food-safety'        => 'Food safety',
                                'forestry'        => 'Forestry',
                                'global-trade'        => 'Global trade',
                                'goats-and-sheep'        => 'Goats and sheep',
                                'horticulture'        => 'Horticulture',
                                'international-development'        => 'International development',
                                'machinery'        => 'Machinery',
                                'natural-resources'        => 'Natural resources',
                                'poultry'        => 'Poultry',
                                'rural-development'        => 'Rural Development',
                                'specialty-crops'        => 'Specialty crops',
                                'swine'        => 'Swine',
				'other'	=> 'Other',
			),
			'profile'	=> true,			// show in user profile
			'levels'	=> array(1,2,3,4)	
		)
	);
	// Add the fields into a new checkout_boxes are of the checkout page.
	foreach ( $fields as $field ) {
		pmprorh_add_registration_field(
			'checkout_boxes',				// location on checkout page
			$field							// PMProRH_Field object
		);
		$fields[] = new PMProRH_Field(
		'non-member',							// input name, will also be used as meta key
		'radio',							// type of field
		array(
			'label' => 'Would you like to become an IFAJ Member?',
			'required'	=> true,
			'showrequired' => true,
			'levels'		=> array(1,2,3,4),
			'options'	=> array(
				'yes'	=> 'Yes',
				'no'	=> 'No',
			)
		)
	);
	}

	// That's it. See the PMPro Register Helper readme for more information and examples.
}
add_action( 'init', 'my_pmprorh_init' );

?>
