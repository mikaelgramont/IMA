<?php
Auth::saveAuthStatus(Auth::getIdentity(), false);
header("Location:" . BASE_URL);
exit();