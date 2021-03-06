<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $post
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $post->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $post->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Posts'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="posts form content">
          <?= $this->Form->create($post) ?>
            <fieldset>
                <legend><?= __('Edit Post') ?></legend>
                <?php
                    echo $this->Form->control('recommends');
                    echo $this->Form->control('description');
                    echo $this->Form->control('impression');
                    echo $this->Form->control('user_id',['class'=>'hidden', 'value'=>$post['user_id'], 'label'=>false]);
                    echo $this->Form->control('book_id',['class'=>'hidden', 'value'=>$post['book_id'], 'label'=>false]);
                ?>

            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
