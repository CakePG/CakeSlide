<?php
  $this->layout = 'admin';
  $this->assign('title', __d('CakeSlide', 'Slide').'一覧 - '.__d('CakeSlide', 'Website Admin Title').' | '.__d('CakeSlide', 'Website Title'));
  $this->assign('keywords', '');
  $this->assign('description', '');
?>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?= $dashboardPath ?>"><i class="fa fa-home" aria-hidden="true"></i><?= __d('CakeSlide', 'Dashboard') ?></a></li>
  <li class="breadcrumb-item active" aria-current="page"><?= __d('CakeSlide', 'Slide') ?>一覧</li>
</ol>

<div class="container">
  <div class="row align-items-end mb-2">
    <div class="col-md">
      <h2><?= __d('CakeSlide', 'Slide') ?>一覧<hr class="d-none d-md-block"></h2>
    </div>
    <div class="col-md-auto">
      <nav class="nav nav-pills nav-fill">
        <?= $this->Html->link('<i class="fa fa-sort-amount-asc" aria-hidden="true"></i>並び替え', ['action' => 'sort'], ['class' => 'btn btn-warning', 'escape' => false]) ?>
        <?= $this->Html->link('<i class="fa fa-plus" aria-hidden="true"></i>新規登録', ['action' => 'add'], ['class' => 'btn btn-success', 'escape' => false]) ?>
      </nav>
    </div>
  </div>

  <?php if ($limit): ?>
    <p>順番に<?= $limit ?>枚までの画像がウェブサイトの<?= __d('CakeSlide', 'Slide') ?>に表示されます</p>
  <?php endif; ?>

  <table class="table admin">
    <thead>
      <tr>
        <th class="ids"><?= $this->Paginator->sort('priority', '順番') ?></th>
        <th><?= $this->Paginator->sort('name', 'ファイル名') ?></th>
        <th class="d-none d-md-table-cell"><?= $this->Paginator->sort('size', 'サイズ') ?></th>
        <th class="d-none d-md-table-cell"><?= $this->Paginator->sort('created', '作成日') ?></th>
        <th class="actions">操作</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($slides as $slide) : ?>
        <tr>
          <td class="ids"><?= $slide->published_msg ?> <?= $slide->priority ?></td>
          <td><?= h($slide->name) ?></td>
          <td class="d-none d-md-table-cell"><?= h($slide->size) ?></td>
          <td class="d-none d-md-table-cell"><?= h($slide->created->format('Y年m月d日')) ?></td>
          <td class="actions">
            <?= $this->Html->link('<i class="fa fa-eye" aria-hidden="true"></i>詳細', ['action' => 'view', $slide->id]+$this->request->query, ['escape' => false]) ?>
            <?= $this->Form->postLink('<i class="fa fa-trash" aria-hidden="true"></i>削除', ['action' => 'delete', $slide->id]+$this->request->query, ['escape' => false, 'confirm' => '『'.$slide->name.'』を本当に削除しますか？']) ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <?= $this->element('pagination') ?>
</div>
