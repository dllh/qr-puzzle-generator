<?php

$filename = 'image.png';
//$grid = get_hint_square_states();
$grid = get_square_states();

$config = array(
	//'fill_style'         => 'slant',
	'fill_style'         => 'fill',
	'pad'                => 10,
	'squares_per_side'   => count( $grid[0] ),
	'square_side_length' => 15,

);

$config['total_side_length'] = $config['squares_per_side'] * $config['square_side_length'];

$im = imagecreate( $config['total_side_length'] + $config['pad'] * 2, $config['total_side_length'] + $config['pad'] * 2 );

$config['white'] = imagecolorallocate( $im, 0xFF, 0xFF, 0xFF );
$config['color'] = imagecolorallocate( $im, 0x77, 0x77, 0x77 );


// Draw bounding box
myimageline( $im, 0, 0, $config['total_side_length'], 0, $config['color'] ); // Top
myimageline( $im, 0, 0, 0, $config['total_side_length'], $config['color'] ); // Left
myimageline( $im, 0, $config['total_side_length'], $config['total_side_length'], $config['total_side_length'], $config['color'] ); // Bottom 
myimageline( $im, $config['total_side_length'], 0, $config['total_side_length'], $config['total_side_length'], $config['color'] ); // Right 

// Draw horizontal lines;
$x1 = 0;
$x2 = $config['total_side_length'];
$y1 = $y2 = $config['square_side_length'];

for ( $i = 0; $i < $config['squares_per_side']; $i++ ) {
	myimageline( $im, $x1, $y1, $x2, $y2, $config['color'] );
	$y1 += $config['square_side_length'];
	$y2 = $y1;
}

// Draw vertical lines
$x1 = $x2 = $config['square_side_length'];
$y1 = 0;
$y2 = $config['total_side_length'];

for ( $i = 0; $i < $config['squares_per_side']; $i++ ) {
	myimageline( $im, $x1, $y1, $x2, $y2, $config['color'] );
	$x1 += $config['square_side_length'];
	$x2 = $x1;
}

// Fill in grid
$row = 0;
$col = 0;

foreach ( $grid as $row_data ) {
	$col = 0;
	foreach ( $row_data as $col_data ) {
		if ( 0 == $col_data ) {
			square_off( $im, $row, $col, $config['fill_style'] );
		} else {
			square_on( $im, $row, $col, $config['fill_style'] );
		}
		$col++;
	}	
	$row++;
}

imagepng( $im, 'image.png' );


function square_on( &$im, $row, $col, $style = 'slant' ) {
	global $config;

	if ( 'fill' == $style ) {
		myimagefilledrectangle( 
			$im, 
			$col * $config['square_side_length'], 
			$row * $config['square_side_length'] + $config['square_side_length'], 
			$col * $config['square_side_length'] + $config['square_side_length'], 
			$row * $config['square_side_length'],
			$config['color']
		);
		//echo "$row, $col fill on\n";
	} else {
		myimageline( 
			$im, 
			$col * $config['square_side_length'], 
			$row * $config['square_side_length'] + $config['square_side_length'], 
			$col * $config['square_side_length'] + $config['square_side_length'], 
			$row * $config['square_side_length'],
			$config['color']
		);
		//echo "$row, $col slant on\n";
	}
}

function square_off( &$im, $row, $col, $style = 'slant' ) {
	global $config;
	if ( 'fill' == $style ) {
		//echo "$row, $col fill off\n";
	} else {
		myimageline( 
			$im, 
			$col * $config['square_side_length'],
			$row * $config['square_side_length'],
			$col * $config['square_side_length'] + $config['square_side_length'], 
			$row * $config['square_side_length'] + $config['square_side_length'],
			$config['color']
		);
		//echo "$row, $col slant off\n";
	}
}

function myimageline( &$im, $x1, $y1, $x2, $y2, $color ) {
	imageline( $im, pad( $x1 ), pad( $y1 ), pad( $x2 ), pad( $y2 ), $color );
}

function myimagefilledrectangle( &$im, $x1, $y1, $x2, $y2, $color ) {
	imagefilledrectangle( $im, pad( $x1 ), pad( $y1 ), pad( $x2 ), pad( $y2 ), $color );
}

function pad( $num ) {
	global $config;
	return $num + $config['pad'];
}

function get_hint_square_states() {
	$grid = '
		00000000000000000000000000000
		00000000000000000000000000000
		00000000000000000000000000000
		00001010000000000000000000000
		00001010000000000000000000000
		00001110111001110111010100000
		00001010101001010101010100000
		00001010111101110111001100000
		00000000000001000100000100000
		00000000000001000100001000000
		00000000000000000000000000000
		00000000000000000000000000000
		00000111000011000000000000000
		00000101000010100000000000000
		00000111011010101110010100000
		00000101000010101010010100000
		00000111000011001111001100000
		00000000000000000000000100000
		00000000000000000000001000000
		00000000000000000000000000000
		00000000000000000000000000000
		00000000111000000000010000000
		00000000001000000000010000000
		00000000010011100111010000000
		00000000100010100100000000000
		00000000111011110111010000000
		00000000000000000000000000000
		00000000000000000000000000000
		00000000000000000000000000000
	';

	return prepare_grid_state( $grid );
}

function get_square_states() {
	$grid_to_return = array();
	$grid =	'
		11111110001010111001101111111
	 	10000010101001000110101000001
		10111010000011001111001011101
		10111010111011111100001011101
		10111010010000101010001011101
		10000010110110000100101000001
		11111110101010101010101111111
		00000000011100001001000000000
		11111011110100011100010101010	 	
		10101000001011000001010101010
		11100111001001110100100001100
		00111000100011001111011111001
		10001011011010110100111010000
		10100101110000001001010101010
		01110111100110000100110001111
		11011100000100100001001110011
		11010110010100011110111010000
		10000000100011100010110111010
		10001111101001111100110001100
		10011000100011001011001110011
		10011110001010111000111111110
		00000000100000000010100010010
		11111110101110011101101011100
		10000010011100101000100010111
		10111010100100011010111110111
		10111010101011111011100100000
		10111010101001110100010100110
		10000010101011001000110001101
		11111110101010110111001011100
		';

	return prepare_grid_state( $grid );
	$grid = trim( $grid );

	$rows = explode( "\n", $grid );
	foreach ( $rows as $row ) {
		$cols = str_split( trim( $row ) );
		$grid_to_return[] = $cols;
	}
	return $grid_to_return;
}

function prepare_grid_state( $grid ) {
	$grid_to_return = array();
	$grid = trim( $grid );

	$rows = explode( "\n", $grid );
	foreach ( $rows as $row ) {
		$cols = str_split( trim( $row ) );
		$grid_to_return[] = $cols;
	}

	return $grid_to_return;
}
