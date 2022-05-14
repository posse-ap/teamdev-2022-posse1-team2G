
// 二本目のJS
$(document).ready(function () {
  getdata();

  $('.student_delete_ajax').click(function (e) {
    e.preventDefault();

    var stud_id = $('#id_delete').val();
    $.ajax({
      type: "POST",
      url: "./code.php",
      data: {
        // checking_viewからchecking_deleteに変更
        'checking_delete': true,
        'stud_id': stud_id,
      },
      // code.jsのif文のreturnの値がresponseに入る
      success: function (response) {
        // console.log(response);
        $('#StudentDeleteModal').modal('hide');
        $('.message-show').append('\
                                <div class="alert alert-success alert-dismissible fade show" role="alert">\
                                    <strong>Heyy!</strong> '+ response + '.\
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                                        <span aria-hidden="true">&times;</span>\
                                    </button>\
                                </div>\
                            ');
        $('.studentdata').html("");
        getdata();
      }
    });
  });

  // 第六回　削除ボタン
  $(document).on("click", ".delete_btn", function () {
    // idを取得　trの中のstud_idというクラスのテキストを取得　一本目参照
    var stud_id = $(this).closest('tr').find('.stud_id').text();
    // 追加
    $('#id_delete').val(stud_id)
    $('#StudentDeleteModal').modal('show');

    // $.ajax({
    //   type: "POST",
    //   url: "./code.php",
    //   data: {
    //     // checking_viewからchecking_deleteに変更
    //     'checking_delete': true,
    //     'stud_id': stud_id,
    //   },
    //   // code.jsのif文のreturnの値がresponseに入る
    //   success: function (response) {
    //     // // console.log(response);
    //     // $('#StudentDeleteModal').modal('hide');
    //     $('.message-show').append('\
    //                             <div class="alert alert-success alert-dismissible fade show" role="alert">\
    //                                 <strong>Heyy!</strong> '+ response + '.\
    //                                 <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
    //                                     <span aria-hidden="true">&times;</span>\
    //                                 </button>\
    //                             </div>\
    //                         ');
    //     $('.studentdata').html("");
    //     getdata();
    //   }
    // });

    // $.ajax({
    //   type: "POST",
    //   url: "./code.php",
    //   data: {
    //     // checking_viewからchecking_deleteに変更
    //     'checking_delete': true,
    //     'stud_id': stud_id,
    //   },
    //   // code.jsのif文のreturnの値がresponseに入る
    //   success: function (response) {
    //     // // console.log(response);
    //     $('.message-show').append('\
    //                             <div class="alert alert-success alert-dismissible fade show" role="alert">\
    //                                 <strong>Heyy!</strong> '+ response + '.\
    //                                 <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
    //                                     <span aria-hidden="true">&times;</span>\
    //                                 </button>\
    //                             </div>\
    //                         ');
    //     $('.studentdata').html("");
    //     getdata();


    //     // $.each(response, function (key, studedit) {
    //     //   // console.log(studview['fname']);
    //     //   // textではなくvalue

    //     //   // studeditに変更！
    //     //   $('#id_edit').val(studedit['id']);
    //     //   $('#edit_fname').val(studedit['fname']);
    //     //   $('#edit_lname').val(studedit['lname']);
    //     //   $('#edit_class').val(studedit['class']);
    //     //   $('#edit_section').val(studedit['section']);
    //     // });
    //     // $('#StudentEditModal').modal('show');
    //   }
    // });

  });


  // 第五回　第二回をコピペしたもの　updateを押したときの挙動
  $('.student_update_ajax').click(function (e) {
    e.preventDefault();

    // それぞれのinputに書かれた要素を変数に置く
    // updateではidを追加 hiddenで追加されたid
    // そして他の値も変更
    var stud_id = $('#id_edit').val();
    var fname = $('#edit_fname').val();
    var lname = $('#edit_lname').val();
    var stu_class = $('#edit_class').val();
    var section = $('#edit_section').val();

    // すべて代入されていたら処理するよ
    if (fname != '' & lname != '' & stu_class != '' & section != '') {
      $.ajax({
        type: "POST",
        url: "./code.php",
        data: {
          // updateに変更、id追加
          'checking_update': true,
          'stud_id': stud_id,
          'fname': fname,
          'lname': lname,
          'class': stu_class,
          'section': section,
        },
        success: function (response) {
          console.log(response);
          // Add→Edit
          $('#StudentEditModal').modal('hide');
          $('.message-show').append('\
                                <div class="alert alert-success alert-dismissible fade show" role="alert">\
                                    <strong>Heyy!</strong> '+ response + '.\
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                                        <span aria-hidden="true">&times;</span>\
                                    </button>\
                                </div>\
                            ');
          $('.studentdata').html("");
          getdata();
          // $('.fname').val("");
          // $('.lname').val("");
          // $('.class').val("");
          // $('.section').val("");
        }
      });
    }
    // 入力に不備があった場合
    else {
      // console.log("Please enter all fileds.");
      // デフォルトのエラーメッセージ
      $('.error-message-update').append('\
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">\
                            <strong>Hey!</strong> Please enter all fileds.\
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                                <span aria-hidden="true">&times;</span>\
                            </button>\
                        </div>\
                    ');
    }
  });



  // ----- 第四回　編集ボタン ------
  $(document).on("click", ".edit_btn", function () {
    // idを取得　trの中のstud_idというクラスのテキストを取得　一本目参照
    var stud_id = $(this).closest('tr').find('.stud_id').text();
    // alert(stud_id);

    $.ajax({
      type: "POST",
      url: "./code.php",
      data: {
        // checking_viewからchecking_editに変更
        'checking_edit': true,
        'stud_id': stud_id,
      },
      // code.jsのif文のreturnの値がresponseに入る
      success: function (response) {
        // console.log(response);
        $.each(response, function (key, studedit) {
          // console.log(studview['fname']);
          // textではなくvalue

          // studeditに変更！
          $('#id_edit').val(studedit['id']);
          $('#edit_fname').val(studedit['fname']);
          $('#edit_lname').val(studedit['lname']);
          $('#edit_class').val(studedit['class']);
          $('#edit_section').val(studedit['section']);
        });
        $('#StudentEditModal').modal('show');
      }
    });

  });



  // 三本目　詳細モーダル
  $(document).on("click", ".view_btn", function () {
    // idを取得　trの中のstud_idというクラスのテキストを取得　一本目参照
    var stud_id = $(this).closest('tr').find('.stud_id').text();
    // alert(stud_id);

    $.ajax({
      type: "POST",
      url: "./code.php",
      data: {
        'checking_view': true,
        'stud_id': stud_id,
      },
      // code.jsのif文のreturnの値がresponseに入る
      success: function (response) {
        // console.log(response);
        $.each(response, function (key, studview) {
          // console.log(studview['fname']);
          // TOP画面にはのっていない情報はここで記載（空の要素をindex.phpで用意してから）
          $('.id_view').text(studview['id']);
          $('.fname_view').text(studview['fname']);
          $('.lname_view').text(studview['lname']);
          $('.class_view').text(studview['class']);
          $('.section_view').text(studview['section']);
        });
        $('#StudentViewModal').modal('show');
      }
    });

  });





  // 二本目のJS　途中に三本目の詳細入り組んでいる
  // modalでsaveしますよ
  $('.student_add_ajax').click(function (e) {
    e.preventDefault();

    // それぞれのinputに書かれた要素を変数に置く
    var fname = $('.fname').val();
    var lname = $('.lname').val();
    var stu_class = $('.class').val();
    var section = $('.section').val();

    // console.log(fname);

    // すべて代入されていたら処理するよ
    if (fname != '' & lname != '' & stu_class != '' & section != '') {
      $.ajax({
        type: "POST",
        url: "./code.php",
        data: {
          'checking_add': true,
          'fname': fname,
          'lname': lname,
          'class': stu_class,
          'section': section,
        },
        success: function (response) {
          console.log(response);
          $('#Student_AddModal').modal('hide');
          $('.message-show').append('\
                                <div class="alert alert-success alert-dismissible fade show" role="alert">\
                                    <strong>Heyy!</strong> '+ response + '.\
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                                        <span aria-hidden="true">&times;</span>\
                                    </button>\
                                </div>\
                            ');
          $('.studentdata').html("");
          getdata();
          $('.fname').val("");
          $('.lname').val("");
          $('.class').val("");
          $('.section').val("");
        }
      });

    }
    // 入力に不備があった場合
    else {
      // console.log("Please enter all fileds.");
      // デフォルトのエラーメッセージ
      $('.error-message').append('\
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">\
                            <strong>Hey!</strong> Please enter all fileds.\
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                                <span aria-hidden="true">&times;</span>\
                            </button>\
                        </div>\
                    ');
    }
  });
});









// // 一本目のJS

// $(document).ready(function () {
//   getdata();
// });

// fetch.phpと連携してデータを持ってくる
function getdata() {
  $.ajax({
    type: "GET",
    // fetch.phpからデータを持ってくる
    url: "./fetch.php",
    success: function (response) {
      // console.log(response);
      $.each(response, function (key, value) {
        // console.log(value['fname']);
        $('.studentdata').append('<tr>' +
          // valueの値はキー
          '<td class="stud_id">' + value['id'] + '</td>\
                                <td>' + value['fname'] + '</td>\
                                <td>' + value['lname'] + '</td>\
                                <td>' + value['class'] + '</td>\
                                <td>' + value['section'] + '</td>\
                                <td>\
                                    <a href="#" class="badge btn-info view_btn">VIEW</a>\
                                    <a href="#" class="badge btn-primary edit_btn">EDIT</a>\
                                    <a href="#" class="badge btn-danger delete_btn">Delete</a>\
                                </td>\
                            </tr>');
      });
    }
  });
}