$(document).ready(function () {
  getdata();
});

$('.student_add_ajax').click(function (e) {
  e.preventDefault();

  var company_name = $('.company_name').val();
  var phone_number = $('.phone_number').val();
  var mail_contact = $('.mail_contact').val();
  var mail_manager = $('.mail_manager').val();
  var mail_notification = $('.mail_notification').val();
  var representative = $('.representative').val();
  var address = $('.address').val();
  var company_url = $('.company_url').val();

  if (company_name != '' & phone_number != '' & mail_contact != '' & mail_manager != '' & mail_notification != '' & representative != '' & address != '' & company_url != '') {
    $.ajax({
      type: "POST",
      url: "./crud.php",
      data: {
        'checking_add': true,
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
        // console.log(response);
        $('#Student_AddModal').modal('hide');
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
        $('.fname').val("");
        $('.lname').val("");
        $('.class').val("");
        $('.section').val("");
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



function getdata() {
  $.ajax({
    type: "GET",
    url: "./fetch_company.php",
    success: function (response) {
      $.each(response, function (key, value) {
        $('.studentdata').append('<tr>' +
          '<td class="stud_id">' + value['id'] + '</td>\
                                <td>' + value['company_name'] + '</td>\
                                <td>' + value['phone_number'] + '</td>\
                                <td>' + value['mail_manager'] + '</td>\
                                <td>' + value['representative'] + '</td>\
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

