<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $post
 */
?>

<?= $this->Html->script(['good'])?>
<p class="hidden user_id"><?= $_SESSION['Auth']['id'] ?></p>
<p class="hidden post_id"><?= $post->id ?></p>


<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?php if ($post->user_id == $_SESSION['Auth']['id']): ?>
              <?= $this->Html->link(__('Edit Post'), ['action' => 'edit', $post->id], ['class' => 'side-nav-item']) ?>
              <?= $this->Form->postLink(__('Delete Post'), ['action' => 'delete', $post->id], ['confirm' => __('Are you sure you want to delete # {0}?', $post->id), 'class' => 'side-nav-item']) ?>
              <?= $this->Html->link(__('List Posts'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
              <?= $this->Html->link(__('New Post'), ['controller'=>'books','action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?php endif; ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="posts view content">
            <h3><?= h($post->book->bookname) ?></h3>
            <table>
                <tr>
                    <th><?= __('User Name') ?></th>
                    <td><?= h($post->user->username); ?></td>
                </tr>
                <tr>
                    <th><?= __('Post Id') ?></th>
                    <td><?= $this->Number->format($post->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Recommends') ?></th>
                    <td>
                      <?php $count = $this->Number->format($post->recommends); ?>
                      <?php for($i=0; $i < $count; $i++) {
                            echo $this->Html->image('base/star-on.png');
                          }
                          if ($count != 5) {
                            for ($i=$count; $i < 5 ; $i++) {
                              echo $this->Html->image('base/star-off.png');
                            }
                          }
                      ?>
                    </td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($post->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($post->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($post->description)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Impression') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($post->impression)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('good') ?></strong>
                <blockquote>

                  <!-- 自分のレビューの場合 -->
                  <?php if (h($post->user_id)== $_SESSION['Auth']['id']) { ?>
                    <?= $this->Html->image('base/good.jpg',['class'=>'good', 'alt'=>'いいね！']) ?>
                  <?php }else{ ?>
                    <!-- 他人のレビューの場合 -->
                    <a id="good_add" href=""><?= $this->Html->image('base/good.jpg',['class'=>'good', 'alt'=>'いいね！']) ?></a>
                  <?php } ?>

                    <span> </span>
                    <?= $this->Html->link('件', ['controller'=> 'goods', 'action'=>'index', h($post->id)],['class'=>'good_count']) ?>



                </blockquote>
            </div>
        </div>
    </div>
</div>
