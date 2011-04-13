<?php

header("Expires: ".gmdate());
header("Content-type: image/jpeg");
readfile("webcam.jpg");

?>