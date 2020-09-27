<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Book[]|\Cake\Collection\CollectionInterface $books
 */
?>
<?=  $this->Html->script(['book_search']) ?>

<div class="books index content">
    <?= $this->Html->link(__('New Book'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3>Choice a Book</h3>

    <!-- 入力フォーム -->
    <form class="clearfix">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <p><strong>本のタイトル</strong></p>
        <input class="search name" type="text" name="search_name" placeholder="本のタイトル">
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <p><strong>著者</strong></p>
        <input class="search author" type="text" name="search_author" placeholder="著者">
      </div>
    </form><!-- 入力フォーム -->

      <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('image') ?></th>
                    <th><?= $this->Paginator->sort('bookname') ?></th>
                    <th><?= $this->Paginator->sort('author') ?></th>
                    <th><?= $this->Paginator->sort('publisher') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody id='ajax_books_lists'>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
