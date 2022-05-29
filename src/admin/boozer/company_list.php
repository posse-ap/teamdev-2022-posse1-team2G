<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="../../normalize.css">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <!-- icon用 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="../parts.css">
  <link rel="stylesheet" href="./boozer_company.css">
  <title>会社一覧</title>
</head>

<!-- header関数読み込み -->
<?php
include('./_parts_boozer/_header_boozer.php');
?>
<div class="container_all">

  <!-- View Modal -->
  <div class="modal fade" id="companyViewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel">会社詳細</h4>
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
              <h5>会社名</h5>
              <p class="company_name_view"></p>
            </div>
            <div class="col-md-6 pb-2">
              <h5>電話番号</h5>
              <p class="phone_number_view"></p>
            </div>
            <div class="col-md-6 pb-2">
              <h5>メールアドレス（contact）</h5>
              <p class="mail_contact_view"></p>
            </div>
            <div class="col-md-6 pb-2">
              <h5>メールアドレス（manager）</h5>
              <p class="mail_manager_view"></p>
            </div>
            <div class="col-md-6  pb-2">
              <h5>メールアドレス（notification）</h5>
              <p class="mail_notification_view"></p>
            </div>
            <div class="col-md-6 pb-2">
              <h5>代表者</h5>
              <p class="representative_view"></p>
            </div>
            <div class="col-md-6 pb-2">
              <h5>住所</h5>
              <p class="address_view"></p>
            </div>
            <div class="col-md-6 pb-2">
              <h5>URL</h5>
              <p class="company_url_view"></p>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


  <!-- Edit Modal -->
  <div class="modal fade" id="companyEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
            <div class="col-md-6">
              <label for="">会社名</label>
              <input type="text" class="form-control" id="company_name_edit">
            </div>
            <div class="col-md-6">
              <label for="">電話番号</label>
              <input type="text" class="form-control" id="phone_number_edit">
            </div>
            <div class="col-md-6">
              <label for="">メールアドレス（contact）</label>
              <input type="text" class="form-control" id="mail_contact_edit">
            </div>
            <div class="col-md-6">
              <label for="">メールアドレス（manager）</label>
              <input type="text" class="form-control" id="mail_manager_edit">
            </div>
            <div class="col-md-6">
              <label for="">メールアドレス（notification）</label>
              <input type="text" class="form-control" id="mail_notification_edit">
            </div>
            <div class="col-md-6">
              <label for="">代表者</label>
              <input type="text" class="form-control" id="representative_edit">
            </div>
            <div class="col-md-6">
              <label for="">住所</label>
              <input type="text" class="form-control" id="address_edit">
            </div>
            <div class="col-md-6">
              <label for="">URL</label>
              <input type="text" class="form-control" id="company_url_edit">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary student_update_ajax">Update</button>
        </div>
      </div>
    </div>
  </div>


  <!-- delete Modal -->
  <div class="modal fade" id="companyDeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
            <div class="col-md-12">
              <h1>本当に削除しますか？</h1>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-danger company_delete_ajax">Yes Delete</button>
        </div>
      </div>
    </div>
  </div>
</div>



<div class="container mt-5 container_all">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4>
            会社一覧

          </h4>
        </div>
        <div class="card-body">
          <div class='company_list_search_container'>
            <div class='company_list_search_input_container'>
              <input type="search" class='form-control company_list_search_input' id='live_search' name='input' autocomplete="off" placeholder="会社名...">
            </div>
            <div class='company_list_search_i_container'>
              <i class="bi bi-search company_list_search_container_icon"></i>
            </div>
          </div>
          <div class="message-show">
          </div>
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>ID</th>
                <th>会社名</th>
                <th>電話番号</th>
                <th>連絡用メールアドレス</th>
                <th>今月の金額</th>
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


<!-- ↓footer関数の読み込み -->
<?php
include('../_footer.php');
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<script src="../company_list.js"></script>


</body>

</html>