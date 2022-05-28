<?php
session_start();
require('../../dbconnect.php');
// +--------+
// | name   |
// +--------+
// | 高木   |
// | 千葉   |
// | 目暮   |
// | 佐藤   |
// | 山本   |
// | 佐     |
// | 島     |
// +--------+

if (isset($_SESSION['id']) && $_SESSION['time'] + 10 > time()) {
  $_SESSION['time'] = time();
  // user_idがない、もしくは一定時間を過ぎていた場合
  $id = $_SESSION['id'];
  $sql = "SELECT rep FROM company_user";
  $sql = "SELECT t2.name from company as t1 
inner join admin as t2 
on t1.id=t2.company_id
where t1.id='$id';";
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $names = $stmt->fetchAll();
} else {
  header('Location: http://' . $_SERVER['HTTP_HOST'] . '/admin/login.php');
  exit();
}

// ↓header関数の読み込み ↓うまくいかない、css読み取ってくれない
//src\admin\agent\user_list.php
// src\admin\agent\_parts_agent\_header_agent.php
// include('./_parts_agent/_header_agent.php');
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>agent学生一覧</title>
  <link rel="stylesheet" href="../admin_index.css">
  <link rel="stylesheet" href="../admin_style.css">
  <!-- ↓この_header.phpから見たparts.cssの位置ではなく、このphpファイルが読み込まれるファイルから見た位置を指定してあげる必要がある -->
  <link rel="stylesheet" href="../parts.css">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <!-- icon用 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">

</head>
<!-- header関数読み込み -->
<?php
include('./_parts_agent/_header_agent.php');  
?>

<div class="container">

  <!-- View Modal -->
  <div class="modal fade" id="userViewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel">学生詳細情報</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div>
            <div class="col-md-6 pb-2">
              <h5>ID</h5>
              <p class="id_view"></p>
            </div>
            <div class="col-md-6 pb-2">
              <h5>名前</h5>
              <p class="name_view"></p>
            </div>
            <div class="col-md-6 pb-2">
              <h5>担当者</h5>
              <p class="rep_view"></p>
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
            <!-- <h4 class="phone_number_view"></h4>
            <h4 class="mail_contact_view"></h4>
            <h4 class="mail_manager_view"></h4>
            <h4 class="mail_notification_view"></h4>
            <h4 class="representative_view"></h4>
            <h4 class="address_view"></h4>
            <h4 class="company_url_view"></h4> -->

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
            <div class="col-md-6 mb-3">
              <label for="">担当者</label>
              <input type="text" class="form-control" id="rep_edit">
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



  <div class="container mt-5">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4>
              学生一覧
            </h4>
          </div>
          <div class="card-body">
            <div class='search_container'>
              <div class='user_list_search_text'>
                <input type="text" class='form-control' id='live_search' name='input' autocomplete="off" placeholder="フリーワードを入力してください..">
              </div>
              <div class='user_list_search_select'>
                <select name="select_name">
                  <option value=''>担当者を選択</option>
                  <option value='未割り当て'>未割り当て</option>
                  <?php foreach ($names as $names) : ?>
                    <option value="<?= $names['name'] ?>"><?= $names['name'] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class='user_list_search_submit' id="search"> <i class="bi bi-search font-weight-bold" width='24' height='24'></i>
              </div>
            </div>
            <div class="message-show">
            </div>
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>名前</th>
                  <th>電話番号</th>
                  <th>メールアドレス</th>
                  <th>担当者</th>
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
  <script src="./user_list.js"></script>
</body>
</html>