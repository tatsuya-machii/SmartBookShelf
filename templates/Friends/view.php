<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Friend $friend
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Friend'), ['action' => 'edit', $friend->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Friend'), ['action' => 'delete', $friend->id], ['confirm' => __('Are you sure you want to delete # {0}?', $friend->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Friends'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Friend'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="friends view content">
            <h3><?= h($friend->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $friend->has('user') ? $this->Html->link($friend->user->username, ['controller' => 'Users', 'action' => 'view', $friend->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($friend->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Friends Id') ?></th>
                    <td><?= $this->Number->format($friend->friends_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($friend->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($friend->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
