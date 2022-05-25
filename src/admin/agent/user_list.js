$(document).ready(function () {
  getdata();

  // // modal内の削除するボタンを押したときの挙動
  // $('.user_delete_ajax').click(function (e) {
  //   e.preventDefault();

  //   var stud_id = $('#id_delete').val();
  //   $.ajax({
  //     type: "POST",
  //     url: "./crud_user.php",
  //     data: {
  //       'checking_delete': true,
  //       'stud_id': stud_id,
  //     },
  //     success: function (response) {
  //       $('#userDeleteModal').modal('hide');
  //       $('.message-show').append('\
  //                               <div class="alert alert-success alert-dismissible fade show" role="alert">\
  //                                   <strong>Hey!</strong> '+ response + '.\
  //                                   <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">\
  //                                       <span aria-hidden="true">&times;</span>\
  //                                   </button>\
  //                               </div>\
  //                           ');
  //       $('.studentdata').html("");
  //       getdata();
  //     }
  //   });

  // })

  // // 削除機能押してみたときの挙動
  // $(document).on("click", ".delete_btn", function () {

  //   var stud_id = $(this).closest('tr').find('.stud_id').text();
  //   $('#id_delete').val(stud_id)
  //   $('#userDeleteModal').modal('show');

  // });



  $('.user_update_ajax').click(function (e) {
    e.preventDefault();

    // それぞれのinputに書かれた要素を変数に置く
    // updateではidを追加 hiddenで追加されたid
    // そして他の値も変更
    var stud_id = $('#id_edit').val();
    // var name = $('#name_edit').text();
    // var university = $('#university_edit').val();
    // var department = $('#department_edit').val();
    // var grad_year = $('#grad_year_edit').val();
    // var mail = $('#mail_edit').val();
    // var phone_number = $('#phone_number_edit').val();
    // var address = $('#address_edit').val();
    var rep = $('#rep_edit').val();

    // すべて代入されていたら処理するよ
    // if (name != '' & university != '' & department != '' & grad_year != '' & mail != '' & phone_number != '' & address != '') {
    if (rep != '') {
      $.ajax({
        type: "POST",
        url: "./crud_user.php",
        data: {
          // updateに変更、id追加
          'checking_update': true,
          'stud_id': stud_id,
          'rep': rep,
          // 'name': name,
          // 'university': university,
          // 'department': department,
          // 'grad_year': grad_year,
          // 'mail': mail,
          // 'phone_number': phone_number,
          // 'address': address,

          // 'name': name,
          // 'phone_number': phone_number,
          // 'mail_contact': mail_contact,
          // 'mail_manager': mail_manager,
          // 'mail_notification': mail_notification,
          // 'representative': representative,
          // 'address': address,
          // 'company_url': company_url,
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
          $('#id_edit').val(useredit['id']);









          $('#name_edit').text(useredit['name']);
          $('#university_edit').text(useredit['university']);
          $('#department_edit').text(useredit['department']);
          $('#grad_year_edit').text(useredit['grad_year']);
          $('#mail_edit').text(useredit['mail']);
          $('#phone_number_edit').text(useredit['phone_number']);
          $('#address_edit').text(useredit['address']);
          $('#rep_edit').val(useredit['rep']);
          // $('#id_edit').text(useredit['id']);
          // $('#edit_fname').text(useredit['fname']);
          // $('#edit_lname').text(useredit['lname']);
          // $('#edit_class').text(useredit['class']);
          // $('#edit_section').text(useredit['section']);
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


  // $('.user_add_ajax').click(function (e) {
  //   e.preventDefault();

  //   var name = $('.name').val();
  //   var university = $('.university').val();
  //   var department = $('.department').val();
  //   var grad_year = $('.grad_year').val();
  //   var mail = $('.mail').val();
  //   var phone_number = $('.phone_number').val();
  //   var address = $('.address').val();

  //   if (name != '' & university != '' & department != '' & grad_year != '' & mail != '' & phone_number != '' & address != '') {
  //     $.ajax({
  //       type: "POST",
  //       url: "./crud_user.php",
  //       data: {
  //         'checking_add': true,
  //         'name': name,
  //         'university': university,
  //         'department': department,
  //         'grad_year': grad_year,
  //         'mail': mail,
  //         'phone_number': phone_number,
  //         'address': address,
  //       },
  //       success: function (response) {
  //         // console.log(response);
  //         $('#userAddModal').modal('hide');
  //         $('.message-show').append('\
  //                               <div class="alert alert-success alert-dismissible fade show" role="alert">\
  //                                   <strong>Hey!</strong> '+ response + '.\
  //                                   <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
  //                                       <span aria-hidden="true">&times;</span>\
  //                                   </button>\
  //                               </div>\
  //                           ');
  //         $('.studentdata').html("");
  //         getdata();
  //         $('.name').val("");
  //         $('.university').val("");
  //         $('.department').val("");
  //         $('.grad_year').val("");
  //         $('.mail').val("");
  //         $('.phone_number').val("");
  //         $('.address').val("");
  //       }
  //     });

  //   }
  //   else {
  //     // console.log("Please enter all fileds.");
  //     $('.error-message').append('\
  //                       <div class="alert alert-warning alert-dismissible fade show" role="alert">\
  //                           <strong>Hey!</strong> Please enter all fileds.\
  //                           <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
  //                               <span aria-hidden="true">&times;</span>\
  //                           </button>\
  //                       </div>\
  //                   ');
  //   }
  // })



  function getdata(input) {
    $.ajax({
      type: "GET",
      url: "./fetch_user.php",
      data: { input: input },
      success: function (response) {
        $('.studentdata').html(response);
        $.each(response, function (key, value) {
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