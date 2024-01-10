<?php
  defined('BASEPATH') OR exit('No direct script access allowed');

  if ( ! function_exists('string_seperator')){
		
		function string_seperator($string){
			 $words = explode(" ", $string ); 
			 $count_word = count($words);

			 if($count_word == 1){
			 	return $string;
			 }

			 elseif($count_word == 2 || $count_word == 3){
          $start = 1;
			 }

			 elseif($count_word == 4){
          $start = 2;
			 }

			 elseif($count_word > 4){
          $start = 3;
			 }

			 $second_segmanet = implode(' ',array_splice($words, $start )); 
			 $first_segment = implode(' ', $words);
			 
			 return array($first_segment,$second_segmanet);
		}
  }

   if ( ! function_exists('clean_String')){

   	  function clean_String($str){
         return preg_replace('/\s+/', ' ', $str);
   	  } 
   }
?>