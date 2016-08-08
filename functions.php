<?php

/**
 * echo out a url to a file
 * @param string $path the path to link to
 */
function url($path = ''){
    echo 'http://' . $_SERVER['SERVER_NAME'] . '/' . $path;
}
