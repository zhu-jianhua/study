<?php
// Include code files, start up session
include_once("certainty_utils.php");
include_once("game_display_class.php");
session_start();

// Determine state and handle post arguments

try {

  // CASE 1: Player is submitting name for high score list
  if (get_session_value('game') &&
      get_post_value('HIGHSCORE')) {
    if (get_session_value('game') &&
      get_post_value('HIGHSCORE')) {
      $game_display = 
      new GameDisplay(get_session_value('game'));
                      $game_display->handleHighScore();
    }
  }

  // CASE 2: Player is in middle of game that we are tracking
  elseif (get_session_value('game') &&
          !get_post_value('NEW')) {
    $lower = get_post_value('lower');
    $upper = get_post_value('upper');
    $game_display = 
      new GameDisplay(get_session_value('game'));
    $game_display->updateWithAnswer($lower, $upper);
  }

  // CASE 3: Player has either just arrived or has 
  //   finished a game and asked for a new one.
  elseif (!get_post_value('POSTCHECK') ||
          get_post_value('NEW')) {
    $game_display = new GameDisplay(new Game());
  }

  // CASE 4:  Something is wrong.
  // The page is the result of a POST operation,
  // yet we don't seem to have a live session, so
  // we are not successfully tracking a game.
  // The only thing to do is complain, and ask about 
  // cookies.
  else {
    $game_display = 
      new GameDisplay(new Game());
    throw (new Exception("We couldn't track your game." .
          "You may have to enable cookies to play"));
  }

  // Construct string that will be displayed as page
  $page_string = $game_display->display();
  // Store game state in session so that next
  //   page can pick it up
    set_session_value('game',
      $game_display->_game);

} // end of try block

catch (Exception $exception) {
  // There is a problem somewhere.  Create
  //   an error page.
  $exception_msg = $exception->getMessage();
  $display = new GameDisplay(null);  
  $page_string = 
    $display->makeErrorPage($exception_msg);
  // hope to start fresh next time
  unset_session_value('game');
}

// Actually echo page to browser

  echo($page_string);

?>
