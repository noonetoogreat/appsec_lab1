<?php

session_start();

// Make sure we have a canary set
if (!isset($_SESSION['canary'])) {
    session_regenerate_id(true);
    $_SESSION['canary'] = time();
}
// Regenerate session ID every five minutes:
if ($_SESSION['canary'] < time() - 300) {
    session_regenerate_id(true);
    $_SESSION['canary'] = time();
}

?>