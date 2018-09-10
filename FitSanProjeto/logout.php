<?php

require_once 'autenticacao.php';

deslogar(); 

header ('Location: form_login.php');
