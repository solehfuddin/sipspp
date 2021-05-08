<!-- Sidenav -->
<nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
      <!-- Brand -->
      <div class="sidenav-header d-flex align-items-center">
        <a class="navbar-brand" href="<?= site_url('/admdashboard') ?>">
          <img src="<?= base_url() ?>/public/assets/img/brand/logo-smp.png" class="navbar-brand-img" alt="...">
        </a>
        <div class="ml-auto">
          <!-- Sidenav toggler -->
          <div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin" data-target="#sidenav-main">
            <div class="sidenav-toggler-inner">
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="navbar-inner">
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
          <!-- Nav items -->
          <ul class="navbar-nav">
            <li class="nav-item">
              <?php foreach($menu as $dt): ?>
                <?php if($dt->exist_submenu == 0) { ?>
                  <a class="nav-link" href="<?= site_url($dt->link_menu) ?>">
                    <i class="<?= $dt->icon . ' ' . $dt->style ?>"></i>
                    <span class="nav-link-text"><?= $dt->nama_menu ?></span>
                  </a>
                <?php }else{ ?>
                    <a class="nav-link" href="#navbar-examples" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-examples">
                      <i class="<?= $dt->icon . ' ' . $dt->style ?>"></i>
                      <span class="nav-link-text"><?= $dt->nama_menu ?></span>
                    </a>
                    <div class="collapse" id="navbar-examples">
                      <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                          <?php foreach($submenu as $sub): ?>
                            <a href="<?= site_url($sub->link_submenu) ?>" class="nav-link">
                              <?= $sub->nama_submenu ?>
                            </a>
                            <?php endforeach ?>
                        </li>
                      </ul>
                    </div>
                <?php } ?>
              <?php endforeach ?>
            </li>
          </ul>

          <!-- Divider -->
          <hr class="my-3">
        </div>
      </div>
    </div>
  </nav>