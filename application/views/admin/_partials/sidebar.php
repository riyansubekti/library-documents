<!-- Sidebar -->
<ul class="sidebar navbar-nav">
    <!-- <li class="nav-item <?php echo $this->uri->segment(2) == '' ? 'active': '' ?>">
        <a class="nav-link" href="<?php echo site_url('admin') ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Overview</span>
        </a>
    </li> -->
    <li class="nav-item <?php echo $this->uri->segment(2) == 'documents' ? 'active': '' ?>">
        <a class="nav-link" href="<?php echo site_url('admin/documents') ?>">
            <i class="fas fa-fw fa-boxes"></i>
            <span>Documents</span></a>
    </li>
    <?php if($this->user_model->isRole()){ echo '
    <li class="nav-item ';echo $this->uri->segment(2) == 'users' ? 'active': '';echo'">
        <a class="nav-link" href="';echo site_url('admin/users');echo'">
            <i class="fas fa-fw fa-users"></i>
            <span>Users</span></a>
    </li>
    ';}?>
    <li class="nav-item">
        <a class="nav-link" href="<?= site_url('admin/login/logout') ?>">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>logout</span></a>
    </li>
    <!--
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-cog"></i>
            <span>Settings</span></a>
    </li>
    -->
</ul>
