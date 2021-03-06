<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Friend[]|\Cake\Collection\CollectionInterface $friends
 */
?>
<div class="friends index content">
    <?= $this->Html->link(__('New Friend'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Friends') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('friends_id') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($friends as $friend): ?>
                <tr>
                    <td><?= $this->Number->format($friend->id) ?></td>
                    <td><?= $this->Number->format($friend->user_id) ?></td>
                    <td><?= $friend->has('user') ? $this->Html->link($friend->user->username, ['controller' => 'Users', 'action' => 'view', $friend->user->id]) : '' ?></td>
                    <td><?= h($friend->created) ?></td>
                    <td><?= h($friend->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $friend->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $friend->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $friend->id], ['confirm' => __('Are you sure you want to delete # {0}?', $friend->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
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
