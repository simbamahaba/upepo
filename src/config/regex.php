<?php

# Validation regex
return [
    'alpha_dash_space' => "/^[A-Za-z \-ĂÎÂŞŢăîâşţ]+$/",
    'alpha_dash_space_num' => "/^([A-Za-zĂÂÎŞŢăâîşţ0-9]+[\s\-]?[A-Za-zĂÂÎŞŢăâîşţ0-9]+)+$/",
    'num' => "/^[0-9]+$/",
    'address' => "/^[A-Za-zĂÎÂŞŢăîâşţ0-9\.\-\s\,]+$/",
    'body_message' => "/^[^'\"<>*^]+$/",
    'alphaNumSlash' => "/^[A-Za-z0-9\/\-\.]+$/",

];