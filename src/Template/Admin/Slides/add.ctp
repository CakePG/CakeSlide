<?php
  $this->layout = 'admin';
  $this->assign('title', __d('CakeSlide', 'Slide').'登録 - '.__d('CakeSlide', 'Website Admin Title').' | '.__d('CakeSlide', 'Website Title'));
  $this->assign('keywords', '');
  $this->assign('description', '');
?>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?= $dashboardPath ?>"><i class="fa fa-home" aria-hidden="true"></i><?= __d('CakeSlide', 'Dashboard') ?></a></li>
  <li class="breadcrumb-item"><?= $this->Html->link(__d('CakeSlide', 'Slide').'一覧', ['action' => 'index']+$this->request->query) ?></li>
  <li class="breadcrumb-item active" aria-current="page"><?= __d('CakeSlide', 'Slide') ?>登録</li>
</ol>

<div class="container">
  <div class="row align-items-end mb-2">
    <div class="col-md">
      <h2><?= __d('CakeSlide', 'Slide') ?>登録<hr class="d-none d-md-block"></h2>
    </div>
    <div class="col-md-auto">
      <nav class="nav nav-pills nav-fill">
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
      <?php if($imageSetting['fixed']): ?>
        <p>画像は横（<?= $imageSetting['fixed'][0] ?>px） × 縦（<?= $imageSetting['fixed'][1] ?>px）にリサイズされます</p>
      <?php endif; ?>
      <?= $this->Form->create($slide, ['type' => 'file', 'templates' => 'app_form_bootstrap']); ?>
      <?php
        echo $this->Form->control('name', ['label'=>'名前（画像の説明）', 'class'=>'form-control']);
        echo $this->Form->control('file', ['label'=>__d('CakeSlide', 'Slide').'画像', 'class'=>'form-control', 'type'=>'file']);
      ?>
      <?= $this->Form->submit('保存', ['class' => 'btn btn-lg btn-primary btn-block']) ?>
      <?= $this->Form->end() ?>
    </div>
  </div>
</div>
