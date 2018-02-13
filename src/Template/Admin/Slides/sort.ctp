<?php
  $this->layout = 'admin';
  $this->assign('title', __d('CakeSlide', 'Slide').'並び替え - '.__d('CakeSlide', 'Website Admin Title').' | '.__d('CakeSlide', 'Website Title'));
  $this->assign('keywords', '');
  $this->assign('description', '');
?>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?= $dashboardPath ?>"><i class="fa fa-home" aria-hidden="true"></i><?= __d('CakeSlide', 'Dashboard') ?></a></li>
  <li class="breadcrumb-item"><?= $this->Html->link(__d('CakeSlide', 'Slide').'一覧', ['action' => 'index']+$this->request->query) ?></li>
  <li class="breadcrumb-item active" aria-current="page"><?= __d('CakeSlide', 'Slide') ?>並び替え</li>
</ol>

<div class="container">
  <div class="row align-items-end mb-2">
    <div class="col-md">
      <h2><?= __d('CakeSlide', 'Slide') ?>並び替え<hr class="d-none d-md-block"></h2>
    </div>
    <div class="col-md-auto">
      <nav class="nav nav-pills nav-fill">
      </nav>
    </div>
  </div>

  <div class="card admin">
    <div class="card-header">
      <nav class="nav nav-pills nav-fill">
        <?= $this->Html->link('<i class="fa fa-angle-double-left" aria-hidden="true"></i>一覧へ', ['action' => 'index'], ['class' => 'btn btn-sm btn-light', 'escape' => false]) ?>
      </nav>
    </div>
    <div class="card-body">
      <?= $this->Form->create(null, ['templates' => 'app_form_bootstrap']); ?>
      <p>
        ドラッグ アンド ドロップで掲載順序を変更出来ます。
      </p>
      <ul id="sortList" class="list-group">
        <?php $count = 0; ?>
        <?php foreach ($slides as $slide) : ?>
          <?php $count += 1; ?>
          <li data-id="<?= h($slide->id) ?>" data-no="<?= $count ?>" class="list-group-item">
            <?= h($slide->name) ?>
          </li>
        <?php endforeach; ?>
      </ul>
      <?= $this->Form->control('orders',['id' => 'sortOrder', 'class' => 'd-none', 'label' => false, 'type' => 'text']) ?>
      <?= $this->Form->submit('並び替え', ['class' => 'btn btn-lg btn-primary btn-block']) ?>
      <?= $this->Form->end() ?>
    </div>
  </div>
</div>
