<!-- File: templates/Articles/view.php -->
<h1><?= h($article->title) ?></h1>
<p><?= h($article->body) ?></p>

<p><small>作成日時: <?= $article->created->format(DATE_RFC850) ?></small></p>
<p><small>タグ:
        <?php $tags = $article->tags ?>
        <?php foreach ($tags as $tag) : ?>
            <?php echo h($tag->title); ?>
        <?php endforeach; ?>
    </small></p>
<p><small>投稿者:<?php echo h($article->user->email) ?></small></p>

<p><?= $this->Html->link('編集', ['action' => 'edit', $article->slug]) ?></p>