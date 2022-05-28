<?php
require('../../dbconnect.php');

$sql = "SELECT company_name FROM company";
$stmt = $db->prepare($sql);
$stmt->execute();
$names = $stmt->fetchAll();
?>
<!-- <?php foreach ($names as $name) : ?>
<?php print_r($name); ?>
<?php print_r($name['company_name']); ?>
<?php endforeach; ?> -->

<!doctype html>
<html lang="ja">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="stylesheet" href="../../normalize.css">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <!-- bootstrap icon -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="./boozer_user.css">
  <link rel="stylesheet" href="../parts.css">

  <title>bozer学生一覧</title>
</head>

<!-- header関数読み込み -->
<?php
include('./_parts_boozer/_header_boozer.php');  
?>
<div class="container_all">
  <!-- View Modal -->
  <div class="modal fade" id="userViewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel">会社詳細</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body view_container">
            <div class="col-md-6 pb-2">
              <h5>ID</h5>
              <p class="id_view"></p>
            </div>
            <div class="col-md-6 pb-2">
              <h5>名前</h5>
              <p class="name_view"></p>
            </div>
            <div class="col-md-6 pb-2">
              <h5>会社名</h5>
              <p class="company_name_view"></p>
            </div>
            <div class="col-md-6 pb-2">
              <h5>大学名</h5>
              <p class="university_view"></p>
            </div>
            <div class="col-md-6 pb-2">
              <h5>学部</h5>
              <p class="department_view"></p>
            </div>
            <div class="col-md-6 pb-2">
              <h5>卒業年</h5>
              <p class="grad_year_view"></p>
            </div>
            <div class="col-md-6  pb-2">
              <h5>メールアドレス</h5>
              <p class="mail_view"></p>
            </div>
            <div class="col-md-6 pb-2">
              <h5>電話番号</h5>
              <p class="phone_number_view"></p>
            </div>
            <div class="col-md-6 pb-2">
              <h5>住所</h5>
              <p class="address_view"></p>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


  <!-- Edit Modal -->
  <!-- add modal から変更 -->
  <div class="modal fade" id="userEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">変更する</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <input type="hidden" id="id_edit">
            <div class="col-md-12">
              <div class="error-message">
              </div>
            </div>
            <!-- add modalからもってきてクラス名をIDに変更 -->
            <div class="col-md-6">
              <label for="">名前</label>
              <input type="text" class="form-control" id="name_edit">
            </div>
            <div class="col-md-6">
              <label for="">大学名</label>
              <input type="text" class="form-control" id="university_edit">
            </div>
            <div class="col-md-6">
              <label for="">学部</label>
              <input type="text" class="form-control" id="department_edit">
            </div>
            <div class="col-md-6">
              <label for="">卒業年</label>
              <input type="text" class="form-control" id="grad_year_edit">
            </div>
            <div class="col-md-6">
              <label for="">メールアドレス</label>
              <input type="text" class="form-control" id="mail_edit">
            </div>
            <div class="col-md-6">
              <label for="">電話番号</label>
              <input type="text" class="form-control" id="phone_number_edit">
            </div>
            <div class="col-md-6">
              <label for="">住所</label>
              <input type="text" class="form-control" id="address_edit">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary user_update_ajax">Update</button>
        </div>
      </div>
    </div>
  </div>


  <!-- Delete Modal -->
  <div class="modal fade" id="userDeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">削除する</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <input type="hidden" id="id_delete">
            <input type="hidden" id="company_name_delete">
            <div class="col-md-12">
              <h3>本当に削除しますか？</h3>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
          <button type="button" class="btn btn-danger user_delete_ajax">削除</button>
        </div>
      </div>
    </div>
  </div>
  </div>

  <!-- 表示されている箇所 -->
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4 class='hh'>
              学生一覧
            </h4>
          </div>
          <div class="card-body">
            <div class='search_container'>
              <div class='user_list_search_text'>
                <input type="text" class='form-control' id='live_search' name='input' autocomplete="off" placeholder="フリーワードを入力してください..">
              </div>
              <div class='user_list_search_select'>
                <select name="select_company">
                  <option value=''>会社を選択</option>
                  <?php foreach ($names as $name) : ?>
                    <option value="<?= $name['company_name'] ?>"><?= $name['company_name'] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class='user_list_search_submit' id="search">
                <!-- <input type="submit" id="search" value='検索'> -->
                <i class="bi bi-search font-weight-bold" width='24' height='24'></i>
              </div>
            </div>
            <div class="message-show">
            </div>
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>名前</th>
                  <th>会社</th>
                  <th>電話番号</th>
                  <th>登録日時</th>
                  <th>操作</th>
                </tr>
              </thead>
              <tbody class="studentdata">
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>

  <!-- ↓footer関数の読み込み -->
  <?php
  include('../_footer.php');  
  ?>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  <script src="../user_list.js"></script>
</body>
</html>