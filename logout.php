<?php
/**
 * Created by PhpStorm.
 * User: NSC
 * Date: 11/10/2018
 * Time: 10:54 AM
 */
session_start();
session_destroy();
header('location: login');