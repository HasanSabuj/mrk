<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Marketing Team Management System</title>
    <!-- Animate.css -->
    <?php
        $main = array(
                'href'  => 'public/css/main.css',
                'rel'   => 'stylesheet',
                'type'  => 'text/css',
                'media' => 'screen'
        );

        echo link_tag($main);
    ?>
    <!-- Custom Theme Style -->
    <?php
        $customMin = array(
                'href'  => 'public/css/custom.css',
                'rel'   => 'stylesheet',
                'type'  => 'text/css',
                'media' => 'screen'
        );

        echo link_tag($customMin);
    ?>
    <?php
        if(isset($page_css)){
            echo $page_css;
        }
    ?>
  </head>
