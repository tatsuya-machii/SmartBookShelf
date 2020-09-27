<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Good[]|\Cake\Collection\CollectionInterface $goods
 */
?>
<div class="goods index content">
    <?= $this->Html->link(__('New Good'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Goods') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('post_id') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($goods as $good): ?>
                <tr>
                    <td><?= $this->Number->format($good->id) ?></td>
                    <td><?= $good->has('user') ? $this->Html->link($good->user->username, ['controller' => 'Users', 'action' => 'view', $good->user->id]) : '' ?></td>
                    <td><?= $good->has('post') ? $this->Html->link($good->post->id, ['controller' => 'Posts', 'action' => 'view', $good->post->id]) : '' ?></td>
                    <td><?= h($good->created) ?></td>
                    <td><?= h($good->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $good->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $good->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $good->id], ['confirm' => __('Are you sure you want to delete # {0}?', $good->id)]) ?>
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
