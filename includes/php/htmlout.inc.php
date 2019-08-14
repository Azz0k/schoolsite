<?php
function htmlOut($text){
    echo htmlspecialchars($text, ENT_QUOTES,'UTF-8');
}
