$(document).ready(function () {
  getdata();

  // modal内の削除するボタンを押したときの挙動
  $('.user_delete_ajax').click(function (e) {
    e.preventDefault();

    var stud_id = $('#id_delete').val();
    $.ajax({
      type: "POST",
      url: "./crud_user.php",
      data: {
        'checking_delete': true,
        'stud_id': stud_id,
      },
      success: function (response) {
        $('#userDeleteModal').modal('hide');
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
    
  })

// 削除機能押してみたときの挙動
  $(document).on("click", ".delete_btn", function () {

    var stud_id = $(this).closest('tr').find('.stud_id').text();
    $('#id_delete').val(stud_id)
    $('#userDeleteModal').modal('show');

  });



  $('.user_update_ajax').click(function (e) {
    e.preventDefault();

    // それぞれのinputに書かれた要素を変数に置く
    // updateではidを追加 hiddenで追加されたid
    // そして他の値も変更
    var stud_id = $('#id_edit').val();
    var name = $('#name_edit').val();
    var university = $('#university_edit').val();
    var department = $('#department_edit').val();
    var grad_year = $('#grad_year_edit').val();
    var mail = $('#mail_edit').val();
    var phone_number = $('#phone_number_edit').val();
    var address = $('#address_edit').val();

    // すべて代入されていたら処理するよ
    if (name != '' & university != '' & department != '' & grad_year != '' & mail != '' & phone_number != '' & address != '') {
      $.ajax({
        type: "POST",
        url: "./crud_user.php",
        data: {
          // updateに変更、id追加
          'checking_update': true,
          'stud_id': stud_id,
          'name': name,
          'university': university,
          'department': department,
          'grad_year': grad_year,
          'mail': mail,
          'phone_number': phone_number,
          'address': address,
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
          $('#id_edit').val(useredit['id']);
          $('#name_edit').val(useredit['name']);
          $('#university_edit').val(useredit['university']);
          $('#department_edit').val(useredit['department']);
          $('#grad_year_edit').val(useredit['grad_year']);
          $('#mail_edit').val(useredit['mail']);
          $('#phone_number_edit').val(useredit['phone_number']);
          $('#address_edit').val(useredit['address']);
          // $('#id_edit').val(useredit['id']);
          // $('#edit_fname').val(useredit['fname']);
          // $('#edit_lname').val(useredit['lname']);
          // $('#edit_class').val(useredit['class']);
          // $('#edit_section').val(useredit['section']);
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
          $('.company_name_view').text(userview['company_name']);
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



function getdata(input, select) {
  $.ajax({
    type: "GET",
    url: "./fetch_user.php",
    data: {
      input: input,
      select: select
    },
    success: function (response) {
      // console.log(response);
      $('.studentdata').html(response);
      $.each(response, function (key, value) {
        // console.log(value['fname']);
        $('.studentdata').append('<tr>' +
          '<td class="stud_id">' + value['id'] + '</td>\
                                <td>' + value['name'] + '</td>\
                                <td>' + value['phone_number'] + '</td>\
                                <td>' + value['company_name'] + '</td>\
                                <td>' + value['contact_datetime'] + '</td>\
                                <td>\
                                    <a href="#" class="badge btn-info viewbtn">VIEW</a>\
                                    <a href="#" class="badge btn-primary edit_btn">EDIT</a>\
                                    <a href="#" class="badge btn-danger delete_btn">Delete</a>\
                                </td>\
                            </tr>');
      });
    }
  });
  $('#search').click(function () {

    var input = $('#live_search').val();
    var select = $('[name=select_company]').val();


    if (input != '' && select != '') {
      getdata(input, select);
    }
    // else if (input == '' && select != ''){
    //   getdata(select);
    // }
    // else if (input != '' && select == ''){
    //   getdata(input);
    // }
    else {
      getdata();
    }

  });

  }
});


// $('#search').click(function () {

//   var input = $('#live_search').val();
//   var select = $('[name=select_company]').val();
//   alert(input);

// });