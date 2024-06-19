<?php
function genrandomString() {
    return uniqid(bin2hex(random_bytes(5)), true);
}

