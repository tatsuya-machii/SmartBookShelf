<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $post
 */
?>
<?= $this->Html->script('recommends'); ?>

<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Posts'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="posts form content">
            <?= $this->Form->create($post) ?>
            <fieldset>
                <legend><?= __('Add Post') ?></legend>
                <p><?= $book['bookname'] ?></p>
                <?php if (!empty($book['image'])){ ?>
                  <?= $this->Html->image($book['image']); ?>
                <?php }else{ ?>
                  <i class="fas fa-book-open"></i>
                <?php }; ?>
                <?php
                    echo $this->Form->control('recommends',['type'=>"range", 'name'=>"recommends", 'min'=>"1", 'max'=>"5", 'value'=>"1", 'class'=>"hidden input-range"]);
                ?>
                <!-- 非同期で星クリック時の動作＋上記recommendsのrange連動 -->
                <div class="ajax_range">
                  <?php
                    echo $reccomends = $this->Html->image('base/star-on.png',['url'=>["action"=>""]]);
                    for ($i=0; $i < 4; $i++) {
                      echo $reccomends  = $this->Html->image('base/star-off.png',['url'=>['action'=>'']]);
                    }
                  ?>
                </div>
                <?php
                    echo $this->Form->control('description');
                    echo $this->Form->control('impression');
                    echo $this->Form->control('user_id',['class'=>'hidden', 'value'=>$_SESSION['Auth']['id'], 'label'=>false]);
                    echo $this->Form->control('book_id',['class'=>'hidden', 'value'=>$book['id'], 'label'=>false]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
