<?php
session_start(['name' => 'sis']);
session_destroy();
echo '<script> window.location.href="'. SERVERURL .'" </script>';