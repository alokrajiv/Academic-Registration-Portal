<?php

session_start();
session_destroy();
echo 'logged out';
echo '<script>location.href="/"</script>';

