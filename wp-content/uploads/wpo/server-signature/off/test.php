<?php
if (isset($_SERVER['SERVER_SIGNATURE']) && ($_SERVER['SERVER_SIGNATURE'] != '')) {
    echo 0;
} else {
    echo 1;
}