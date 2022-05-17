$(document).ready(function () {
  getdata();


  $('.company_delete_ajax').click(function (e) {
    e.preventDefault();

    var stud_id = $('#id_delete').val();
    $.ajax({
      type: "POST",
      url: "./crud.php",
      data: {
        // checking_viewからchecking_deleteに変更
        'checking_delete': true,
        'stud_id': stud_id,
      },
      // code.jsのif文のreturnの値がresponseに入る
      success: function (response) {
        // console.log(response);
        $('#companyDeleteModal').modal('hide');
        $('.message-show').append('\
                                <div class="alert alert-success alert-dismissible fade show" role="alert">\
                                    <strong>Heyy!</strong> '+ response + '.\
                                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">\
                                        <span aria-hidden="true">&times;</span>\
                                    </button>\
                                </div>\
                            ');
        $('.studentdata').html("");
        getdata();
      }
    });
  });

  $(document).on("click", ".delete_btn", function () {
    // idを取得　trの中のstud_idというクラスのテキストを取得　一本目参照
    var stud_id = $(this).closest('tr').find('.stud_id').text();
    // 追加
    $('#id_delete').val(stud_id)
    $('#companyDeleteModal').modal('show');

  });



  $('.user_add_ajax').click(function (e) {
    e.preventDefault();

    var name = $('.name').val();
    var university = $('.university').val();
    var department = $('.department').val();
    var grad_year = $('.grad_year').val();
    var mail = $('.mail').val();
    var phone_number = $('.phone_number').val();
    var address = $('.address').val();

    if (name != '' & university != '' & department != '' & grad_year != '' & mail != '' & phone_number != '' & address != '') {
      $.ajax({
        type: "POST",
        url: "./crud_user.php",
        data: {
          'checking_add': true,
          'name': name,
          'university': university,
          'department': department,
          'grad_year': grad_year,
          'mail': mail,
          'phone_number': phone_number,
          'address': address,
        },
        success: function (response) {
          // console.log(response);
          $('#companyAddModal').modal('hide');
          $('.message-show').append('\
                                <div class="alert alert-success alert-dismissible fade show" role="alert">\
                                    <strong>Hey!</strong> '+ response + '.\
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                                        <span aria-hidden="true">&times;</span>\
                                    </button>\
                                </div>\
                            ');
          $('.studentdata').html("");
          getdata();
          $('.name').val("");
          $('.university').val("");
          $('.department').val("");
          $('.grad_year').val("");
          $('.mail').val("");
          $('.phone_number').val("");
          $('.address').val("");
        }
      });

    }
    else {
      // console.log("Please enter all fileds.");
      $('.error-message').append('\
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">\
                            <strong>Hey!</strong> Please enter all fileds.\
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                                <span aria-hidden="true">&times;</span>\
                            </button>\
                        </div>\
                    ');
    }
  })


  $('.student_update_ajax').click(function (e) {
    e.preventDefault();

    // それぞれのinputに書かれた要素を変数に置く
    // updateではidを追加 hiddenで追加されたid
    // そして他の値も変更
    var stud_id = $('#id_edit').val();
    var company_name = $('#company_name_edit').val();
    var phone_number = $('#phone_number_edit').val();
    var mail_contact = $('#mail_contact_edit').val();
    var mail_manager = $('#mail_manager_edit').val();
    var mail_notification = $('#mail_notification_edit').val();
    var representative = $('#representative_edit').val();
    var address = $('#address_edit').val();
    var company_url = $('#company_url_edit').val();

    // すべて代入されていたら処理するよ
    if (company_name != '' & phone_number != '' & mail_contact != '' & mail_manager != '' & mail_notification != '' & representative != '' & address != '' & company_url != '') {
      $.ajax({
        type: "POST",
        url: "./crud.php",
        data: {
          // updateに変更、id追加
          'checking_update': true,
          'stud_id': stud_id,
          'company_name': company_name,
          'phone_number': phone_number,
          'mail_contact': mail_contact,
          'mail_manager': mail_manager,
          'mail_notification': mail_notification,
          'representative': representative,
          'address': address,
          'company_url': company_url,
        },
        success: function (response) {
          console.log(response);
          // Add→Edit
          $('#companyEditModal').modal('hide');
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
      url: "./crud.php",
      data: {
        'checking_edit': true,
        'stud_id': stud_id,
      },
      success: function (response) {
        $.each(response, function (key, compedit) {
          $('#id_edit').val(compedit['id']);
          $('#company_name_edit').val(compedit['company_name']);
          $('#phone_number_edit').val(compedit['phone_number']);
          $('#mail_contact_edit').val(compedit['mail_contact']);
          $('#mail_manager_edit').val(compedit['mail_manager']);
          $('#mail_notification_edit').val(compedit['mail_notification']);
          $('#representative_edit').val(compedit['representative']);
          $('#address_edit').val(compedit['address']);
          $('#company_url_edit').val(compedit['company_url']);
          // $('#id_edit').val(compedit['id']);
          // $('#edit_fname').val(compedit['fname']);
          // $('#edit_lname').val(compedit['lname']);
          // $('#edit_class').val(compedit['class']);
          // $('#edit_section').val(compedit['section']);
        });
        $('#companyEditModal').modal('show');
      }
    });

  });


  //view modal 
  $(document).on("click", ".viewbtn", function () {

    var stud_id = $(this).closest('tr').find('.stud_id').text();

    $.ajax({
      type: "POST",
      url: "./crud.php",
      data: {
        'checking_view': true,
        'stud_id': stud_id,
      },
      success: function (response) {
        // console.log(response);
        $.each(response, function (key, compview) {
          // console.log(compview['fname']);
          $('.id_view').text(compview['id']);
          $('.company_name_view').text(compview['company_name']);
          $('.phone_number_view').text(compview['phone_number']);
          $('.mail_contact_view').text(compview['mail_contact']);
          $('.mail_manager_view').text(compview['mail_manager']);
          $('.mail_notification_view').text(compview['mail_notification']);
          $('.representative_view').text(compview['representative']);
          $('.address_view').text(compview['address']);
          $('.company_url_view').text(compview['company_url']);
        });
        $('#companyViewModal').modal('show');
      }
    });

  });






function getdata() {
  $.ajax({
    type: "GET",
    url: "./fetch_user.php",
    success: function (response) {
      // console.log(response);
      $.each(response, function (key, value) {
        // console.log(value['fname']);
        $('.studentdata').append('<tr>' +
          '<td class="stud_id">' + value['id'] + '</td>\
                                <td>' + value['name'] + '</td>\
                                <td>' + value['phone_number'] + '</td>\
                                <td>' + value['mail'] + '</td>\
                                <td>' + value['address'] + '</td>\
                                <td>\
                                    <a href="#" class="badge btn-info viewbtn">VIEW</a>\
                                    <a href="#" class="badge btn-primary edit_btn">EDIT</a>\
                                    <a href="" class="badge btn-danger">Delete</a>\
                                </td>\
                            </tr>');
      });
    }
  });
  }
});