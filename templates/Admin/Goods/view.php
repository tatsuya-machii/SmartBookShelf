<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Good $good
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Good'), ['action' => 'edit', $good->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Good'), ['action' => 'delete', $good->id], ['confirm' => __('Are you sure you want to delete # {0}?', $good->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Goods'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Good'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="goods view content">
            <h3><?= h($good->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $good->has('user') ? $this->Html->link($good->user->username, ['controller' => 'Users', 'action' => 'view', $good->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Post') ?></th>
                    <td><?= $good->has('post') ? $this->Html->link($good->post->id, ['controller' => 'Posts', 'action' => 'view', $good->post->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($good->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($good->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($good->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
