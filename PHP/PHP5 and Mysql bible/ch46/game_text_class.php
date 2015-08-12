<?php
class GameText 
{

function __construct () {
  // no vars, nothing for constructor to do
}

function introduction () {
$intro = <<<EOT
<H2>Welcome to the Certainty Quiz!</H2>
The game that tests 
<LI>how much you know about how much <B>and</B> <LI>how much you know about
how much you know about how much!
<H4>The object</H4> The goal is to answer as many questions
correctly as possible.
Answer questions
(starting with the first one at the left), by choosing
values above and below where you think the right answer lies.  
Answers are correct if they include the real answer in the range.
The narrower your guesses, the longer you'll survive.
There are ten levels;  if you think the questions are 
too easy, keep going.
EOT;
  return($intro);
  }

function rules () {
$rules = <<<EOT
<H4>Rules and scoring</H4>
<LI>Four points subtracted from your credit for every incorrect answer.
<LI>One point added to your credit for every correct answer,
minus a penalty for the range of your answer.  Specifying the 
entire range possible subtracts four points (for a total of -3);  
specifying a single step of the range subtracts nothing
 (for a total of +1).  Intermediate ranges give intermediate results.
<LI>Credit is capped at 15.
<LI>Whenever your credit falls below zero, the game is over.
EOT;
  return($rules);
}

function gameLostText () {
$PHP_SELF = $_SERVER['PHP_SELF'];
$game_over = <<<EOT
<H1>Thanks for playing!</H1>
Thanks for taking the certainty quiz, and for being
such a good <FONT COLOR=RED>LOSER!</FONT><BR>
<FORM METHOD=POST ACTION="$PHP_SELF">
<INPUT TYPE=SUBMIT NAME=NEW VALUE="New Game">
<INPUT TYPE=HIDDEN NAME=POSTCHECK VALUE=1>
</FORM>
EOT;
return($game_over);
}

function gameWonText () {
$PHP_SELF = $_SERVER['PHP_SELF'];
$game_over = <<<EOT
<H1>You won!</H1>
Thanks for taking the certainty quiz, and for 
beating it.  We bow to your superior knowledge
of what you know, and what you don't know.
<FORM METHOD=POST ACTION="$PHP_SELF">
<INPUT TYPE=SUBMIT NAME=NEW VALUE="New Game">
<INPUT TYPE=HIDDEN NAME=POSTCHECK VALUE=1>
</FORM>
EOT;
return($game_over);
}

}
?>
