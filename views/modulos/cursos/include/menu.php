<li class="nav-item">
    <a href="<?= SERVERURL ?>cursos/inicio" class="nav-link" id="inicio">
        <i class="fa fa-home nav-icon"></i>
        <p>Home</p>
    </a>
</li>

<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>
            Pessoa
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="<?= SERVERURL ?>producao/evento_novo" class="nav-link" id="evento_novo">
                <i class="far fa-circle nav-icon"></i>
                <p>Novos</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= SERVERURL ?>producao/evento_verificado" class="nav-link" id="evento_verificado">
                <i class="far fa-circle nav-icon"></i>
                <p>Verificados</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= SERVERURL ?>producao/pesquisar_evento" class="nav-link" id="exportar_evento">
                <i class="far fa-circle nav-icon"></i>
                <p>Exportar</p>
            </a>
        </li>
    </ul>
</li>
<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>
            Curso
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="<?= SERVERURL ?>cursos/curso_lista" class="nav-link" id="curso_lista">
                <i class="far fa-circle nav-icon"></i>
                <p>Lista de Cursos</p>
            </a>
        </li>
    </ul>
</li>