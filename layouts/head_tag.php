<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta
    content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no"
    name="viewport" />
  <title><?= 'Praktikum PemWeb - ' . $title; ?></title>
  <link rel="shortcut icon" href="#">
  <!-- General CSS Files -->
  <link
    rel="stylesheet"
    href="<?= BASEPATH; ?>assets/modules/bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" href="<?= BASEPATH; ?>assets/modules/fontawesome/css/all.min.css" />

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="<?= BASEPATH; ?>assets/modules/jqvmap/dist/jqvmap.min.css" />
  <link
    rel="stylesheet"
    href="<?= BASEPATH; ?>assets/modules/weather-icon/css/weather-icons.min.css" />
  <link
    rel="stylesheet"
    href="<?= BASEPATH; ?>assets/modules/weather-icon/css/weather-icons-wind.min.css" />
  <link
    rel="stylesheet"
    href="<?= BASEPATH; ?>assets/modules/summernote/summernote-bs4.css" />

  <!-- Template CSS -->
  <link rel="stylesheet" href="<?= BASEPATH; ?>assets/css/style.css" />
  <link rel="stylesheet" href="<?= BASEPATH; ?>assets/css/components.css" />
  <!-- Start GA -->
  <script
    async
    src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag("js", new Date());

    gtag("config", "UA-94034622-3");
  </script>
  <!-- /END GA -->
  <script src="<?= BASEPATH; ?>assets/modules/jquery.min.js"></script>
</head>

<body>
  <div id="app">