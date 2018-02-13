<?php
  $this->layout = 'admin';
  $this->assign('title', __d('CakeSlide', 'Slide').'詳細 - '.__d('CakeSlide', 'Website Admin Title').' | '.__d('CakeSlide', 'Website Title'));
  $this->assign('keywords', '');
  $this->assign('description', '');
?>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?= $dashboardPath ?>"><i class="fa fa-home" aria-hidden="true"></i><?= __d('CakeSlide', 'Dashboard') ?></a></li>
  <li class="breadcrumb-item"><?= $this->Html->link(__d('CakeSlide', 'Slide').'一覧', ['action' => 'index']+$this->request->query) ?></li>
  <li class="breadcrumb-item active" aria-current="page"><?= __d('CakeSlide', 'Slide') ?>詳細</li>
</ol>

<div class="container">
  <div class="row align-items-end mb-2">
    <div class="col-md">
      <h2><?= __d('CakeSlide', 'Slide') ?>詳細<hr class="d-none d-md-block"></h2>
    </div>
    <div class="col-md-auto">
      <nav class="nav nav-pills nav-fill">
        <?= $this->Form->postLink('<i class="fa fa-trash" aria-hidden="true"></i>削除', ['action' => 'delete', $slide->id]+$this->request->query, ['class' => 'btn btn-danger', 'escape' => false, 'confirm' => '『'.$slide->name.'』を本当に削除しますか？']) ?>
      </nav>
    </div>
  </div>

  <div class="card admin">
    <div class="card-header">
      <nav class="nav nav-pills nav-fill">
        <?= $this->Html->link('<i class="fa fa-angle-double-left" aria-hidden="true"></i>一覧へ', ['action' => 'index']+$this->request->query, ['class' => 'btn btn-sm btn-light', 'escape' => false]) ?>
      </nav>
    </div>
    <div class="card-body">
      <dl>
        <dt>ファイル名</dt>
        <dd><?= h($slide->name) ?></dd>

        <dt>サイズ</dt>
        <dd><?= h($slide->size) ?></dd>

        <dt>画像</dt>
        <dd>
          <img class="img-thumbnail" src="<?= $slide->asset_url ?>" alt="<?= h($slide->name) ?>">
        </dd>

        <dt>作成日</dt>
        <dd><?= h($slide->created) ?></dd>
      </dl>
    </div>
  </div>
</div>
