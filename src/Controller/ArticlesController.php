<?php
// ユーザーが www.example.com/articlesにリクエストした場合、ArticlesControllerのindexメソッドが呼び出される

// src/Controller/ArticlesController.php

namespace App\Controller;

use App\Controller\AppController;

class ArticlesController extends AppController
{
    public function initialize(): void
    {
        // 必ず必要
        parent::initialize();
        // コンポーネントをロード
        $this->loadComponent('Paginator');
        $this->loadComponent('Flash'); // フォームの処理後やデータの確認のために表示する一回限りのメッセージ通知
    }

    public function index()
    {
        $this->loadComponent('Paginator');
        // Articlesテーブルの記事を全てページネーションした状態で出力
        $articles = $this->Paginator->paginate($this->Articles->find());
        $this->set(compact('articles'));
    }



    public function view($slug = null)
    {
        // findByカラム名(値)　そのカラムで値が一致するデータを取ってくる
        // firstOrFail()：first()メソッドの例外付きバージョンで戻り値が０件であった場合に例外を投げる
        // $article = $this->Articles->findBySlug($slug)->firstOrFail();

        // ユーザーtableからの情報も含んでビューに渡す
        $article = $this->Articles->get($slug, [
            'contain' => 'Users'
        ]);
        $this->set(compact('article'));
    }



    public function add()
    {
        // データの検証の詳細は、hoge/Table.phpのvalidationメソッドに書く
        // newEntity：新規追加、保存処理時　データの検証を行う
        // newEnptyEntity：新規追加、保存処理時　データの検証を行わない
        // patchEntity：データの更新時　データの検証を行う
        // patchEntity(エンティティ, 保存するデータ)でマージ→save(エンティティ)

        $article = $this->Articles->newEmptyEntity();
        if ($this->request->is('post')) {
            $article = $this->Articles->patchEntity($article, $this->request->getData());

            // user_id の決め打ちは一時的なもので、あとで認証を構築する際に削除されます。
            $article->user_id = 1;

            if ($this->Articles->save($article)) {
                $this->Flash->success(__('記事が保存されました'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('記事が保存できませんでした'));
        }
        // タグのリストを取得
        $tags = $this->Articles->Tags->find('list');

        // ビューコンテキストに tags をセット
        $this->set('tags', $tags);

        // エンティティをビューに渡す
        $this->set('article', $article);
    }



    public function edit($slug)
    {
        // スラグでレコードを指定
        $article = $this->Articles->findBySlug($slug)->contain('Tags')->firstOrFail();

        if ($this->request->is(['post', 'put'])) {
            $this->Articles->patchEntity($article, $this->request->getData());
            if ($this->Articles->save($article)) {
                $this->Flash->success(__('記事が更新されました'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('記事の更新ができませんでした'));
        }
        // タグのリストを取得
        $tags = $this->Articles->Tags->find('list');

        // ビューコンテキストに tags をセット
        $this->set('tags', $tags);

        $this->set('article', $article);
    }



    public function delete($slug)
    {
        // postとdelete以外のリクエストはエラー
        $this->request->allowMethod(['post', 'delete']);

        $article = $this->Articles->findBySlug($slug)->firstOrFail();
        if ($this->Articles->delete($article)) {
            $this->Flash->success(__('The {0} article has been deleted.', $article->title));
            return $this->redirect(['action' => 'index']);
        }
    }



    public function tags()
    {
        // 'pass' キーは CakePHP によって提供され、リクエストに渡された
        // 全ての URL パスセグメントを含みます。
        $tags = $this->request->getParam('pass');

        // ArticlesTable を使用してタグ付きの記事を検索します。
        $articles = $this->Articles->find('tagged', [
            'tags' => $tags
        ]);

        // 変数をビューテンプレートのコンテキストに渡します。
        $this->set([
            'articles' => $articles,
            'tags' => $tags
        ]);
    }
}
