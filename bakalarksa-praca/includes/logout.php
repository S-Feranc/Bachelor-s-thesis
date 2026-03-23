<?php

session_start();
session_unset();
session_destroy();

echo "<script>alert('Úspešne odhlásený');";
echo "window.location.href = '../index.php';</script>";