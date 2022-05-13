<!doctype html>
<html lang="ja">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

  <title>PHP - AJAX - CRUD</title>
</head>





<!-- <body>
  <h1>Hello, world!</h1> -->

<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: Bootstrap Bundle with Popper -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script> -->

<!-- Option 2: Separate Popper and Bootstrap JS -->
<!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
<!-- </body> -->

<body>

  <!-- 二本目の動画 基本的にmodal機能のコピペ-->
  <!-- Add Modal -->
  <!-- id変更 -->
  <div class="modal fade" id="Student_AddModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Student Data using jQuery Ajax in php without page reload</h5>
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
            <!-- class名にそれぞれのタイトルを挿入 -->
            <div class="col-md-6">
              <label for="">First Name</label>
              <input type="text" class="form-control fname">
            </div>
            <div class="col-md-6">
              <label for="">Last Name</label>
              <input type="text" class="form-control lname">
            </div>
            <div class="col-md-6">
              <label for="">Class</label>
              <input type="text" class="form-control class">
            </div>
            <div class="col-md-6">
              <label for="">Section</label>
              <input type="text" class="form-control section">
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <!-- クラス名追加　student_add_ajax-->
          <button type="button" class="btn btn-primary student_add_ajax">Save</button>
        </div>
      </div>
    </div>
  </div>

  <!-- 三本目の動画 -->
  <!-- View Modal -->
  <div class="modal fade" id="StudentViewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Student Detail View</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <!-- 要素分だけクラスを追加 -->
        <div class="modal-body">
          <h4 class="id_view"></h4>
          <h4 class="fname_view"></h4>
          <h4 class="lname_view"></h4>
          <h4 class="class_view"></h4>
          <h4 class="section_view"></h4>
          <!-- <h4 class="適当に"></h4> -->
        </div>


        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- 四本目の動画 三本目（詳細のほとんどコピペ）-->
  <!-- Edit Modal -->
  <div class="modal fade" id="StudentEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Student Data</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="row">
            <!-- hiddenを最後に追加 -->
            <input type="hidden" id="id_edit">
            <div class="col-md-12">
              <div class="error-message-update">
              </div>
            </div>
            <!-- class名にそれぞれのタイトルを挿入していたのを消し、新たにidを追加 -->
            <div class="col-md-6">
              <label for="">First Name</label>
              <input type="text" class="form-control" id="edit_fname">
            </div>
            <div class="col-md-6">
              <label for="">Last Name</label>
              <input type="text" class="form-control" id="edit_lname">
            </div>
            <div class="col-md-6">
              <label for="">Class</label>
              <input type="text" class="form-control" id="edit_class">
            </div>
            <div class="col-md-6">
              <label for="">Section</label>
              <input type="text" class="form-control" id="edit_section">
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <!-- クラス名追加　student_add_ajax-->
          <!-- updateに変更　第四回 -->
          <button type="button" class="btn btn-primary student_update_ajax">Update</button>
        </div>
      </div>
    </div>
  </div>



  <!-- 1本目の動画 -->
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4>
              PHP - AJAX - CRUD | Data without page reload using jquery ajax in php.
              <!-- bootstrapに内蔵されているmodal機能追加 -->
              <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#Student_AddModal">
                Add
              </button>
            </h4>
          </div>
          <div class="card-body">
            <div class="message-show">

            </div>
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Class</th>
                  <th>Section</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody class="studentdata">
                <!-- <tr>
                  <td>1</td>
                  <td>Ved</td>
                  <td>Ve</td>
                  <td>Vaaa</td>
                  <td>C</td>
                  <td>
                    <a href="" class='badge btn-info'>VIEW</a>
                    <a href="" class='badge btn-primary'>EDIT</a>
                    <a href="" class='badge btn-danger'>DELETE</a>
                  </td>
                </tr> -->
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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

  <script src="../admin.js"></script>


</body>

</html>