<?php
/*
Plugin Name: AdvancedDewplayer
Plugin URI: http://www.westerndeal.com
Description: Upload MP3 files to any folder on your server. Add the shortcode to your page/post with path of your MP3 folder from which you want to fetch all MP3 files and you have a beautiful playable list of MP3's with much more options.
Version: 1.0.0
Author: WesternDeal
Author URI: http://www.westerndeal.com
*/

register_uninstall_hook( __FILE__, 'dew_uninstall' );
function dew_uninstall()
{
	global $wpdb;
	
	$wpdb->delete( $wpdb->prefix.'options', array( 'option_name' => 'dew_display_options' ) );
}


require_once('admin-panel/dew_admin_options.php');
$dp = get_option('dew_display_options');

$maxrows = $dp['max_rows'];
$tabwidth = $dp['table_width'];
$headheight = $dp['header_height'];
$rowheight = $dp['row_height'];
$headcolor = $dp['table_header_color'];
$prirow = $dp['primary_row_color'];
$altrow = $dp['alt_row_color'];
$showno = $dp['show_no_column'];
$showsize = $dp['show_size_column'];
$showlength = $dp['show_duration_column'];
$noheader = $dp['header_name_for_no'];
$nameheader = $dp['header_name_for_name'];
$playerheader = $dp['header_name_for_player'];
$sizeheader = $dp['header_name_for_size'];
$lengthheader = $dp['header_name_for_duration'];
$downloadheader = $dp['header_name_for_download'];
$downloadimg = $dp['download_img'];

add_shortcode('musicdirectory','music_procedure');

function music_procedure($atts)
	 {
		  extract( shortcode_atts( array(
		'path' => '',
	), $atts ) );

global $maxrows;
global $tabwidth;
global $headheight;
global $rowheight;
global $headcolor;
global $prirow;
global $altrow;
global $showno;
global $showsize;
global $showlength;
global $noheader;
global $nameheader;
global $playerheader;
global $sizeheader;
global $lengthheader;
global $downloadheader;
global $downloadimg;
 
include_once("library/getid3.php");     
	
		 if ($handle = opendir(ABSPATH . $path))
		 {
				$count=1;
				$getID3 = new getID3;
				$getID3->encoding = 'UTF-8';
			
				$html = '<style type="text/css">
				.dewPlay{ border: 1px #aaaaaa solid; border-collapse:collapse; width:'.$tabwidth.'px !important;}
				.dewPlay tbody tr td{padding: 8px 12px;}
				.dewPlay tbody tr.dew_header { height:' . $headheight . 'px;}
				 .dewPlay tr.dew-content {height:' . $rowheight . 'px;}
				.dew_header { vertical-align:middle; background-color:'  . $headcolor . '; margin-bottom:12px;}
				.dew_header td{ vertical-align:middle; font-weight:bold; font-family: calibri; font-size: 16px;}
				.dewPlay tbody tr td { vertical-align:middle; }
				.dew-content:nth-child(odd) {background-color:'  . $prirow . ';}
				.dew-content:nth-child(even) {background-color:'  . $altrow . ';}
				</style>';
				$html .= '<table border="1" class="dewPlay">';
				$html .= '<tr class="dew_header">';
				
				if( '1' == $showno)
				{ 
						$html .= '<td>'.$noheader.'</td>';
				}
				
				$html .= '<td>'.$nameheader.'</td><td>'.$playerheader.'</td>';
				
				if( '1' == $showsize)
				{ 
						$html .= '<td>'.$sizeheader.'</td>';
				}
				
				if( '1' == $showlength)
				{ 
						$html .= '<td>'.$lengthheader.'</td>';
				}
				
				$html .= '<td>'.$downloadheader.'</td></tr>';
				
				while (false !== ($file = readdir($handle))) 
				{
					$dirFiles[] = $file;
				}
				closedir($handle);
			
		 }
		 

sort($dirFiles);
foreach($dirFiles as $file)
{
		if ($file == "." || $file == "..") continue;
				if ( strtolower(substr(strrchr($file,"."),1)) != 'mp3' ) continue;
				
				$name = substr(str_replace('_', ' ', $file), 0 , -4);
	            $ThisFileInfo = $getID3->analyze(ABSPATH.$path.$file);
				$playtime = $ThisFileInfo [ 'playtime_string' ];
				$size  =  round((filesize(ABSPATH.$path.$file))/(1024*1024),2);
				
				$html .= '<tr class="dew-content">';
				if( '1' == $showno)
				{ 
				$html .= '<td>'.$count.'</td>';
				}
				$html .= '<td>' . $name . '</td>';
				$html .= '<td style="vertical-align:middle;"> <object type="application/x-shockwave-flash" data="'.plugins_url().'/AdvancedDewplayer/dewplayer.swf?mp3='.get_bloginfo('url')."/".$path.$file.'" width="200" height="20" id="dewplayer"><param name="wmode" value="transparent" /><param name="movie" value="'.plugins_url().'/AdvancedDewplayer/dewplayer.swf?mp3='.get_bloginfo('url').$path.$file.'" /></object>
</td>';
				if( '1' == $showsize)
				{ 
				$html .= '<td>' .$size.' MB </td>';
				}
				if( '1' == $showlength)
				{ 
				$html .= '<td>' .$playtime.' </td>';
				}
				$html .= '<td><a href="'.plugins_url().'/AdvancedDewplayer/admin-panel/download-file.php?dew_file='.get_bloginfo('url')."/".$path.$file.'"><img src="'.$downloadimg.'" title="download" style="border:none !imporatnt; width: 32px; height: 32px;"/></a></td>';
				$html .= '</tr>';
				
				if(isset($maxrows))
				{
					if($count==$maxrows)
					{
						break;
					}
					
				}
				$count++;
	}
			
			$html .= '</table>' ;

		 return $html;
}

// add shortcode for displaying single mp3 file with all options
add_shortcode('musicsingle','music_procedure_single');

function music_procedure_single($atts)
{
		  extract( shortcode_atts( array(
		'file' => '',
	), $atts ) );

				global $tabwidth;
				global $rowheight;
				global $showsize;
				global $showlength;
				global $downloadimg;

				$html = '<style type="text/css">
				.dewPlay{ border: 1px #aaaaaa solid; border-collapse:collapse; width:'.$tabwidth.'px !important;}
				.dewPlay tbody tr td{padding: 8px 12px;}
				 .dewPlay tr.dew-content {height:' . $rowheight . 'px;}
				.dew_header td{ vertical-align:middle; font-weight:bold; font-family: calibri; font-size: 16px;}
				.dewPlay tbody tr td { vertical-align:middle; }
				</style>';
				$html .= '<table border="1" class="dewPlay">';
				$html .= '<tr class="dew-content">';

				if ( strtolower(substr(strrchr($file,"."),1)) != 'mp3' ) continue;
				$parts = pathinfo($file);
				$html .= '<td>' .$parts['basename'] . '</td>';
				$html .= '<td style="vertical-align:middle;"> <object type="application/x-shockwave-flash" data="'.plugins_url().'/AdvancedDewplayer/dewplayer.swf?mp3='.$file.'" width="200" height="20" id="dewplayer"><param name="wmode" value="transparent" /><param name="movie" value="'.plugins_url().'/AdvancedDewplayer/dewplayer.swf?mp3='.$file.'" /></object>
</td>';
				
				$html .= '<td><a href="'.plugins_url().'/AdvancedDewplayer/admin-panel/download-file.php?dew_file='.$file.'"><img src="'.$downloadimg.'" title="download" style="border:none !imporatnt; width: 32px; height: 32px;"/></a></td>';
				$html .= '</tr>';
			
			
			$html .= '</table>' ;

		 return $html;
}
?>