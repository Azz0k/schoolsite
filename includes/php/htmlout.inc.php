<?php
function htmlOut(string $text){
    echo htmlspecialchars($text, ENT_QUOTES,'UTF-8');
}
