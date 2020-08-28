<!-- File: templates/Articles/index.php  (削除リンク付き) -->

<h1>記事一覧</h1>
<p><?= $this->Html->link("記事の追加", ['action' => 'add']) ?></p>
<table>
    <tr>
        <th>タイトル</th>
        <th>作成日時</th>
        <th>操作</th>
    </tr>

<!-- ここで、$articles クエリーオブジェクトを繰り返して、記事情報を出力します -->

<?php foreach ($articles as $article): ?>
    <tr>
        <td>
            <!-- link(バリュー, [リンク先のアクション名, パラメータ]) -->
            <?= $this->Html->link($article->title, ['action' => 'view', $article->slug]) ?>
        </td>
        <td>
            <!-- define ('DATE_RFC850', "l, d-M-y H:i:s T"); -->
            <?= $article->created->format(DATE_RFC850) ?>
        </td>
        <td>
            <?= $this->Html->link('編集', ['action' => 'edit', $article->slug]) ?>
            <!-- JavaScript の確認ダイアログを表示してpostする -->
            <?= $this->Form->postLink(
                '削除',
                ['action' => 'delete', $article->slug],
                ['confirm' => 'この記事を削除してよろしいですか?'])
            ?>
        </td>
    </tr>
<?php endforeach; ?>

</table>