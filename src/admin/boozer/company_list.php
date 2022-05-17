<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.23/datatables.min.css" />

  <title>PHP - AJAX - CRUD</title>
</head>

<body>

  <!-- Add Modal -->
  <div class="modal fade" id="companyAddModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">新規会社追加
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="error-message">

              </div>
            </div>
            <div class="col-md-6">
              <label for="">会社名</label>
              <input type="text" class="form-control company_name">
            </div>
            <div class="col-md-6">
              <label for="">電話番号</label>
              <input type="text" class="form-control phone_number">
            </div>
            <div class="col-md-6">
              <label for="">メールアドレス（contact）</label>
              <input type="text" class="form-control mail_contact">
            </div>
            <div class="col-md-6">
              <label for="">メールアドレス（manager）</label>
              <input type="text" class="form-control mail_manager">
            </div>
            <div class="col-md-6">
              <label for="">メールアドレス（notification）</label>
              <input type="text" class="form-control mail_notification">
            </div>
            <div class="col-md-6">
              <label for="">代表者</label>
              <input type="text" class="form-control representative">
            </div>
            <div class="col-md-6">
              <label for="">住所</label>
              <input type="text" class="form-control address">
            </div>
            <div class="col-md-6">
              <label for="">URL</label>
              <input type="text" class="form-control company_url">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary student_add_ajax">Save</button>
        </div>
      </div>
    </div>
  </div>


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
  <div class="modal fade" id="companyEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">変更する</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <!-- <span aria-hidden="true">&times;</span> -->
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



            <!-- <div class="col-md-6">
              <label for="">First Name</label>
              <input type="text" id="edit_fname" class="form-control">
            </div>
            <div class="col-md-6">
              <label for="">Last Name</label>
              <input type="text" id="edit_lname" class="form-control">
            </div>
            <div class="col-md-6">
              <label for="">Class</label>
              <input type="text" id="edit_class" class="form-control">
            </div>
            <div class="col-md-6">
              <label for="">Section</label>
              <input type="text" id="edit_section" class="form-control">
            </div> -->
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
            <!-- <span aria-hidden="true">&times;</span> -->
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
          <!-- クラス名追加　student_add_ajax-->
          <!-- updateに変更　第四回 -->
          <button type="button" class="btn btn-danger company_delete_ajax">Yes Delete</button>
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
              会社一覧
              <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#companyAddModal">
                Add
              </button>
            </h4>
          </div>
          <div class="card-body">
            <div class="message-show">

            </div>
            <table class="table table-bordered table-striped " id="myTable">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>会社名</th>
                  <th>電話番号</th>
                  <th>メールアドレス</th>
                  <th>今月の金額</th>
                  <th>機能</th>
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

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



  <!-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script> -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script> -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>


  <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.23/datatables.min.js"></script>

  <script src="../jQuery.js"></script>


</body>

</html>