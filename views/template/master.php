<?php
$template = new ViewsController();

$pedidoAjax = false;

$view = $template->exibirViewController();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>CURSOS | SMC</title>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?= SERVERURL ?>node_modules/@fortawesome/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= SERVERURL ?>views/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="<?= SERVERURL ?>views/dist/css/custom.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?= SERVERURL ?>node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="<?= SERVERURL ?>node_modules/daterangepicker/daterangepicker.css">
    <!-- Sweet Alert 2 -->
    <script src="<?= SERVERURL ?>node_modules/sweetalert2/dist/sweetalert2.js"></script>
    <link rel="stylesheet" href="<?= SERVERURL ?>node_modules/sweetalert2/dist/sweetalert2.css">
    <!-- summernote -->
    <link rel="stylesheet" href="<?= SERVERURL ?>node_modules/summernote/dist/summernote-bs4.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- jQuery -->
    <script src="<?= SERVERURL ?>node_modules/jquery/dist/jquery.min.js"></script>
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= SERVERURL ?>views/dist/img/logo.png" />
    <link rel="icon" href="<?= SERVERURL ?>views/dist/img/logo.png" />
    <!-- Select2 -->
    <link rel="stylesheet" href="<?= SERVERURL ?>node_modules/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="<?= SERVERURL ?>node_modules/admin-lte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
</head>
<!--<body class="hold-transition login-page">-->
<body class="hold-transition sidebar-mini">
<?php

$view = $template->exibirViewController();
if ($view == 'index'):
    require_once "./views/modulos/inicio/login.php";
elseif ($view == 'login'):
    require_once "./views/modulos/inicio/login.php";
elseif ($view == 'cadastro'):
    require_once "./views/modulos/inicio/cadastro.php";
elseif ($view == 'recupera_senha'):
    require_once "./views/modulos/inicio/recupera_senha.php";
elseif($view == 'resete_senha'):
    require_once "./views/modulos/inicio/resete_senha.php";
else:
    session_start(['name' => 'sis']);
    require_once "./controllers/UsuarioController.php";
    $usuario = new UsuarioController();

    if (!isset($_SESSION['usuario_id_s'])) {
        $usuario->forcarFimSessao();
    }
    ?>
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <?php $template->navbar(); ?>
        </nav>
        <!-- /.navbar -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <?php include $view ?>
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <?php include $template->sidebar(); ?>
        </aside>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="p-3">
                <h5>Sobre</h5>
                <p>Versão 2.0</p>
                <br>
                <p>Desenvolvido por:</p>
            </div>
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <?php $template->footer() ?>
        </footer>
    </div>
    <!-- ./wrapper -->
<?php endif; ?>
<!-- REQUIRED SCRIPTS -->
<?php if(isset($sectionJS))
        echo $sectionJS;
?>

<!-- jQuery -->
<script src="<?= SERVERURL ?>node_modules/jquery/dist/jquery.min.js"></script>
<script src="<?= SERVERURL ?>node_modules/moment/moment.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= SERVERURL ?>node_modules/admin-lte/plugins/bootstrap/js/bootstrap.bundle.js"></script>
<!-- AdminLTE App -->
<script src="<?= SERVERURL ?>views/dist/js/adminlte.min.js"></script>
<!-- Summernote -->
<script src="<?= SERVERURL ?>node_modules/summernote/dist/summernote-bs4.min.js"></script>
<script src="<?= SERVERURL ?>node_modules/summernote/dist/lang/summernote-pt-BR.js"></script>
<!--<script src="--><?//= SERVERURL ?><!--node_modules/summernote/summernote-cleaner.js"></script>-->
<!-- Outros Scripts -->
<script src="<?= SERVERURL ?>views/dist/js/main.js"></script>
<script src="<?= SERVERURL ?>node_modules/jquery-mask-plugin/dist/jquery.mask.js"></script>
<!-- DataTables -->
<script src="<?= SERVERURL ?>node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= SERVERURL ?>node_modules/datatables.net-bs4/js/dataTables.bootstrap4.js"></script>
<script src="<?= SERVERURL ?>node_modules/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= SERVERURL ?>node_modules/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<script src="<?= SERVERURL ?>node_modules/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= SERVERURL ?>node_modules/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
<script src="<?= SERVERURL ?>node_modules/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?= SERVERURL ?>node_modules/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="<?= SERVERURL ?>node_modules/jszip/dist/jszip.min.js"></script>
<script src="<?= SERVERURL ?>node_modules/pdfmake/build/pdfmake.min.js"></script>
<script src="<?= SERVERURL ?>node_modules/pdfmake/build/vfs_fonts.js"></script>
<!-- date-range-picker -->
<script src="<?= SERVERURL ?>node_modules/daterangepicker/daterangepicker.js"></script>
<!-- Select2 -->
<script src="<?= SERVERURL ?>node_modules/select2/dist/js/select2.full.min.js"></script>
<script src="<?= SERVERURL ?>node_modules/select2/dist/js/i18n/pt-BR.js" type="text/javascript"></script>

<?= (isset($javascript)) ? $javascript : ''; ?>
</body>
</html>