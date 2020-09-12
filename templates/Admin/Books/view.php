<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $book
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Book'), ['action' => 'edit', $book->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Book'), ['action' => 'delete', $book->id], ['confirm' => __('Are you sure you want to delete # {0}?', $book->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Books'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Book'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="books view content">
            <h3><?= h($book->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Bookname') ?></th>
                    <td><?= h($book->bookname) ?></td>
                </tr>
                <tr>
                    <th><?= __('Author') ?></th>
                    <td><?= h($book->author) ?></td>
                </tr>
                <tr>
                    <th><?= __('Publisher') ?></th>
                    <td><?= h($book->publisher) ?></td>
                </tr>
                <tr>
                    <th><?= __('Image') ?></th>
                    <td><?= h($book->image) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($book->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= $this->Number->format($book->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($book->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($book->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
