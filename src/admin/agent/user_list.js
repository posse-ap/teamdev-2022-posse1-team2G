$(document).ready(function () {
  getdata();

  $('.user_update_ajax').click(function (e) {
    e.preventDefault();
    // それぞれのinputに書かれた要素を変数に置く
    // updateではidを追加 hiddenで追加されたid
    // そして他の値も変更
    var stud_id = $('#id_edit').val();
    var rep = $('#rep_edit').val();
    
    // すべて代入されていたら処理するよ
    if (rep != '') {
      $.ajax({
        type: "POST",
        url: "./crud_user.php",
        data: {
          // updateに変更、id追加
          'checking_update': true,
          'stud_id': stud_id,
          'rep': rep,
        },
        success: function (response) {
          console.log(response);
          // Add→Edit
          $('#userEditModal').modal('hide');
          $('.message-show').append('\
                                <div class="alert alert-success alert-dismissible fade show" role="alert">\
                                    <strong>Hey!</strong> '+ response + '.\
                                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">\
                                        <span aria-hidden="true">&times;</span>\
                                    </button>\
                                </div>\
                            ');
          $('.studentdata').html("");
          getdata();
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
                            <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">\
                                <span aria-hidden="true">&times;</span>\
                            </button>\
                        </div>\
                    ');
    }
  });



  // edit modal
  // view modalから持ってきた
  $(document).on("click", ".edit_btn", function () {

    var stud_id = $(this).closest('tr').find('.stud_id').text();
    $.ajax({
      type: "POST",
      url: "./crud_user.php",
      data: {
        'checking_edit': true,
        'stud_id': stud_id,
      },
      success: function (response) {
        $.each(response, function (key, useredit) {
          // console.log(response);
          // #id_editなどinput属性に値（value）を設定
          // #id_editなどpタグに(useredit['id'])を設定

// valとtextで間違えていた
          $('#id_edit').val(useredit['user_id']);
          $('#rep_edit').val(useredit['rep']);
        });
        $('#userEditModal').modal('show');
      }
    });

  });


  //view modal 
  $(document).on("click", ".viewbtn", function () {

    var stud_id = $(this).closest('tr').find('.stud_id').text();

    $.ajax({
      type: "POST",
      url: "./crud_user.php",
      data: {
        'checking_view': true,
        'stud_id': stud_id,
      },
      success: function (response) {
        $.each(response, function (key, userview) {
          $('.id_view').text(userview['id']);
          $('.name_view').text(userview['name']);
          $('.university_view').text(userview['university']);
          $('.department_view').text(userview['department']);
          $('.grad_year_view').text(userview['grad_year']);
          $('.mail_view').text(userview['mail']);
          $('.phone_number_view').text(userview['phone_number']);
          $('.address_view').text(userview['address']);
          $('.rep_view').text(userview['rep']);
        });
        $('#userViewModal').modal('show');
      }
    });

  });




  function getdata(input) {
    $.ajax({
      type: "GET",
      url: "./fetch_user.php",
      data: { input: input },
      success: function (response) {
        $('.studentdata').html(response);
        $.each(response, function (key, value) {
          // stud_idはuserのid
          $('.studentdata').append('<tr>' +
            '<td class="stud_id">' + value['id'] + '</td>\
                                <td>' + value['name'] + '</td>\
                                <td>' + value['phone_number'] + '</td>\
                                <td>' + value['mail'] + '</td>\
                                <td>' + value['rep'] + '</td>\
                                <td>\
                                    <a href="#" class="badge btn-info viewbtn">VIEW</a>\
                                    <a href="#" class="badge btn-primary edit_btn">EDIT</a>\
                                </td>\
                            </tr>');
        });
      }
    });

    $("#live_search").keypress(function (e) {
      if (e.which == 13) {
        var input = $('#live_search').val();
        getdata(input);
      }
    });

  }
});

// $("#live_search").keypress(function (e) {
//   if (e.which == 13) {
//     var input = $('#live_search').val();
//     // getdata(input);
//     alert(input)
//   }
// });