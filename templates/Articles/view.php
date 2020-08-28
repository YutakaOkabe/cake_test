<!-- File: templates/Articles/view.php -->

<h1><?= h($article->title) ?></h1>
<p><?= h($article->body) ?></p>
<p><small>作成日時: <?= $article->created->format(DATE_RFC850) ?></small></p>
<p><small>投稿者: <?= $article->user->format(DATE_RFC850) ?></small></p>

<p><?= $this->Html->link('編集', ['action' => 'edit', $article->slug]) ?></p>