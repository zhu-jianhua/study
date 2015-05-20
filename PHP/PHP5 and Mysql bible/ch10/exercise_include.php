<!-- Listing 10-1: exercise_include.php -->
<?php
// categories of exercise with associated calories per minute
// (not medically trustworthy because we made them up)
$exercise_info = 
  array('Aerobic exercise' =>
	  array('biking/cycling' => 9,
                'rowing' => 8,
                'running' => 14,
                'stairclimber' => 6,
	        'walking' => 5),
	'Sports' =>
           array('basketball' => 12,
                 'ice hockey' => 9,
                 'soccer/football' => 11,
                 'table tennis' => 7),
   'Strength training' =>
           array('calisthenics' => 11,
                 'weightlifting (light)' => 9,
                 'weightlifting (strenuous)' => 13),
	'Stretching/flexibility' =>                 
           array('pilates' => 5, 
                 'tai chi' => 6,
                 'yoga' => 5)
       );
?>
